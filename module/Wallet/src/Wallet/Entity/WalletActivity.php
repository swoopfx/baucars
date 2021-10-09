<?php
namespace Wallet\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wallet_activity")
 * @author mac
 *        
 */
class WalletActivity
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="walet_balance", type="string", nullable=true)
     * @var  string
     */
    private $walletBalance;
    
    /**
     * @ORM\ManyToOne(targetEntity="WalletActivityType")
     * @var WalletActivityType
     */
    private $activityType;
    
    /**
     * @ORM\Column(name="activity_description", type="text", nullable=true)
     * @var string
     */
    private $activityDescription;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var Datetime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
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
     * @return the $walletBalance
     */
    public function getWalletBalance()
    {
        return $this->walletBalance;
    }

    /**
     * @return the $activityType
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * @return the $activityDescription
     */
    public function getActivityDescription()
    {
        return $this->activityDescription;
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
     * @param string $walletBalance
     */
    public function setWalletBalance($walletBalance)
    {
        $this->walletBalance = $walletBalance;
        return $this;
    }

    /**
     * @param \Wallet\Entity\WalletActivityType $activityType
     */
    public function setActivityType($activityType)
    {
        $this->activityType = $activityType;
        return $this;
    }

    /**
     * @param string $activityDescription
     */
    public function setActivityDescription($activityDescription)
    {
        $this->activityDescription = $activityDescription;
        return $this;
    }

    /**
     * @param \Wallet\Entity\Datetime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @param \Wallet\Entity\Datetime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

}

