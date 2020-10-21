<?php
namespace Customer\Entity\Repostory;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

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
}

