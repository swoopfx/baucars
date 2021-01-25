<?php
namespace Driver\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Driver\Service\DriverService;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Customer\Entity\Bookings;
use Doctrine\ORM\Query;
use Customer\Service\CustomerService;
use Customer\Entity\BookingActivity;
use Customer\Entity\ActiveTrip;
use Driver\Entity\DriverBio;
use General\Entity\BookingStatus;

/**
 *
 * @author otaba
 *        
 */
class BoardController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var DriverService
     */
    private $driverService;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        
        return $response;
    }

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function boardAction()
    {
        $userEntity = $this->identity();
        $viewModel = new ViewModel([
            "user" => $userEntity
        ]);
        return $viewModel;
    }

    public function previousTripsAction()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
        $data = $repo->createQueryBuilder("p")
            ->where("p.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_COMPLETED
        ])
            ->orderBy("desc", "p.id")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    /**
     * This gets the present active trip or in transit
     * As there can only be one active trip at a time
     */
    public function activeTripAction()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
        $data = $repo->createQueryBuilder("b")
            ->select([
            "b, c,  a"
        ])
            ->leftJoin("b.assignedDriver", "a")
            ->leftJoin("b.user", "c")
            ->where("a.user = :user")
            ->andWhere("b.status = :status")
            ->setParameters([
            "user" => $this->identity()
                ->getId(),
            "status" => CustomerService::BOOKING_STATUS_ACTIVE
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel = new JsonModel();
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    public function assignedBookingAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
        $data = $repo->createQueryBuilder("b")
            ->select([
            "b, c,  a"
        ])
            ->leftJoin("b.assignedDriver", "a")
            ->leftJoin("b.user", "c")
            ->where("a.user = :user")
            ->andWhere("b.status = :status")
            ->setParameters([
            "user" => $this->identity()
                ->getId(),
            "status" => CustomerService::BOOKING_STATUS_ASSIGN
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        
        // var_dump($data);
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    public function completedtripsAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
        $data = $repo->createQueryBuilder("b")
            ->select("b,t,u, a")
            ->leftJoin("b.trip", "t")
            ->leftJoin("b.user", "u")
            ->leftJoin("b.assignedDriver", "a")
            ->orderBy("b.id", "desc")
            ->where("a.user = :user")
            ->andWhere("b.status = :status")
            ->setParameters([
            "user" => $this->identity()
                ->getId(),
            "status" => CustomerService::BOOKING_STATUS_COMPLETED
        ])
            ->setMaxResults(50)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response->setStatusCode(200);
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    // Driver Action
    public function starttripAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            
            // var_dump($em);
            $id = $post["bookingId"];
            /**
             *
             * @var Bookings $bookingEntity
             */
            $bookingEntity = $em->find(Bookings::class, $id);
            $bookingEntity->setUpdatedOn(new \DateTime())->setStatus($em->find(BookingStatus::class, CustomerService::BOOKING_STATUS_ACTIVE));
            
            $bookActivity = new BookingActivity();
            $bookActivity->setBooking($bookingEntity)
                ->setCreatedOn(new \DateTime())
                ->setInformation("Driver Started trip");
            
            /**
             *
             * @var Ambiguous $assignedDriver
             */
            $assignedDriver = $bookingEntity->getAssignedDriver()->setDriverState($em->find(DriverBio::class, DriverService::DRIVER_STATUS_ENGAGED));
            $activeTrip = new ActiveTrip();
            
            $activeTrip->setBooking($bookingEntity)
                ->setActiveTripUid(uniqid("atrip"))
                ->setCreatedOn(new \DateTime())
                ->setStarted(new \DateTime());
            try {
                
                $em->persist($assignedDriver);
                $em->persist($bookingEntity);
                $em->persist($bookingEntity);
                $em->persist($activeTrip);
                
                $em->flush();
                
                // Send email to controller
                // Notify controller
                
                $response->setStatusCode(201);
            } catch (\Exception $e) {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "messages" => "something went wrong",
                    "data" => $e->getMessage()
                ]);
            }
        }
        
        return $jsonModel;
    }

    public function bypassAction()
    {
        $jsonModel = new JsonModel();
        $generalService = $this->generalService;
        $em = $this->entityManager;
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            if ($post["code"] == "" || $post["code"] == NULL) {
                $response->setStatusCode(422);
                $jsonModel->setVariable("messages", "Invalid Ientifier");
                return $jsonModel;
            }
            $code = $post["code"];
            $id = $post["id"]; // booking Id
            
            $byPassCode = ($em->find(Bookings::class, $id))->getByPassCode();
            if ($byPassCode == $code) {
                
                try {
//                     $id = $post["bookingId"];
                    
                    // initiate trip
                    /**
                     *
                     * @var Bookings $bookingEntity
                     */
                    $bookingEntity = $em->find(Bookings::class, $id);
                    $bookingEntity->setUpdatedOn(new \DateTime())->setStatus($em->find(BookingStatus::class, CustomerService::BOOKING_STATUS_ACTIVE));
                    
                    $bookActivity = new BookingActivity();
                    $bookActivity->setBooking($bookingEntity)
                        ->setCreatedOn(new \DateTime())
                        ->setInformation("Driver Started trip");
                    
                    /**
                     *
                     * @var Ambiguous $assignedDriver
                     */
                    $assignedDriver = $bookingEntity->getAssignedDriver()->setDriverState($em->find(DriverBio::class, DriverService::DRIVER_STATUS_ENGAGED));
                    $activeTrip = new ActiveTrip();
                    
                    $activeTrip->setBooking($bookingEntity)
                        ->setActiveTripUid(uniqid("atrip"))
                        ->setCreatedOn(new \DateTime())
                        ->setStarted(new \DateTime());
                    
                    // send email of bypass// notify customer of byPass
                    $pointer["to"] = $bookingEntity->getUser()->getEmail();
                    $pointer["fromName"] = "Bau Cars System";
                    $pointer['subject'] = "Trip By Pass Initiated";
                    
                    $template['template'] = "driver-bypass-notification-email";
                    $template["var"] = [
                        "logo" => $this->url()->fromRoute('application', [
                            'action' => 'application'
                        ], [
                            'force_canonical' => true
                        ]) . "assets/img/logo.png",
                        "bookingUid" => $bookingEntity->getBookingUid(),
                        "byPassLink" => $bookingEntity->getUser()->getFullName()
                        // "cancelDate" => $bookingEntity->getUpdatedOn()
                    ];
                    $generalService->sendMails($pointer, $template);
                    
                    // send sms of bypass
                    
                    $em->persist($activeTrip);
                    $em->persist($bookActivity);
                    $em->persist($bookingEntity);
                    
                    $em->flush();
                    
                    $this->flashmessenger()->addSuccessMessage("Successfully bypassed the trip");
                    $response->setStatusCode(201);
                    $jsonModel->setVariable("data", '');
                } catch (\Exception $e) {
                    $response->setStatusCode(422);
                    $jsonModel->setVariable("messages", $e->getMessage());
                }
            } else {
                $response->setStatusCode(422);
                $jsonModel->setVariable("messages", "Invalid By Pass Code");
            }
        } else {
            // return bad request
        }
        return $jsonModel;
    }

    public function endtripAction()
    {
        $em = $this->entityManager;
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            
            $id = $post["bookingId"];
            try {
                /**
                 *
                 * @var Bookings $bookingEntity
                 */
                $bookingEntity = $em->find(Bookings::class, $id);
                $bookingEntity->setUpdatedOn(new \DateTime())->setStatus($em->find(BookingStatus::class, CustomerService::BOOKING_STATUS_COMPLETED));
                
                $bookActivity = new BookingActivity();
                $bookActivity->setBooking($bookingEntity)
                    ->setCreatedOn(new \DateTime())
                    ->setInformation("Driver ended trip");
                
                /**
                 *
                 * @var DriverBio $assignedDriver
                 */
                $assignedDriver = $bookingEntity->getAssignedDriver()->setDriverState($em->find(DriverBio::class, DriverService::DRIVER_STATUS_FREE));
                $activeTrip = $bookingEntity->getTrip();
                
                $activeTrip->setBooking($bookingEntity)
                    ->setUpdatedOn(new \DateTime())
                    ->setEnded(new \DateTime());
                
                $em->persist($bookActivity);
                $em->persist($bookingEntity);
                $em->persist($assignedDriver);
                $em->persist($activeTrip);
                
                
                
                $em->flush();
                
                $response->setStatusCode(201);
                
                // Send Email
                $pointer["to"] = $bookingEntity->getUser()->getEmail();
                $pointer["fromName"] = "Trip Receipt";
                $pointer['subject'] = "Trip By Pass Initiated";
                
                $template['template'] = "driver-bypass-notification-email";
                $template["var"] = [
                    "logo" => $this->url()->fromRoute('application', [
                        'action' => 'application'
                    ], [
                        'force_canonical' => true
                    ]) . "assets/img/logo.png",
                    "bookingUid" => $bookingEntity->getBookingUid(),
                    "byPassLink" => $bookingEntity->getUser()->getFullName()
                    // "cancelDate" => $bookingEntity->getUpdatedOn()
                ];
                $generalService->sendMails($pointer, $template);
                // Receipt to 
                // amotize account
            } catch (\Exception $e) {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "messages" => "Something Went wrong",
                    "data" => $e->getMessage()
                ]);
            }
        }
        
        return $jsonModel;
    }

    public function getByPassCodeAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $bookingId = $post["id"];
            if ($bookingId == NULL) {
                $response->setStatusCode(422);
                $jsonModel->setVariable("messages", "Absent Identifier");
                return $jsonModel;
            }
            /**
             *
             * @var Bookings $bookingEntity
             */
            $bookingEntity = $em->find(Bookings::class, $bookingId);
            $byPassCode = $bookingEntity->getByPassCode();
            $response->setStatusCode(200);
            $jsonModel->setVariable("data", $byPassCode);
        } else {
            $response->setStatusCode(400);
            $jsonModel->setVariable("messages", "Invalid Action taken");
        }
        return $jsonModel;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @return the $driverService
     */
    public function getDriverService()
    {
        return $this->driverService;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \Driver\Service\DriverService $driverService            
     */
    public function setDriverService($driverService)
    {
        $this->driverService = $driverService;
        return $this;
    }
}

