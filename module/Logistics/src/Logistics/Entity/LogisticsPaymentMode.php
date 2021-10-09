<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mappinga as ORM;

/**
 *
 * @author mac
 *        
 */
class LogisticsPaymentMode
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
     * @ORM\
     * @var string
     */
    private $mode;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

