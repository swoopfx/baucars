<?php
namespace Driver\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="driver_bio")
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
    
    private $driverName;
    
    private $driverImage;
    
    private $driverDob;
    
    private $updatedOn;
    
    private $createdOn;
    
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

