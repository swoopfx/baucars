<?php
namespace Logistics\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistics_request")
 *
 * @author mac
 *        
 */
class LogisticsRequest
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
     * @ORM\ManyToOne(targetEntity="LogisticsServiceType")
     * @var LogisticsServiceType
     */
    private $serviceType;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     * @var User 
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="LogisticsPaymentMode")
     * @var LogisticsPaymentMode
     */
    private $paymentmode;

    /**
     * @ORM\Column(name="pickup_address", type="string", nullable=true)
     * 
     * @var string
     */
    private $pickupAddress;

    /**
     * @ORM\Column(name="drop_off_address", type="string", nullable=true)
     * 
     * @var string
     */
    private $dropOffAddress;

    /**
     * @ORM\Column(name="item_name", type="string", nullable=true)
     * 
     * @var string
     */
    private $itemName;

    /**
     * @ORM\Column(name="delivery_note", type="text", nullable=true)
     * 
     * @var string
     */
    private $deliveryNote;

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
     * @ORM\ManyToOne(targetEntity="LogisticsInvoice")
     * 
     * @var LogisticsInvoice
     */
    private $invoice;
    
    /**
     * 
     * @var boolean
     */
    private $isActive;

    // private
    
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
     * @return the $serviceType
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return the $paymentmode
     */
    public function getPaymentmode()
    {
        return $this->paymentmode;
    }

    /**
     * @return the $pickupAddress
     */
    public function getPickupAddress()
    {
        return $this->pickupAddress;
    }

    /**
     * @return the $dropOffAddress
     */
    public function getDropOffAddress()
    {
        return $this->dropOffAddress;
    }

    /**
     * @return the $itemName
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * @return the $deliveryNote
     */
    public function getDeliveryNote()
    {
        return $this->deliveryNote;
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
     * @return the $invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
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
     * @param \Logistics\Entity\LogisticsServiceType $serviceType
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
        return $this;
    }

    /**
     * @param \CsnUser\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param \Logistics\Entity\LogisticsPaymentMode $paymentmode
     */
    public function setPaymentmode($paymentmode)
    {
        $this->paymentmode = $paymentmode;
        return $this;
    }

    /**
     * @param string $pickupAddress
     */
    public function setPickupAddress($pickupAddress)
    {
        $this->pickupAddress = $pickupAddress;
        return $this;
    }

    /**
     * @param string $dropOffAddress
     */
    public function setDropOffAddress($dropOffAddress)
    {
        $this->dropOffAddress = $dropOffAddress;
        return $this;
    }

    /**
     * @param string $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
        return $this;
    }

    /**
     * @param string $deliveryNote
     */
    public function setDeliveryNote($deliveryNote)
    {
        $this->deliveryNote = $deliveryNote;
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

    /**
     * @param \Logistics\Entity\LogisticsInvoice $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }

}

