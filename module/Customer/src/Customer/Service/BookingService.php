<?php
namespace Customer\Service;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Customer\Entity\CustomerBooking;
use Zend\Session\Container;
use Zend\Http\Client;
use Zend\Http\Request;
use General\Entity\AppSettings;
use General\Entity\PriceRange;

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

    /**
     *
     * @var Container
     */
    private $bookingSession;

    // Distance Matrix
    /**
     * distance matrix distnace
     *
     * @var unknown
     */
    private $dmDistance;

    /**
     * DistanceMatrix Time
     *
     * @var unknown
     */
    private $dmTime;

    /**
     *
     * @var AppSettings
     */
    private $appSettings;

    /**
     *
     * @var PriceRange
     */
    private $pricaRangeSettings;

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
            ->
        // ->le
        setMaxResults(50)
            ->getQuery()
            ->getArrayResult();
        return $result;
    }

    public function distanceMatrix()
    {
        var_dump($this->bookingSession->pickUpPlaceId);
        if ($this->bookingSession->pickUpPlaceId != NULL && $this->bookingSession->destinationPlaceId != NULL) {
            $endPoint = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=place_id:{$this->bookingSession->pickupPlaceId}&key=AIzaSyA4iD9lE6vET5C0mLW8fRVnMXxrobSlkEU&destinations=place_id:{$this->bookingSession->destinationPlaceId}";
            $client = new Client();
            $client->setMethod(Request::METHOD_GET);
            $client->setUri($endPoint);
            
            $response = $client->send();
            if ($response->isSuccess()) {
                print_r($response->getBody());
            }
        } else {
            throw new \Exception("Absent Identifier");
        }
    }

    public function priceCalculator()
    {
        if ($this->dmDistance < $this->appSettings->getMinimumKilometer()) {
            return 2000;
        } elseif ($this->dmDistance > $this->appSettings->getMinimumKilometer() && $this->dmDistance < $this->pricaRangeSettings[0]->getMaximumKilometer()) {
            return $this->dmDistance * $this->pricaRangeSettings[0]->getPricePerKilometer();
        } elseif ($this->dmDistance > $this->pricaRangeSettings[0]->getMaximumKilometer() && $this->pricaRangeSettings[1]->getMaximumKilometer()) {
            return $this->dmDistance * $this->pricaRangeSettings[1]->getPricePerKilometer();
        } else {
            return $this->dmDistance * 140;
        }
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

    /**
     *
     * @return the $bookingSession
     */
    public function getBookingSession()
    {
        return $this->bookingSession;
    }

    /**
     *
     * @param \Zend\Session\Container $bookingSession            
     */
    public function setBookingSession($bookingSession)
    {
        $this->bookingSession = $bookingSession;
        return $this;
    }

    /**
     *
     * @return the $dmDistance
     */
    public function getDmDistance()
    {
        return $this->dmDistance;
    }

    /**
     *
     * @return the $dmTime
     */
    public function getDmTime()
    {
        return $this->dmTime;
    }

    /**
     *
     * @return the $appSettings
     */
    public function getAppSettings()
    {
        return $this->appSettings;
    }

    /**
     *
     * @param \Customer\Service\unknown $dmDistance            
     */
    public function setDmDistance($dmDistance)
    {
        $this->dmDistance = $dmDistance;
        return $this;
    }

    /**
     *
     * @param \Customer\Service\unknown $dmTime            
     */
    public function setDmTime($dmTime)
    {
        $this->dmTime = $dmTime;
        return $this;
    }

    /**
     *
     * @param \General\Entity\AppSettings $appSettings            
     */
    public function setAppSettings($appSettings)
    {
        $this->appSettings = $appSettings;
        return $this;
    }

    /**
     *
     * @return the $pricaRangeSettings
     */
    public function getPricaRangeSettings()
    {
        return $this->pricaRangeSettings;
    }

    /**
     *
     * @param \General\Entity\PriceRange $pricaRangeSettings            
     */
    public function setPricaRangeSettings($pricaRangeSettings)
    {
        $this->pricaRangeSettings = $pricaRangeSettings;
        return $this;
    }
}

