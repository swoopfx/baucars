<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Customer for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use Customer\Service\CustomerService;
use General\Entity\BookingType;
use Customer\Entity\CustomerBooking;
use General\Entity\BookingStatus;
use General\Entity\BookingClass;
use General\Service\FlutterwaveService;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\Query;
use Customer\Entity\BookingActivity;
use Application\Entity\Support;

class CustomerController extends AbstractActionController
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
     * @var CustomerService
     */
    private $customerService;

    /**
     * Provides logic and wrapper for flutterwave service and API
     *
     * @var FlutterwaveService
     */
    private $flutterwaveService;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        
        return $response;
    }

    public function indexAction()
    {
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /customer/customer/foo
        return array();
    }

    public function boardAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function bookingHistoryAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        try {
            $response->setStatusCode(200);
            $jsonModel->setVariables([
                "data" => $this->customerService->getBookingHistory()
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::STATUS_CODE_400);
            $jsonModel->setVariables([
                "messages" => $e->getMessage()
            ]);
        }
        return $jsonModel;
    }

    public function profileAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        try {
            $response->setStatusCode(200);
            $jsonModel->setVariables([
                "datas" => $this->customerService->getProfile()
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::STATUS_CODE_400);
            $jsonModel->setVariables([
                "messages" => $e->getMessage()
            ]);
        }
        return $jsonModel;
    }

    /**
     * Gets all booking Service Type
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function bookingServiceTypeAction()
    {
        $em = $this->entityManager;
        
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $response->setStatusCode(200);
        
        $jsonModel->setVariable("data", $this->customerService->getAllBookingServiceType());
        return $jsonModel;
    }

    public function getop50bookingAction()
    {
        $em = $this->entityManager;
        $response = $this->getResponse();
        $data = $em->getRepository(CustomerBooking::class)->findCustomersBooking($this->identity()
            ->getId());
        $response->setStatusCode(200);
        $jsonModel = new JsonModel([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function bookingClassAction()
    {
        $customerService = $this->customerService;
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel = new JsonModel();
        $jsonModel->setVariable("data", $customerService->getAllBookingClass());
        return $jsonModel;
    }

    public function initiatedBookingAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $response->setStatusCode(200);
        $jsonModel->setVariables([
            "data" => $this->customerService->getAllInitiatedBooking()
        ]);
        return $jsonModel;
    }

    /**
     * A quisk ist of active trips
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function activeBookingAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function billingMethodAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $response->setStatusCode(200);
        $jsonModel->setVariables([
            "data" => $this->customerService->getAllBillingMethod()
        ]);
        return $jsonModel;
    }

    public function cancelbookingAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $id = $post["bookingId"];
            
            try {
                
                /**
                 *
                 * @var CustomerBooking $bookingEntity
                 */
                $bookingEntity = $em->find(CustomerBooking::class, $id);
                // var_dump($id);
                $bookingEntity->setStatus($em->find(BookingStatus::class, CustomerService::BOOKING_STATUS_CANCELED))
                    ->setUpdatedOn(new \DateTime());
                $bookingActivity = new BookingActivity();
                $bookingActivity->setBooking($bookingEntity)
                    ->setCreatedOn(new \DateTime())
                    ->setInformation("Booking {$bookingEntity->getBookingUid()} has been canceled");
                
                // send email
                $em->persist($bookingEntity);
                $em->persist($bookingActivity);
                
                $em->flush();
                
                // integrate funds return logic
                
                $this->flashmessenger()->addSuccessMessage("Booking {$bookingEntity->getBookingUid()} has been canceled");
                $response->setStatusCode(201);
                
                $jsonModel->setVariable("data", $bookingEntity->getBookUid());
            } catch (\Exception $e) {
                $response->setStatusCode(500);
            }
        }
        return $jsonModel;
    }

    /**
     * Creates a booking
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function createBookingAction()
    {
        $em = $this->entityManager;
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $dump = explode("-", $post["bookingDate"]);
            // var_dump(strip_tags($dump[0]));
            // var_dump(strip_tags($dump[1]));
            $startDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[0]));
            $endDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[1]));
            $bookingTypeId = $post["selectedService"];
            $bookingClassId = $post["selectedBookingClass"];
            $billingMethod = $post['selectedBillingMethod'];
            
            $customerService = $this->customerService;
            $customerService->setBookingStartDate($startDate)
                ->setBookingEndData($endDate)
                ->setBookingClass($bookingClassId)
                ->setBillingMethod($billingMethod);
            
            $customerService->calculatePrice();
            $jsonModel->setVariable("gr", $customerService->calculatePrice());
            // try {
            // $booking = new CustomerBooking();
            
            // $booking->setBookingUid(CustomerService::bookingUid())
            // ->setCreatedOn(new \DateTime())
            // ->setEndTime($endDate)
            // ->setStartTime($startDate)
            // ->setUser($this->identity())
            // ->setBookingClass($em->find(BookingClass::class, $bookingClassId))
            // ->setStatus($em->find(BookingStatus::class, CustomerService::BOOKING_STATUS_INITIATED))
            // ->setBookingType($em->find(BookingType::class, $bookingTypeId));
            
            // $em->persist($booking);
            // $em->flush();
            
            // $response->setStatusCode(201);
            // $jsonModel->setVariables([
            // "messages" => "Successfully initated Your Booking"
            // ]);
            // } catch (\Exception $e) {
            // $response->setStatusCode(400);
            // $jsonModel->setVariables([
            // "messages" => $e->getMessage()
            // ]);
            // }
        }
        
        return $jsonModel;
    }

    public function calculatePriceAction()
    {
        $em = $this->entityManager;
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $dump = explode("-", $post["bookingDate"]);
            $startDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[0]));
            $endDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[1]));
            $bookingTypeId = $post["selectedService"];
            $bookingClassId = $post["selectedBookingClass"];
            $billingMethod = $post['selectedBillingMethod'];
            
            $customerService = $this->customerService;
            $customerService->setBookingStartDate($startDate)
                ->setBookingEndData($endDate)
                ->setBookingClass($bookingClassId)
                ->setBillingMethod($billingMethod);
            $customerService->calculatePrice();
            $response->setStatusCode(200);
            $jsonModel->setVariable("price", $customerService->calculatePrice());
        }
        
        return $jsonModel;
    }

    public function initiatepaymentAction()
    {
        $em = $this->entityManager;
        $flutterwaveService = $this->flutterwaveService;
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $dump = explode("-", $post["bookingDate"]);
            $startDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[0]));
            $endDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[1]));
            $bookingTypeId = $post["selectedService"];
            $bookingClassId = $post["selectedBookingClass"];
            $billingMethod = $post['selectedBillingMethod'];
            
            $customerService = $this->customerService;
            $customerService->setBookingStartDate($startDate)
                ->setBookingEndData($endDate)
                ->setBookingClass($bookingClassId)
                ->setBillingMethod($billingMethod);
            $price = $customerService->calculatePrice();
            $txRef = FlutterwaveService::generateTransaction();
            $bookingSession = $customerService->getBookingSession();
            $bookingSession->bookingStartDate = $startDate;
            $bookingSession->bookingEndDate = $endDate;
            $bookingSession->bookingClass = $bookingClassId;
            $bookingSession->billingMethod = $billingMethod;
            $bookingSession->bookingType = $bookingTypeId;
            
            $response->setStatusCode(200);
            
            $jsonModel->setVariables([
                "price" => $price,
                "txref" => $txRef,
                "public_key" => $this->flutterwaveService->getFlutterwavePublicKey()
            
            ]);
        }
        return $jsonModel;
    }

    public function concludepaymentAction()
    {
        $flutterwaveService = $this->flutterwaveService;
        $bookingSession = $this->customerService->getBookingSession();
        $em = $this->entityManager;
        $user = $this->identity();
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $txRef = $post["txRef"];
            $amountPayed = $post["amountPayed"];
            try {
                $verifyData = $flutterwaveService->setTxRef($txRef)->verifyPayment();
                // var_dump($verifyData);
                if ($verifyData->status == "success" && $verifyData->data->chargedamount >= $amountPayed) {
                    
                    $bookinEntity = $this->customerService->setBookingClass($bookingSession->bookingClass)
                        ->setBookingStartDate($bookingSession->bookingStartDate)
                        ->setBookingEndData($bookingSession->bookingEndDate)
                        ->setBookingType($bookingSession->bookingType)
                        ->createBooking();
                    
                    $transactionEntity = $flutterwaveService->setAmountPayed($verifyData->data->chargedamount)
                        ->setTxRef($verifyData->data->txref)
                        ->setFlwId($verifyData->data->txid)
                        ->setFlwRef($verifyData->data->flwref)
                        ->setBooking($bookinEntity)
                        ->setSettledAmount($verifyData->data->amountsettledforthistransaction)
                        ->setTransactStatus(FlutterwaveService::TRANSACTION_STATUS_PAID)
                        ->setTransactUser($this->identity()
                        ->getId())
                        ->hydrateTransaction();
                    
                    $em->persist($bookinEntity);
                    $em->persist($transactionEntity);
                   
                    $em->flush();
                    $flutterwaveService->setTransactionId($transactionEntity->getId());
                    $flutterwaveService->initiateTrasnfer();
                    $response->SetStatusCode(201);
                    $this->flashmessenger()->addSuccessMessage("{$verifyData->data->chargedamount} has been charged from your account and a request is processing");
                    $jsonModel->setVariables([
                        "data" => $verifyData->data->chargedamount
                    ]);

                    // Notify Controller
                    $generalService = $this->generalService;
                    $pointer["to"] = "admin@baucars.com";
                    $pointer["fromName"] = "System Robot";
                    $pointer['subject'] = "New Booking";
                    
                    $template['template'] = "";
                    $template["var"] = [
                        
                    ];
                    $generalService->sendMails($pointer, $template);
                }
            } catch (\Exception $e) {
                $response->setStatusCode(400);
                $jsonModel->setVariable("message", $e->getTrace());
            }
        }
        return $jsonModel;
    }

    public function getsupportsnippetAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $userEntity = $this->identity();
        $repo = $em->getRepository(Support::class);
        $data = $repo->createQueryBuilder("s")
            ->select("s, st")
            ->setMaxResults(10)
            ->where("s.user =" . $userEntity->getId())
            ->leftJoin("s.supportStatus", "st")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response->setStatusCode(200);
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    public function createsupportticketAction()
    {}

    public function sendsupportmessageAction()
    {}

    public function getSubscribtionAction()
    {
        $jsonModel = new JsonModel();
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
     * @return the $customerService
     */
    public function getCustomerService()
    {
        return $this->customerService;
    }

    /**
     *
     * @param \Customer\Service\CustomerService $customerService            
     */
    public function setCustomerService($customerService)
    {
        $this->customerService = $customerService;
        return $this;
    }

    /**
     *
     * @return the $flutterwaveService
     */
    public function getFlutterwaveService()
    {
        return $this->flutterwaveService;
    }

    /**
     *
     * @param \General\Service\FlutterwaveService $flutterwaveService            
     */
    public function setFlutterwaveService($flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
        return $this;
    }
}
