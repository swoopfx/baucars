<?php
namespace Customer\Entity\Repostory;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Customer\Service\CustomerService;

/**
 *
 * @author otaba
 *        
 */
class CustomerBookingRepository extends EntityRepository
{

    public function findBookingHistory($user)
    {
        $dql = "SELECT b, d FROM Customer\Entity\CustomerBooking b LEFT JOIN b.assignedDriver d WHERE b.user = :user ORDER BY  b.id DESC ";
        
        $entity = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters([
            "user" => $user
        ])
            ->setMaxResults(50)
            ->getResult(Query::HYDRATE_ARRAY);
        
        return $entity;
    }
    
    

    public function findAllInititedBooking($user)
    {
        $dql = "SELECT b, d, u, s FROM Customer\Entity\CustomerBooking b  LEFT JOIN b.assignedDriver d LEFT JOIN b.user u LEFT JOIN b.status s WHERE b.user = :user AND b.status = :status ORDER BY b.id";
        $result = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters([
            "user" => $user,
            "status" => CustomerService::BOOKING_STATUS_INITIATED
        ])
            ->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    public function getAllBookingType()
    {
        $dql = "SELECT d FROM General\Entity\BookingType d ORDER BY d.id DESC";
        $entity = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult(Query::HYDRATE_ARRAY);
        return $entity;
    }
    
    public function findAllBookingClass(){
        $dql = "SELECT c FROM General\Entity\BookingClass c ";
        $entity = $this->getEntityManager()->createQuery($dql)->getResult(Query::HYDRATE_ARRAY);
        return $entity;
    }
    
    public function findBillingMethod(){
        $dql = "SELECT b FROM General\Entity\BillingMethod b";
        $entity = $this->getEntityManager()->createQuery($dql)->getResult(Query::HYDRATE_ARRAY);
        return $entity;
    }
}

