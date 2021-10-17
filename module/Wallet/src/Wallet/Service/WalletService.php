<?php
namespace Wallet\Service;

use General\Service\FlutterwaveService;
use General\Service\GeneralService;
use Wallet\Entity\WalletActivity;
use Doctrine\ORM\EntityManager;
use Wallet\Entity\Wallet;
use CsnUser\Entity\User;
use JWT\Service\ApiAuthenticationService;
use General\Service\ExecutionInterface;
use Wallet\Entity\WalletActivityType;

/**
 *
 * @author mac
 *        
 */
class WalletService implements ExecutionInterface
{

    /**
     *
     * @var FlutterwaveService
     */
    private $flutterwaveService;
    
    /**
     * 
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService;
     */
    private $generalService;

    /**
     *
     * @var ApiAuthenticationService
     */
    private $apiAuthService;
    
    
    const  WALLET_ACTIVITY_WITHDRAWAL = 10;
    
    const  WALLET_ACTIVITY_DEPOSIT = 20;
    
    

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function fundWalletLogic($data)
    {
        if ($data->status == FlutterwaveService::PAYMENT_SUCCESS) {
            // $
        }
    }

    private function fundwallet(int $walletId = null, float $amount = 0)
    {
        /**
         *
         * @var EntityManager $em
         */
        $em = $this->generalService->getEntityManager();
        try {
            $userId = $this->apiAuthService->getIdentity();
            $user = $em->find(User::class, $userId);
            $walletActivity = new WalletActivity();
            
            /**
             *
             * @var Wallet $walletEntity
             */
            $walletEntity = $em->find(Wallet::class, $walletId);
            if ($walletEntity == NULL) {
                $this->createnewWallet($user, $amount);
            } else {
                $newBalance = $walletEntity->getBalance() + $amount;
                $walletEntity->setBalance($newBalance)->setUpdatedOn(new \Datetime());
            }
            return $walletEntity;
        } catch (\Exception $e) {
            throw new Exception("Can not fund wallet now");
        }
    }

    private function createnewWallet(User $user, float $amount = 0)
    {
        $em = $this->generalService->getEntityManager();
        try {
            
            $walletEntity = new Wallet();
            $walletEntity->setBalance($amount)
                ->setCreatedOn(new \Datetime())
                ->setPasscode(mt_rand(100000, 999999))
                ->setUser($user)
                ->setWalletUid(uniqid("book"));
            
            $em->persist($walletEntity);
        } catch (\Exception $e) {
            throw new Exception("Cannot Create wallet");
        }
    }
    
    
    private function createWalletActivity(){
        $em = $this->entityManager;
       try {
           $walletActivity = new WalletActivity();
           
           $em->persist($walletActivity);
       } catch (\Exception $e) {
           throw new Exception("Cannot Create wallet");
       }
    }

    // public function get
    
    /**
     *
     * @return the $flutterwaveService
     */
    public function getFlutterwaveService()
    {
        return $this->flutterwaveService;
    }

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @param \General\Service\FlutterwaveService $flutterwaveService            
     */
    public function setFlutterwaveService($flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
        return $this;
    }

    /**
     *
     * @param \Wallet\Service\GeneralService; $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return the $apiAuthService
     */
    public function getApiAuthService()
    {
        return $this->apiAuthService;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param \JWT\Service\ApiAuthenticationService $apiAuthService
     */
    public function setApiAuthService($apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
        return $this;
    }
    /**
     * {@inheritDoc}
     * @see \General\Service\ExecutionInterface::execute()
     */
    public function execute()
    {
       $this->entityManager->flush();
        
    }


}

