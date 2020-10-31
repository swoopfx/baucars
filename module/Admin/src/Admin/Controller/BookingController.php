<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;
use Customer\Service\BookingService;

/**
 *
 * @author otaba
 *        
 */
class BookingController extends AbstractActionController
{

    /**
     * 
     * @var  BookingService
     */
    private $bookingService;

    /**
     * 
     * @var EntityManager
     */
    private $entityManager;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function initiatedbookingcountAction(){
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel->setVariable("count", $this->bookingService->getAllInititedBookingCount());
        return $jsonModel;
    }
    
    
   public function splashinitiatedbookingAction(){
       $jsonModel = new JsonModel();
       $response = $this->getResponse();
       $response->setStatusCode(200);
       $jsonModel->setVariable("data", $this->bookingService->getSplashInitiatedBooking());
       return $jsonModel;
   }
    
    public function testAction(){
        return new JsonModel([
            "count"=>7
        ]);
    }
    
    // public function

    /**
     * @return the $bookingService
     */
    public function getBookingService()
    {
        return $this->bookingService;
    }

    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Admin\Controller\BookingService $bookingService
     */
    public function setBookingService($bookingService)
    {
        $this->bookingService = $bookingService;
        return $this;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}

