<?php
namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use Customer\Service\BookingService;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use General\Entity\NumberOfSeat;
use Doctrine\ORM\Query;
use Zend\Mvc\MvcEvent;
use General\Service\FlutterwaveService;

/**
 *
 * @author otaba
 *        
 */
class BookingsController extends AbstractActionController
{

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var BookingService
     */
    private $bookingService;
    
    /**
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

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function numberofseatsAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $repo = $em->getRepository(NumberOfSeat::class);
        $data = $repo->createQueryBuilder("n")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response->setStatusCode(200);
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    public function initiateBookingAction()
    {
        $bookingService = $this->bookingService;
        $em = $this->entityManager;
        $request = $this->getRequest();
        if($request->isPost()){
            $post = $request->getPost()->toArray();
            $bookingSession = $this->bookingService->getBookingSession();
            if($post["pickUpAddress"] != ""){
                // getDistance from distance matrix
                // Set Value
                $bookingSession->pickUpPlaceId= $post["pickUpPlaceId"];
                $bookingSession->destinationPlaceId = $post["destinationPlaceId"];
                $bookingService->distanceMatrix();
                
            }
        }
        $jsonModel = new JsonModel();
        return $jsonModel;
    }
    
//     public function calcul

    public function completeBookingAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function boardAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
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
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

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
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
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
     * @param \Customer\Service\BookingService $bookingService            
     */
    public function setBookingService($bookingService)
    {
        $this->bookingService = $bookingService;
        return $this;
    }
    /**
     * @return the $flutterwaveService
     */
    public function getFlutterwaveService()
    {
        return $this->flutterwaveService;
    }

    /**
     * @param \General\Service\FlutterwaveService $flutterwaveService
     */
    public function setFlutterwaveService($flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
        return $this;
    }

}

