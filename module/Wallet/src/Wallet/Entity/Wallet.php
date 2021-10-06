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
}

