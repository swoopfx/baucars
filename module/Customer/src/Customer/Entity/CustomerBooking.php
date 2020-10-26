<?php
namespace Customer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Driver\Entity\DriverBio;
// use Application\Entity\Cars;
use General\Entity\BookingStatus;
use General\Entity\BookingType;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use CsnUser\Entity\User;
use General\Entity\BookingClass;

/**
 * @ORM\Entity(repositoryClass="Customer\Entity\Repostory\CustomerBookingRepository")
 * @ORM\Table(name="customer_booking")
 *
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
     * @ORM\Column(name="booking_uid", type="string", nullable=true, unique=true)
     *
     * @var string
     */
    private $bookingUid;

    /**
     * @ORM\ManyToOne(targetEntity="Driver\Entity\DriverBio")
     *
     * @var DriverBio
     */
    private $assignedDriver;

    /**
     * @ORM\Column(name="start_time", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $startTime;

    /**
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $endTime;

    /**
     *
     * @var Collection
     */
    private $subcriptionDetails;

    /**
     * @ORM\ManyToOne(targetEntity="General\Entity\BookingClass")
     * @var BookingClass
     */
    private $bookingClass;

    /**
     * @ORM\ManyToOne(targetEntity="General\Entity\BookingStatus")
     *
     * @var BookingStatus
     */
    private $status;

    /**
     * subscription, instant booking
     * @ORM\ManyToOne(targetEntity="General\Entity\BookingType")
     *
     * @var BookingType
     */
    private $bookingType;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedOn;

    /**
     */
    public function __construct()
    {
        $this->subcriptionDetails = new ArrayCollection();
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $assignedDriver
     */
    public function getAssignedDriver()
    {
        return $this->assignedDriver;
    }

    /**
     *
     * @return the $startTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     *
     * @return the $endTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     *
     * @return the $subcriptionDetails
     */
    public function getSubcriptionDetails()
    {
        return $this->subcriptionDetails;
    }

    /**
     *
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return the $bookingType
     */
    public function getBookingType()
    {
        return $this->bookingType;
    }

    /**
     *
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     *
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param \Driver\Entity\DriverBio $assignedDriver            
     */
    public function setAssignedDriver($assignedDriver)
    {
        $this->assignedDriver = $assignedDriver;
        return $this;
    }

    /**
     *
     * @param DateTime $startTime            
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     *
     * @param DateTime $endTime            
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        return $this;
    }

    /**
     *
     * @param \Doctrine\Common\Collections\Collection $subcriptionDetails            
     */
    public function setSubcriptionDetails($subcriptionDetails)
    {
        $this->subcriptionDetails = $subcriptionDetails;
        return $this;
    }

    /**
     *
     * @param \General\Entity\BookingStatus $status            
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @param \General\Entity\BookingType $bookingType            
     */
    public function setBookingType($bookingType)
    {
        $this->bookingType = $bookingType;
        return $this;
    }

    /**
     *
     * @param \CsnUser\Entity\User $user            
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     *
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     *
     * @param DateTime $updatedOn            
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    /**
     *
     * @return the $bookingUid
     */
    public function getBookingUid()
    {
        return $this->bookingUid;
    }

    /**
     *
     * @param string $bookingUid            
     */
    public function setBookingUid($bookingUid)
    {
        $this->bookingUid = $bookingUid;
        return $this;
    }
    /**
     * @return the $bookingClass
     */
    public function getBookingClass()
    {
        return $this->bookingClass;
    }

    /**
     * @param \General\Entity\BookingClass $bookingClass
     */
    public function setBookingClass($bookingClass)
    {
        $this->bookingClass = $bookingClass;
        return $this;
    }

}

