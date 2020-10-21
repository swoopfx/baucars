<?php
namespace Customer\Service;

use Customer\Entity\CustomerBooking;
use CsnUser\Entity\User;

/**
 *
 * @author otaba
 *        
 */
class CustomerService
{

    private $auth;

    private $generalService;

    private $entityManager;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
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

