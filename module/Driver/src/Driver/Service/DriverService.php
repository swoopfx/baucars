<?php
namespace Driver\Service;

use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use Driver\Entity\DriverBio;
use Doctrine\ORM\Query;
use Customer\Service\CustomerService;

/**
 *
 * @author otaba
 *        
 */
class DriverService
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

    // TODO - Insert your code here
    
    /**
     * These are drivers that are available for service
     */
    public function findAllInactiveDrivers()
    {
        $em = $this->entityManager;
        
        $repo = $em->getRepository(DriverBio::class);
        $result = $repo->createQueryBuilder("d")
            ->addSelect("b")
            ->addSelect("u")
            ->leftJoin("d.user", "u")
            ->leftJoin("d.booking", "b")
            ->leftJoin("b.status", "s")
            ->
        // ->where("s.id <> ".CustomerService::BOOKING_STATUS_ACTIVE)
        getQuery();
        // ->groupBy("s")
        // ->having("s.id != ".CustomerService::BOOKING_STATUS_ACTIVE)
        // ->getQuery();
        // var_dump($result);
        $res = $result->getResult(Query::HYDRATE_ARRAY);
        return $res;
    }

    /**
     *
     * @param
     *            $calss
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function getAllInactiveClassDriver($calss)
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(DriverBio::class);
        $dql = "SELECT d FROM Driver\Entity\DriverBio d LEFT JOIN d.user u LEFT JOIN d.assisnedCar ac  WHERE d.activeSession IS NULL AND  ac.motorClass = :class ORDER BY d.id DESC";
        $result = $em->createQuery($dql)
            ->setParameters([
            "sess" => NULL,
            "class" => $class
        ])
            ->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public static function driverUid()
    {
        return uniqid();
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
}

