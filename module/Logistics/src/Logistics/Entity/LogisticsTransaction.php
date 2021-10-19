<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistics_transaction")
 * 
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

    /**
     * @ORM\ManyToOne(targetEntity="LogisticsInvoice")
     * @var LogisticsInvoice
     */
    private $invoice;

    /**
     * @ORM\Column(name="transaction_uid", type="string", nullable=false)
     * 
     * @var string
     */
    private $transactionUd;

    /**
     * @ORM\ManyToOne(targetEntity="LogisticsInvoiceStatus")
     * 
     * @var LogisticsInvoiceStatus
     */
    private $tranactionStatus;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * 
     * @var Datetime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * 
     * @var Datetime
     */
    private $updatedOn;

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
     * @return the $invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return the $transactionUd
     */
    public function getTransactionUd()
    {
        return $this->transactionUd;
    }

    /**
     * @return the $tranactionStatus
     */
    public function getTranactionStatus()
    {
        return $this->tranactionStatus;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
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
     * @param \Logistics\Entity\LogisticsInvoice $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }

    /**
     * @param string $transactionUd
     */
    public function setTransactionUd($transactionUd)
    {
        $this->transactionUd = $transactionUd;
        return $this;
    }

    /**
     * @param \Logistics\Entity\LogisticsInvoiceStatus $tranactionStatus
     */
    public function setTranactionStatus($tranactionStatus)
    {
        $this->tranactionStatus = $tranactionStatus;
        return $this;
    }

    /**
     * @param \Logistics\Entity\Datetime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @param \Logistics\Entity\Datetime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

}

