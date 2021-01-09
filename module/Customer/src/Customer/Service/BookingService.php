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
use Customer\Entity\Bookings;
use General\Entity\BookingStatus;
use General\Entity\BookingClass;
use General\Entity\NumberOfSeat;
use CsnUser\Entity\User;

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

    public function setRequestSession($post)
    {
        $bookingSession = $this->bookingSession;
        $bookingSession->pickUpAddress = $post["pickUpAddress"];
        $bookingSession->destinationAddress = $post["destinationAddress"];
        $bookingSession->pickUpLongitude = $post["pickUpLongitude"];
        $bookingSession->destinationLongitude = $post["destinationLongitude"];
        $bookingSession->pickUpLatitude = $post["pickUpLatitude"];
        $bookingSession->destinationLatitude = $post["destinationLatitude"];
        $bookingSession->pickUpPlaceId = $post["pickUpPlaceId"];
        $bookingSession->destinationPlaceId = $post["destinationPlaceId"];
    }

    public function getAllInititedBookingCount()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
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
        $repo = $em->getRepository(Bookings::class);
        $result = $repo->createQueryBuilder("a")
            ->select('a, s, bc')
            ->where('a.status=' . CustomerService::BOOKING_STATUS_INITIATED)
            ->leftJoin("a.status", "s")
//             ->leftJoin("a.bookingType", "bt")
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
        if ($this->bookingSession->pickUpPlaceId != NULL && $this->bookingSession->destinationPlaceId != NULL) {
            
            $endPoint = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=place_id:{$this->bookingSession->pickUpPlaceId}&key=AIzaSyBobkXMM-uzqQLM5pqs_n7prJKJJ4-JK5I&destinations=place_id:{$this->bookingSession->destinationPlaceId}";
            $client = new Client();
            
            $client->setMethod(Request::METHOD_GET);
            $client->setUri($endPoint);
            
            $response = $client->send();
            
            if ($response->isSuccess()) {
                // print_r($response->getBody());
                return json_decode($response->getBody());
            }
        } else {
            throw new \Exception("Absent Identifier");
        }
    }

    public function priceCalculator()
    {
        $bookingSession = $this->bookingSession;
       $finalPrice = 0;
        $dmDistance = $this->dmDistance / 1000;
        if ($dmDistance < $this->appSettings->getMinimumKilometer()) {
            $finalPrice = 2000;
        } elseif ($this->dmDistance > $this->appSettings->getMinimumKilometer() && $dmDistance < $this->pricaRangeSettings[0]->getMaximumKilometer()) {
            $finalPrice = round((($dmDistance * $this->pricaRangeSettings[0]->getPricePerKilometer()) + 100), 2);
        } elseif ($dmDistance > $this->pricaRangeSettings[0]->getMaximumKilometer() && $this->pricaRangeSettings[1]->getMaximumKilometer()) {
            $finalPrice =  round((($dmDistance * $this->pricaRangeSettings[1]->getPricePerKilometer()) + 100), 2);
        } else {
            $finalPrice =  $dmDistance * 140;
        }
        
        if($bookingSession->selectedBookingClass == "100"){
            $finalPrice = $finalPrice + 5000;
        }
        
        if($bookingSession->selectedNumberOfSeat == "20"){
            $finalPrice = round($finalPrice + ($finalPrice * 0.5));
        }
        
        return $finalPrice;
    }

    public function createBooking()
    {
        $bookingsEntity = new Bookings();
        $auth = $this->auth;
        $em = $this->entityManager;
        $bookingSession = $this->bookingSession;
        $bookingsEntity->setCreatedOn(new \DateTime())
            ->setBookingUid(CustomerService::bookingUid())
            ->setUser($em->find(User::class, $this->auth->getIdentity()->getId()))
            ->setStatus($em->find(BookingStatus::class, CustomerService::BOOKING_STATUS_INITIATED))
            ->setPickUpAddress($bookingSession->pickUpAddress)
            ->setDestination($bookingSession->destinationAddress)
            ->setPickupLatitude($bookingSession->pickUpLatitude)
            ->setPickupLongitude($bookingSession->pickUpLongitude)
            ->setPickupPlaceId($bookingSession->pickUpPlaceId)
            ->setDestinationLatitude($bookingSession->destinationLatitude)
            ->setDestinationLongitude($bookingSession->destinationLongitude)
            ->setDestinationPlaceId($bookingSession->destinationPlaceId)
            ->setPickupDate(\DateTime::createFromFormat("Y-m-d H:i", $bookingSession->pickupDate." ".$bookingSession->pickupTime))
            ->setCalculatedDistanceText($bookingSession->distanceText)
            ->setCalculatedDistanceValue($bookingSession->distanceValue)
            ->setCalculatedTimeText($bookingSession->timeText)
            ->setCalculatedTimeValue($bookingSession->timeValue)
            
//             ->setPickuptime($bookingSession->pickupTime)
            ->setBookingClass($em->find(BookingClass::class, $bookingSession->selectedBookingClass))
            ->setSeater($em->find(NumberOfSeat::class, $bookingSession->selectedNumberOfSeat));
        
            return $bookingsEntity;
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

