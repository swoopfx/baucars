<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;
use Customer\Service\BookingService;
use Zend\View\Model\ViewModel;
use Customer\Entity\CustomerBooking;
use Customer\Paginator\AllBookingAdapter;
use Zend\Mvc\MvcEvent;
use Customer\Service\CustomerService;
use Doctrine\ORM\Query;
use Customer\Entity\Bookings;

/**
 *
 * @author otaba
 *        
 */
class BookingController extends AbstractActionController
{

    /**
     *
     * @var BookingService
     */
    private $bookingService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var AllBookingAdapter
     */
    private $allBookingPaginator;

    private $initiTitedBooking;

    private $activeBooking;

    private $cancelBooking;

    private $upcomgBooking;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        
        return $response;
    }

    public function boardAction()
    {
        // var_dump(count($this->entityManager->getRepository(CustomerBooking::class)->findBookingItems(0, 10)));
        $allBooking = $this->allBookingPaginator;
        // var_dump($allBooking);
        $viewModel = new ViewModel([
            "allBooking" => $allBooking
        ]);
        return $viewModel;
    }

    public function initiatedAction()
    {
        $allBooking = $this->initiTitedBooking;
        $viewModel = new ViewModel([
            "allBooking" => $allBooking
        ]);
        return $viewModel;
    }

    /**
     * A list of active trip in decing order
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function activeAction()
    {
        $allBooking = $this->activeBooking;
        $viewModel = new ViewModel([
            "allBooking" => $allBooking
        ]);
        return $viewModel;
    }

    /**
     * A list of canceld booking in descending order
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function cancelAction()
    {
        $allBooking = $this->cancelBooking;
        $viewModel = new ViewModel([
            "allBooking" => $allBooking
        ]);
        return $viewModel;
    }

    /**
     * Defines all upcoming initite
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function upcomingAction()
    {
        $allBooking = $this->upcomgBooking;
        $viewmodel = new ViewModel([
            "allBooking" => $allBooking
        ]);
        return $viewmodel;
    }

    public function viewAction()
    {
        $em = $this->entityManager;
        $viewModel = new ViewModel();
        $bookingUid = $this->params()->fromRoute("id", NULL);
        if ($bookingUid == NULL) {
            return $this->redirect()->toRoute("admin/default", array(
                "controller" => "booking",
                "action" => "board"
            ));
        } else {
            // var_dump($bookingUid);
            $data = $em->getRepository(Bookings::class)->findOneBy([
                "bookingUid" => $bookingUid
            ]);
            
            $viewModel->setVariables([
                "data" => $data
            ]);
        }
        
        return $viewModel;
    }

    public function completedAction()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class)
            ->createQueryBuilder('s')
            ->select("s, u, t, ad, adu")
            ->leftJoin("s.user", "u")
            ->leftJoin("s.trip", "t")
            ->leftJoin("s.assignedDriver", "ad")
            ->leftJoin("ad.user", "adu")
            ->where("s.status = :status")
            ->setParameters([
                "status"=>CustomerService::BOOKING_STATUS_COMPLETED
            ])
            ->setMaxResults(100)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $viewModel = new ViewModel([
            "data"=>$repo
        ]);
        return $viewModel;
    }

    public function initiatedbookingcountAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel->setVariable("count", $this->bookingService->getAllInititedBookingCount());
        return $jsonModel;
    }

    public function splashinitiatedbookingAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel->setVariable("data", $this->bookingService->getSplashInitiatedBooking());
        return $jsonModel;
    }

    public function splashcanceledbookingAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $repo = $em->getRepository(Bookings::class);
        $result = $repo->createQueryBuilder("a")
            ->select('a, s, bc')
            ->leftJoin("a.status", "s")
            ->
        // ->leftJoin("a.bookingType", "bt")
        leftJoin("a.bookingClass", "bc")
            ->where("a.status =" . CustomerService::BOOKING_STATUS_CANCELED)
            ->setMaxResults(50)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel->setVariable("data", $result);
        return $jsonModel;
    }

    public function splashtransitbookingAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $repo = $em->getRepository(Bookings::class);
        $result = $repo->createQueryBuilder("a")
            ->select('a, s, t, bc')
            ->leftJoin("a.status", "s")
            ->leftJoin("a.trip", "t")
            ->leftJoin("a.bookingClass", "bc")
            ->where("a.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_ACTIVE
        ])
            ->setMaxResults(50)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel->setVariable("data", $result);
        return $jsonModel;
    }

    // public function
    
    /**
     *
     * @return the $bookingService
     */
    public function getBookingService()
    {
        return $this->bookingService;
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
     * @param \Admin\Controller\BookingService $bookingService            
     */
    public function setBookingService($bookingService)
    {
        $this->bookingService = $bookingService;
        return $this;
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
     * @return the $allBookingPaginator
     */
    public function getAllBookingPaginator()
    {
        return $this->allBookingPaginator;
    }

    /**
     *
     * @param \Customer\Paginator\AllBookingAdapter $allBookingPaginator            
     */
    public function setAllBookingPaginator($allBookingPaginator)
    {
        $this->allBookingPaginator = $allBookingPaginator;
        return $this;
    }

    /**
     *
     * @return the $initiTitedBooking
     */
    public function getInitiTitedBooking()
    {
        return $this->initiTitedBooking;
    }

    /**
     *
     * @return the $activeBooking
     */
    public function getActiveBooking()
    {
        return $this->activeBooking;
    }

    /**
     *
     * @return the $cancelBooking
     */
    public function getCancelBooking()
    {
        return $this->cancelBooking;
    }

    /**
     *
     * @param field_type $initiTitedBooking            
     */
    public function setInitiTitedBooking($initiTitedBooking)
    {
        $this->initiTitedBooking = $initiTitedBooking;
        return $this;
    }

    /**
     *
     * @param field_type $activeBooking            
     */
    public function setActiveBooking($activeBooking)
    {
        $this->activeBooking = $activeBooking;
        return $this;
    }

    /**
     *
     * @param field_type $cancelBooking            
     */
    public function setCancelBooking($cancelBooking)
    {
        $this->cancelBooking = $cancelBooking;
        return $this;
    }

    /**
     *
     * @return the $upcomgBooking
     */
    public function getUpcomgBooking()
    {
        return $this->upcomgBooking;
    }

    /**
     *
     * @param field_type $upcomgBooking            
     */
    public function setUpcomgBooking($upcomgBooking)
    {
        $this->upcomgBooking = $upcomgBooking;
        return $this;
    }
}

