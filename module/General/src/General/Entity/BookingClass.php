<?php
namespace General\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Executive , regular
 * @ORM\Entity
 * @ORM\Table(name="booking_class")
 * 
 * @author otaba
 *        
 */
class BookingClass
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="booking_class", type="string", nullable=true)
     * 
     * @var string
     */
    private $bookingClass;

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
     * @return the $bookingClass
     */
    public function getBookingClass()
    {
        return $this->bookingClass;
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
     * @param string $bookingClass
     */
    public function setBookingClass($bookingClass)
    {
        $this->bookingClass = $bookingClass;
        return $this;
    }

}

