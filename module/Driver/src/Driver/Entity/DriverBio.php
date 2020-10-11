<?php
namespace Driver\Entity;

use Doctrine\ORM\Mapping as ORM;
use General\Entity\Images;

/**
 * @ORM\Entity
 * @ORM\Table(name="driver_bio")
 * 
 * @author otaba
 *        
 */
class DriverBio
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
     * @ORM\Column(name="driver_name", type="string", nullable=false)
     * 
     * @var string
     */
    private $driverName;

    /**
     * @ORM\Column(name="driver_phone", type="string", nullable=false)
     * 
     * @var string
     */
    private $driverPhone;

    /**
     * @ORM\Column(name="driver_email", type="string", nullable="true")
     * 
     * @var string
     */
    private $driverEmail;

    /**
     * @ORM\Column(name="driver_since", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $driverSince;

    /**
     * @ORM\ManyToOne(targetEntity="General\Entity\Images")
     * 
     * @var Images
     */
    private $driverImage;

    /**
     * @ORM\Column(name="driver_dob", type="datetime", nullable=true)
     * 
     * @var unknown
     */
    private $driverDob;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $updatedOn;
    
    private $height;
    
    private $weight;
    
    private $eyeColor;
    
    private $complexion;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $createdOn;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $driverName
     */
    public function getDriverName()
    {
        return $this->driverName;
    }

    /**
     * @return the $driverPhone
     */
    public function getDriverPhone()
    {
        return $this->driverPhone;
    }

    /**
     * @return the $driverEmail
     */
    public function getDriverEmail()
    {
        return $this->driverEmail;
    }

    /**
     * @return the $driverSince
     */
    public function getDriverSince()
    {
        return $this->driverSince;
    }

    /**
     * @return the $driverImage
     */
    public function getDriverImage()
    {
        return $this->driverImage;
    }

    /**
     * @return the $driverDob
     */
    public function getDriverDob()
    {
        return $this->driverDob;
    }

    /**
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $driverName
     */
    public function setDriverName($driverName)
    {
        $this->driverName = $driverName;
        return $this;
    }

    /**
     * @param string $driverPhone
     */
    public function setDriverPhone($driverPhone)
    {
        $this->driverPhone = $driverPhone;
        return $this;
    }

    /**
     * @param string $driverEmail
     */
    public function setDriverEmail($driverEmail)
    {
        $this->driverEmail = $driverEmail;
        return $this;
    }

    /**
     * @param DateTime $driverSince
     */
    public function setDriverSince($driverSince)
    {
        $this->driverSince = $driverSince;
        return $this;
    }

    /**
     * @param \General\Entity\Images $driverImage
     */
    public function setDriverImage($driverImage)
    {
        $this->driverImage = $driverImage;
        return $this;
    }

    /**
     * @param \Driver\Entity\unknown $driverDob
     */
    public function setDriverDob($driverDob)
    {
        $this->driverDob = $driverDob;
        return $this;
    }

    /**
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

}

