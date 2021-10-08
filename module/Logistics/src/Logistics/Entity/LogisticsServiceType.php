<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistics_service_type")
 * @author mac
 *        
 */
class LogisticsServiceType
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
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

