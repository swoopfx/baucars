<?php
namespace Customer\Service;

use Customer\Entity\CustomerBooking;
use CsnUser\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 *
 * @author otaba
 *        
 */
class CustomerService
{

    private $auth;

    private $generalService;

    /**
     * 
     * @var EntityManager
     */
    private $entityManager;
    
    const BOOKING_SUBSCRIPTION = 20;
    
    const BOOKING_INSTANT = 50;
    
    const BOOKING_STATUS_INITIATED = 5;
    
    const BOOKING_STATUS_ACTIVE = 10;
    
    const BOOKING_STATUS_CANCELED = 100;
    
    const BOOKING_STATUS_PROCESSING = 500;
    
    const BOOKING_STATUS_PAID= 20;
    
    const BOOKING_STATUS_COMPLETED = 30;
    
    const BOOKING_STATUS_UNPAID = 200;
    
    const BOOKING_STATUS_PENDING = 300;
    

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public static function bookingUid(){
        return uniqid("book");
    }
    
    public function getBookingHistory(){
        if($this->auth ==  null){
            throw new \Exception("Not authenticated user");
        }
//     
        $em = $this->entityManager;
        $history = $em->getRepository(CustomerBooking::class)->findBookingHistory($this->auth->getIdentity()->getId());
        return $history;
    }
    
    public function getProfile(){
        if($this->auth == null)
            throw  new \Exception("Not Authenticated");
        $em = $this->entityManager;
        $profile = $em->getRepository(User::class)->findCustomerProfile($this->auth->getIdentity()->getId());
        return $profile;
    }
    
    public function getAllBookingServiceType(){
        return $this->entityManager->getRepository(CustomerBooking::class)->getAllBookingType();
    }
    
    public function getAllInitiatedBooking(){
        return $this->entityManager->getRepository(CustomerBooking::class)->findAllInititedBooking($this->auth->getIdentity()->getId());
    }
    
    
//     public function 
    /**
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param field_type $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * @param field_type $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

