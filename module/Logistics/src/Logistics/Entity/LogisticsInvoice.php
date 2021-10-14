<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistics_invoice")
 * @author mac
 *        
 */
class LogisticsInvoice
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;
    
    
//     private $
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

