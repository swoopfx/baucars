<?php
namespace Wallet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wallet")
 * @author mac
 *        
 */
class Wallet
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     *
     * @ORM\Column(name="wallet_uid", type="string", nullable=true)
     * @var string
     */
    private $walletUid;
    
    /**
     * This is available balance
     * This is all credit and payment that successfully went through
     * This is the balance withdrawal could be initiated from
     * @ORM\Column(name="balance", type="string", nullable=true)
     * @var string
     */
    private $balance;
    
    //     /**
    //      * This is the balance that is meant to be
    //      * Which includes unfinalized and unsettled , and pending payment
    //      *
    //      * @ORM\Column(name="book_balance", type="string", nullable=true)
    //      * @var string Balance
    //      */
    //     private $bookBalance;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="CsnUser\Entity\User", inversedBy="wallet")
     * @var User
     */
    private $user;
    
    /**
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     *
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedOn;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="WalletPasscode", mappedBy="wallet")
     * @var WalletPasscode
     */
    private $passcode;
    
    /**
     * @ORM\OneToMany(targetEntity="WalletActivity", mappedBy="wallet")
     * @var Collection
     */
    private $walletActivity;
    
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
     * @return the $walletUid
     */
    public function getWalletUid()
    {
        return $this->walletUid;
    }

    /**
     * @return the $balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
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
     * @return the $passcode
     */
    public function getPasscode()
    {
        return $this->passcode;
    }

    /**
     * @return the $walletActivity
     */
    public function getWalletActivity()
    {
        return $this->walletActivity;
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
     * @param string $walletUid
     */
    public function setWalletUid($walletUid)
    {
        $this->walletUid = $walletUid;
        return $this;
    }

    /**
     * @param string $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
        return $this;
    }

    /**
     * @param \Wallet\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    /**
     * @param \Wallet\Entity\WalletPasscode $passcode
     */
    public function setPasscode($passcode)
    {
        $this->passcode = $passcode;
        return $this;
    }

    /**
     * @param \Wallet\Entity\Collection $walletActivity
     */
    public function setWalletActivity($walletActivity)
    {
        $this->walletActivity = $walletActivity;
        return $this;
    }

}

