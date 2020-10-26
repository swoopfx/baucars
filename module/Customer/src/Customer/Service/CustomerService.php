<?php
namespace Customer\Service;

use Customer\Entity\CustomerBooking;
use CsnUser\Entity\User;
use Doctrine\ORM\EntityManager;
use General\Entity\BookingClass;

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
    
    const BILLING_METHOD_HOURLY = 10;
    
    const BILLING_METHOD_DAILY = 100;

    const BOOKING_CLASS_REGULAR = 10;

    const BOOKING_CLASS_EXECUTIVE = 100;

    const BOOKING_SUBSCRIPTION = 20;

    const BOOKING_INSTANT = 50;

    const BOOKING_STATUS_INITIATED = 5;

    const BOOKING_STATUS_ACTIVE = 10;

    const BOOKING_STATUS_CANCELED = 100;

    const BOOKING_STATUS_PROCESSING = 500;

    const BOOKING_STATUS_PAID = 20;

    const BOOKING_STATUS_COMPLETED = 30;

    const BOOKING_STATUS_UNPAID = 200;

    const BOOKING_STATUS_PENDING = 300;

    /**
     *
     * @var \DateTime
     */
    private $bookingStartDate;

    /**
     *
     * @var \DateTime
     */
    private $bookingEndData;

    /**
     *
     * @var string
     */
    private $billingMethod;

    /**
     * 
     * @var string
     */
    private $bookingClass;

    /**
     *
     * @var string
     */
    private $bookingService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    private function calculateTimeInHours()
    {
        $diff = $this->bookingEndData->diff($this->bookingStartDate);
        $hours =  $diff->h;
        return $hours + ($diff->days*24);
    }

    private function calculateTimeInDays()
    {
        $diff = $this->bookingEndData->diff($this->bookingStartDate);
        return $diff->days;
    }
    
    private function getClassPrice($classId){
        $em = $this->entityManager;
        $entity = $em->find(BookingClass::class, $classId);
        return $entity;
    }

    public function calculatePrice()
    {
        $billingClass = $this->getClassPrice($this->bookingClass);
        if($this->billingMethod == self::BILLING_METHOD_HOURLY){
            $totalHours = $this->calculateTimeInHours();
            $totalHours  = ($totalHours == 0 ? 1 : $totalHours);
            $totalPrice = $totalHours * $billingClass->getPricingPerHour();
            return $totalPrice;
        }else{
            $totalDays = $this->calculateTimeInDays();
            $totalDays = ($totalDays == 0 ? 1 : $totalDays);
            $totalPrice = $totalDays * $billingClass->getPricingPerDay();
            return $totalPrice;
        }
    }

    public static function bookingUid()
    {
        return uniqid("book");
    }

    public function getBookingHistory()
    {
        if ($this->auth == null) {
            throw new \Exception("Not authenticated user");
        }
        //
        $em = $this->entityManager;
        $history = $em->getRepository(CustomerBooking::class)->findBookingHistory($this->auth->getIdentity()
            ->getId());
        return $history;
    }

    public function getProfile()
    {
        if ($this->auth == null)
            throw new \Exception("Not Authenticated");
        $em = $this->entityManager;
        $profile = $em->getRepository(User::class)->findCustomerProfile($this->auth->getIdentity()
            ->getId());
        return $profile;
    }

    public function getAllBookingServiceType()
    {
        return $this->entityManager->getRepository(CustomerBooking::class)->getAllBookingType();
    }

    public function getAllBookingClass()
    {
        return $this->entityManager->getRepository(CustomerBooking::class)->findAllBookingClass();
    }

    public function getAllInitiatedBooking()
    {
        return $this->entityManager->getRepository(CustomerBooking::class)->findAllInititedBooking($this->auth->getIdentity()
            ->getId());
    }

    public function getAllBillingMethod()
    {
        return $this->entityManager->getRepository(CustomerBooking::class)->findBillingMethod();
    }

    // public function
    /**
     *
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
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
     * @param field_type $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @param field_type $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param field_type $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
    /**
     * @return the $bookingStartDate
     */
    public function getBookingStartDate()
    {
        return $this->bookingStartDate;
    }

    /**
     * @return the $bookingEndData
     */
    public function getBookingEndData()
    {
        return $this->bookingEndData;
    }

    /**
     * @return the $billingMethod
     */
    public function getBillingMethod()
    {
        return $this->billingMethod;
    }

    /**
     * @return the $bookingClass
     */
    public function getBookingClass()
    {
        return $this->bookingClass;
    }

    /**
     * @return the $bookingService
     */
    public function getBookingService()
    {
        return $this->bookingService;
    }

    /**
     * @param DateTime $bookingStartDate
     */
    public function setBookingStartDate($bookingStartDate)
    {
        $this->bookingStartDate = $bookingStartDate;
        return $this;
    }

    /**
     * @param DateTime $bookingEndData
     */
    public function setBookingEndData($bookingEndData)
    {
        $this->bookingEndData = $bookingEndData;
        return $this;
    }

    /**
     * @param string $billingMethod
     */
    public function setBillingMethod($billingMethod)
    {
        $this->billingMethod = $billingMethod;
        return $this;
    }

    /**
     * @param string $bookingClass
     */
    public function setBookingClass($bookingClass)
    {
        $this->bookingClass = $bookingClass;
        return $this;
    }

    /**
     * @param string $bookingService
     */
    public function setBookingService($bookingService)
    {
        $this->bookingService = $bookingService;
        return $this;
    }

}

