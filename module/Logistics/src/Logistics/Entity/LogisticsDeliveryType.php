<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Normal 
 * Express
 * @ORM\Entity
 * @ORM\Table(name="logistics_delivery_type")
 * @author mac
 *        
 */
class LogisticsDeliveryType
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
     * @ORM\Column(name="ltype", type="string", nullable=false)
     * @var string
     */
    private $type;
    
    /**
     * @ORM\Column(name="", type="text", nullable=true)
     * @var string
     */
    private $description;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

