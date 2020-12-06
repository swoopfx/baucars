<?php
namespace Customer\Entity\Repostory;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Customer\Service\CustomerService;
use Customer\Entity\CustomerBooking;

/**
 *
 * @author otaba
 *        
 */
class CustomerBookingRepository extends EntityRepository
{

    public function findBookingHistory($user)
    {
        $dql = "SELECT b, d, s, t, bc, bt FROM Customer\Entity\CustomerBooking b LEFT JOIN b.bookingType bt LEFT JOIN b.bookingClass bc LEFT JOIN b.assignedDriver d LEFT JOIN b.status s LEFT JOIN b.transaction t WHERE b.user = :user ORDER BY  b.id DESC ";
        
        $entity = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters([
            "user" => $user
        ])
            ->setMaxResults(50)
            ->getResult(Query::HYDRATE_ARRAY);
        
        return $entity;
    }

    /**
     * get Users Booking for a specific user
     *
     * @param unknown $user            
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function findAllInititedBooking($user)
    {
        $dql = "SELECT b, d, u, s, t FROM Customer\Entity\CustomerBooking b  LEFT JOIN b.assignedDriver d LEFT JOIN b.user u LEFT JOIN b.status s LEFT JOIN b.transaction t WHERE b.user = :user AND b.status = :status ORDER BY b.id";
        $result = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters([
            "user" => $user,
            "status" => CustomerService::BOOKING_STATUS_INITIATED
        ])
            ->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    public function findCustomersBooking($user)
    {
        $dql = "SELECT b, d, u, s, t FROM Customer\Entity\CustomerBooking b  LEFT JOIN b.assignedDriver d LEFT JOIN b.user u LEFT JOIN b.status s LEFT JOIN b.transaction t WHERE b.user = :user  ORDER BY b.id";
        $result = $this->getEntityManager()
            ->createQuery($dql)
            ->setMaxResults(50)
            ->setParameters([
            "user" => $user
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

    public function findAllBookingClass()
    {
        $dql = "SELECT c FROM General\Entity\BookingClass c ";
        $entity = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult(Query::HYDRATE_ARRAY);
        return $entity;
    }

    public function findBillingMethod()
    {
        $dql = "SELECT b FROM General\Entity\BillingMethod b";
        $entity = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult(Query::HYDRATE_ARRAY);
        return $entity;
    }

    public function countBooking($criteria = NULL)
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select("count(b.id)")
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    public function findBookingItems($offset, $itemsPerPage)
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select([
            "b",
            "t",
            "bt",
            "u",
            "bc",
            "s"
        
        ])
            ->leftJoin("b.transaction", "t")
            ->leftJoin("b.user", "u")
            ->leftJoin("b.status", "s")
            ->leftJoin("b.bookingType", "bt")
            ->leftJoin("b.bookingClass", "bc")
            ->setFirstResult($offset)
            ->setMaxResults($itemsPerPage)
            ->orderBy("b.id", "DESC")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    /**
     * Paginated format of all
     *
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function findAdminInitiedCount()
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select("count(b.id)")
            ->where("b.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_INITIATED
        ])
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    public function findAdminAllInitiatedBooking($offset, $itemsPerPage)
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select([
            "b",
            "t",
            "bt",
            "u",
            "bc",
            "s"
        
        ])
            ->leftJoin("b.transaction", "t")
            ->leftJoin("b.user", "u")
            ->leftJoin("b.status", "s")
            ->leftJoin("b.bookingType", "bt")
            ->leftJoin("b.bookingClass", "bc")
            ->setFirstResult($offset)
            ->setMaxResults($itemsPerPage)
            ->where("b.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_INITIATED
        ])
            ->orderBy("b.id", "DESC")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    public function findAdminActiveTripCount()
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select("count(b.id)")
            ->where("b.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_ACTIVE
        ])
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    public function findAdminActiveTrip($offset, $itemsPerPage)
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select([
            "b",
            "t",
            "bt",
            "u",
            "bc"
        
        ])
            ->leftJoin("b.transaction", "t")
            ->leftJoin("b.user", "u")
            ->
        // ->leftJoin("b.status", "s")
        leftJoin("b.bookingType", "bt")
            ->leftJoin("b.bookingClass", "bc")
            ->setFirstResult($offset)
            ->setMaxResults($itemsPerPage)
            ->where("b.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_ACTIVE
        ])
            ->orderBy("b.id", "DESC")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    public function findAdminCancelBookingCount()
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select("count(b.id)")
            ->where("b.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_CANCELED
        ])
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    public function findAdminCanceledBooking($offset, $itemsPerPage)
    {
        $repo = $this->getEntityManager()->getRepository(CustomerBooking::class);
        $result = $repo->createQueryBuilder("b")
            ->select([
            "b",
            "t",
            "bt",
            "u",
            "bc"
        
        ])
            ->leftJoin("b.transaction", "t")
            ->leftJoin("b.user", "u")
            ->
        // ->leftJoin("b.status", "s")
        leftJoin("b.bookingType", "bt")
            ->leftJoin("b.bookingClass", "bc")
            ->setFirstResult($offset)
            ->setMaxResults($itemsPerPage)
            ->where("b.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_CANCELED
        ])
            ->orderBy("b.id", "DESC")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }
}

