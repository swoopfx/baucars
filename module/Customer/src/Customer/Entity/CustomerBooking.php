<?php
namespace Customer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Driver\Entity\DriverBio;
// use Application\Entity\Cars;
use General\Entity\BookingStatus;
use General\Entity\BookingType;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer_booking")
 * @author otaba
 *        
 */
class CustomerBooking
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Driver\Entity\DriverBio")
     * @var DriverBio
     */
    private $assignedDriver;
    
    
    
    /**
     * @ORM\Column(name="start_time", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $startTime;
    
    /**
     * @ORM\Column(name="end_time", type="datetime", nulllable=true)
     * @var \DateTime
     */
    private $endTime;
    
    /**
     * 
     * @var Collection
     */
    private $subcriptionDetails;
    
    
    private $service;
    
    /**
     * @ORM\ManyToOne(targetEntity="General\Entity\BookingStatus")
     * @var BookingStatus
     */
    private $status;
    
    /**
     * subscription, booking
     * @ORM\ManyToOne(targetEntity="General\Entity\BookingType")
     * @var BookingType
     */
    private $bookingType;
    
    /**
     */
    public function __construct()
    {
        
        $this->subcriptionDetails = new ArrayCollection();
    }
}

