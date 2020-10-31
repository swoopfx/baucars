<?php
namespace Customer\Service;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Customer\Entity\CustomerBooking;

/**
 *
 * @author otaba
 *        
 */
class BookingService
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    // private
    
    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function getAllInititedBookingCount()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder('a')
            ->where('a.status=' . CustomerService::BOOKING_STATUS_INITIATED)
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    public function getSplashInitiatedBooking()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("a")
        ->select('a, s, bt, bc')
            ->where('a.status=' . CustomerService::BOOKING_STATUS_INITIATED)
            ->leftJoin("a.status", "s")
            ->leftJoin("a.bookingType", "bt")
            ->leftJoin("a.bookingClass", "bc")
//             ->le
            ->setMaxResults(50)->getQuery()->getArrayResult();
        return $result;
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
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
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
     * @param \Zend\Authentication\AuthenticationService $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }
}

