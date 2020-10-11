<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use General\Entity\MotorType;

/**
 * @ORM\Entity
 * @ORM\Table(name="")
 * @author otaba
 *        
 */
class Cars
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
     * @ORM\Column(name="description", type="text", nullable=false)
     * @var string
     */
    private $description;
    
    /**
     * 
     * @var MotorType
     */
    private $motorMake;
    
    private $motorType;
    
    private  $motorColor;
    
    private $avrageRentPrice;
    
    private $motorTransmission;
    
    private $doors;
    
    private $fuel;
    
    private $motorClass;
    
    private $isAirBag;
    
    private $isAbs;
    
    private $isGps;
    
    private $isInsurance;
    
    private $isMusic;
    
    private $isCarkit;
    
    private $isBluetooth;
    
    
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
}

