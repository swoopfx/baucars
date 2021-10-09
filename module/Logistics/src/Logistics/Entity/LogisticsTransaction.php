<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistics_transaction")
 * @author mac
 *        
 */
class LogisticsTransaction
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;
    
    
    private $invoice;
    
    
    
    private $transactionUd;
    
    private $tranactionStatus;
    
    
    private $createdOn;
    
    private $updatedOn;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

