<?php
namespace Customer\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * 
     * @var unknown
     */
    private $assignedDriver;
    
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

