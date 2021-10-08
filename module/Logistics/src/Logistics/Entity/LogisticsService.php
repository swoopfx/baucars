<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistics_service")
 * 
 * @author mac
 *        
 */
class LogisticsService
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *     
     */
    private $id;
    
    private $type;
    
    private $createdOn;
    
    private $updatedOn;
    
    

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

