<?php
namespace Customer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Driver\Entity\DriverBio;
use Application\Entity\Cars;

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
     * @ORM\ManyToOne(targetEntity="Application\Entity\Cars")
     * @var Cars
     */
    private $assisnedCar;
    
    
    private $service;
    
    private $status;
    
    /**
     * subscription, rental
     * @var unknown
     */
    private $bookingType;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

