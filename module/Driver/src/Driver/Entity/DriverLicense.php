<?php
namespace Driver\Entity;

use Doctrine\ORM\Mapping as ORM;
use General\Entity\Images;

/**
 * @ORM\Entity
 * @ORM\Table(name="driver_lecense")
 * @author otaba
 *        
 */
class DriverLicense
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
     * @ORM\ManyToOne(targetEntity="Driver\Entity\DriverBio")
     * @var DriverBio
     */
    private $driver;
    
    /**
     * @ORM\Column(name="license_id", type="string", nullable=false)
     * @var string
     */
    private $licenseId;
    
    /**
     * @ORM\Column(name="id_expiry_date", type="datetime", nullable=false)
     * @var string
     */
    private $idExpiryDate;
    
    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     * @var string
     */
    private $isActive;
    
    /**
     * @ORM\ManyToOne(targetEntity="General\Entity\Images")
     * @var Images
     */
    private $licenseImage;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $updateOn;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

