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
use Application\Entity\Transactions;

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

    const WALLET_ACTIVITY_WITHDRAWAL = 10;

    const WALLET_ACTIVITY_DEPOSIT = 20;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function chargeWallet($amount)
    {
       
        $auth = $this->apiAuthService;
        $userid = $auth->getIdentity();
        $em = $this->entityManager;
        
        /**
         *
         * @var Wallet $wallet
         */
        $wallet = $em->getRepository(Wallet::class)->findOneBy([
            "user" => $userid
        ]);
        $balance = ($wallet == null ? 0 : $wallet->getBalance());
        
        if ($amount > $balance) {
          
            throw new \Exception("Insufficient funds");
        } else {
            $newBalance = $wallet->getBalance() - $amount;
            $wallet->setBalance($newBalance)->setUpdatedOn(new \Datetime());
            
            $this->createWalletActivity(self::WALLET_ACTIVITY_WITHDRAWAL, $amount, $newBalance);
            $em->persist($wallet);
            
            $em->flush();
            return $wallet;
        }
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
            $newBalance = 0;
            if ($walletEntity == NULL) {
                $newBalance = 0 + $amount;
                $this->createnewWallet($user, $amount);
            } else {
                $newBalance = $walletEntity->getBalance() + $amount;
                $walletEntity->setBalance($newBalance)->setUpdatedOn(new \Datetime());
            }
            $this->createWalletActivity(self::WALLET_ACTIVITY_DEPOSIT, $amount, $newBalance);
            
            // transaction
            // email notification
            return $walletEntity;
        } catch (\Exception $e) {
            throw new Exception("Can not fund wallet now");
        }
    }

    private function debitwallet()
    {}

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

    private function createWalletActivity($type, $amount, $balance)
    {
        $em = $this->entityManager;
        try {
            $walletActivity = new WalletActivity();
            /**
             *
             * @var WalletActivityType $walletActivityTypeEntity
             */
            $walletActivityTypeEntity = $em->find(WalletActivityType::class, $type);
            $walletActivity->setActivityType($walletActivityTypeEntity)
                ->setCreatedOn(new \Datetime())
                ->setWalletBalance($balance)
                ->setActivityDescription("A {$walletActivityTypeEntity->getType()} of {$amount}, was carried out on your wallet, with balance of {$balance}");
            $em->persist($walletActivity);
        } catch (\Exception $e) {
            throw new Exception("Cannot Create wallet");
        }
    }

    private function createtransaction()
    {
        try {} catch (\Exception $e) {}
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
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return the $apiAuthService
     */
    public function getApiAuthService()
    {
        return $this->apiAuthService;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \JWT\Service\ApiAuthenticationService $apiAuthService            
     */
    public function setApiAuthService($apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \General\Service\ExecutionInterface::execute()
     */
    public function execute()
    {
        $this->entityManager->flush();
    }
}

