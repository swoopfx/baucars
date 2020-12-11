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
     * @return \Zend\View\Model\ViewModel
     */
    public function upcomingAction(){
        $allBooking = $this->upcomgBooking;
        $viewmodel= new ViewModel([
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
            $data = $em->getRepository(CustomerBooking::class)->findOneBy([
                "bookingUid" => $bookingUid
            ]);
            
            $viewModel->setVariables([
                "data" => $data
            ]);
        }
        
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
        $repo = $em->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("a")
            ->select('a, s, bt, bc')
            ->leftJoin("a.status", "s")
            ->leftJoin("a.bookingType", "bt")
            ->leftJoin("a.bookingClass", "bc")
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
        $repo = $em->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("a")
            ->select('a, s, bt, bc')
            ->leftJoin("a.status", "s")
            ->leftJoin("a.bookingType", "bt")
            ->leftJoin("a.bookingClass", "bc")
            ->where("a.status =" . CustomerService::BOOKING_STATUS_IN_TRANSIT)
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
     * @return the $initiTitedBooking
     */
    public function getInitiTitedBooking()
    {
        return $this->initiTitedBooking;
    }

    /**
     * @return the $activeBooking
     */
    public function getActiveBooking()
    {
        return $this->activeBooking;
    }

    /**
     * @return the $cancelBooking
     */
    public function getCancelBooking()
    {
        return $this->cancelBooking;
    }

    /**
     * @param field_type $initiTitedBooking
     */
    public function setInitiTitedBooking($initiTitedBooking)
    {
        $this->initiTitedBooking = $initiTitedBooking;
        return $this;
    }

    /**
     * @param field_type $activeBooking
     */
    public function setActiveBooking($activeBooking)
    {
        $this->activeBooking = $activeBooking;
        return $this;
    }

    /**
     * @param field_type $cancelBooking
     */
    public function setCancelBooking($cancelBooking)
    {
        $this->cancelBooking = $cancelBooking;
        return $this;
    }
    /**
     * @return the $upcomgBooking
     */
    public function getUpcomgBooking()
    {
        return $this->upcomgBooking;
    }

    /**
     * @param field_type $upcomgBooking
     */
    public function setUpcomgBooking($upcomgBooking)
    {
        $this->upcomgBooking = $upcomgBooking;
        return $this;
    }


}

