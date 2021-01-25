<?php
namespace Driver\Service;

use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use Driver\Entity\DriverBio;
use Doctrine\ORM\Query;
use Customer\Service\CustomerService;
use Customer\Entity\Bookings;

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

    const DRIVER_STATUS_FREE = 10;

    const DRIVER_STATUS_ENGAGED = 50;

    const DRIVER_STATUS_ASSIGNED = 100;

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
            ->where("d.driverState = :state")
            ->setParameters([
            "state" => self::DRIVER_STATUS_FREE
        ])->getQuery();
        
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
     * 
     * @param Bookings $booking
     */
    public function amotizedTrip($booking){
        $generalService = $this->generalService;
        $appSettings = $generalService->getAppSeettings();
        $em = $this->entityManager;
        $estimatedSeconds = $booking->getCalculatedTimeValue();
        $estimateMinutes = floor($estimatedSeconds/60);
        $estimatedDistance = $booking->getCalculatedDistanceValue();
        $activeTrip = $booking->getTrip();
        $actualStarttime = new \DateTime($booking->getTrip()->getStarted());
        $actualEndtime = new \DateTime($booking->getTrip()->getEnded());
        
        $actualTimeDifference = $actualStarttime->diff($actualEndtime);
        $actualMinutes = $actualTimeDifference->days * 24 * 60;
        $actualMinutes+= $actualTimeDifference->h * 60;
        $actualMinutes+= $actualTimeDifference->i;
        
        $usableMinutes = $estimateMinutes + $appSettings->getGracePeriod();
        if($usableMinutes <= $actualMinutes){
            
        }
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

