<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistics_request")
 *
 * @author mac
 *        
 */
class LogisticsRequest
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *     
     */
    private $id;

    /**
     * @ORM\Column(name="logistics_uid", type="string", nullable=false)
     *
     * @var string
     */
    private $logisticsUid;

    /**
     * @ORM\ManyToOne(targetEntity="LogisticsServiceType")
     *
     * @var LogisticsServiceType
     */
    private $serviceType;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="LogisticsPaymentMode")
     *
     * @var LogisticsPaymentMode
     */
    private $paymentmode;

    /**
     * This is the distance value in meters
     * @ORM\Column(name="calculated_distance_value", type="string", nullable=true)
     *
     * @var string;
     */
    private $calculatedDistanceValue;

    /**
     * This is the distance value in km
     * @ORM\Column(name="calculated_distance_text", type="string", nullable=true)
     *
     * @var string
     */
    private $calculatedDistanceText;

    /**
     * @ORM\Column(name="calculated_time_value", type="string", nullable=true)
     *
     * @var string
     */
    private $calculatedTimeValue;

    // in secounds
    
    /**
     * @ORM\Column(name="calculated_time_text", type="string", nullable=true)
     *
     * @var string
     */
    private $calculatedTimeText;

    // in minutes
    
    /**
     * @ORM\Column(name="pick_up_address", type="string", nullable=true)
     *
     * @var string
     */
    private $pickUpAddress;

    /**
     * @ORM\Column(name="pick_up_longitude", type="string", nullable=true)
     *
     * @var string
     */
    private $pickupLongitude;

    /**
     * @ORM\Column(name="pick_up_latitude", type="string", nullable=true)
     *
     * @var string
     */
    private $pickupLatitude;

    /**
     * @ORM\Column(name="pickup_place_id", type="string", nullable=true)
     *
     * @var string
     */
    private $pickupPlaceId;

    /**
     * @ORM\Column(name="destination", type="string", nullable=true)
     *
     * @var string
     */
    private $destination;

    /**
     * @ORM\Column(name="destination_longitude", type="string", nullable=true)
     *
     * @var string
     */
    private $destinationLongitude;

    /**
     * @ORM\Column(name="destination_latitude", type="string", nullable=true)
     *
     * @var string
     */
    private $destinationLatitude;

    /**
     * @ORM\Column(name="destination_place_id", type="string", nullable=true)
     *
     * @var string
     */
    private $destinationPlaceId;

    /**
     * @ORM\ManyToOne(targetEntity="Driver\Entity\DriverBio", inversedBy="booking")
     *
     * @var DriverBio
     */
    private $assignedDriver;

    /**
     * @ORM\Column(name="item_name", type="string", nullable=true)
     *
     * @var string
     */
    private $itemName;

    /**
     * @ORM\Column(name="delivery_note", type="text", nullable=true)
     *
     * @var string
     */
    private $deliveryNote;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var Datetime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     *
     * @var Datetime
     */
    private $updatedOn;

    /**
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     * 
     * @var int
     */
    private $quantity;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     * @var boolean
     */
    private $isActive ;

    // private
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }


}

