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

    /**
     * This is called when a deduction is made from the wallet
     * @param unknown $amount
     * @return \Wallet\Entity\Wallet
     * @throws \Exception
     */
    public function chargeWallet($amount)
    {
        $auth = $this->apiAuthService;
        $userid = $auth->getIdentity();
        $em = $this->entityManager;
        /**
         * @var  User
         */
        $user = $em->find(User::class, $userid)
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
            $generalService = $this->generalService;
            $pointer["to"] = $user->getEmail();
            $pointer["fromName"] = "Bau Dispatch";
            $pointer['subject'] = "Wallet Transaction";

            $template['template'] = "general-mail-transaction-success";
            $template["var"] = array(
                "amount" => $amount,
                "fullname" => $user->getFullName(),
                "logo" => "KK"
            );
            $generalService->sendMails($pointer, $template);


            $em->flush();
            return $wallet;
        }
    }

    public function fundWalletLogic($data)
    {
        if ($data["status"] == FlutterwaveService::PAYMENT_SUCCESS) {
            $verifyData = $this->flutterwaveService->verifyPaymentApi($data);
            if ($verifyData instanceof \Exception) {
                throw new Exception("Payment Veirification Error");
            } elseif ($verifyData->status == "success") {

                return $this->fundwallet($verifyData->data->chargedamount);
            } else {
                throw new \Exception("Payment Not Successfull");
            }
            // fun the wallet
        } else {
            throw new \Exception("Payment Not Successful");
        }
    }

    private function fundwallet($amount = 0)
    {
        /**
         *
         * @var EntityManager $em
         */
        $em = $this->generalService->getEntityManager();
        try {
            $userId = $this->apiAuthService->getIdentity();
            /**
             *
             * @var User $user
             */
            $user = $em->find(User::class, $userId);
            $walletActivity = new WalletActivity();

            /**
             *
             * @var Wallet $walletEntity
             */
            $walletEntity = $user->getWallet();
            $newBalance = 0;
            if ($walletEntity == NULL) {
                $newBalance = 0 + $amount;
                $this->createnewWallet($user, $amount);
            } else {

                $newBalance = $walletEntity->getBalance() + $amount;
                $walletEntity->setBalance($newBalance)->setUpdatedOn(new \Datetime());
            }
            $em->persist($walletEntity);
            $this->createWalletActivity(self::WALLET_ACTIVITY_DEPOSIT, $amount, $newBalance);
            $em->flush();
            // transaction
            // email notification
            return $walletEntity;
        } catch (\Exception $e) {
            throw new Exception("Can not fund wallet now");
        }
    }

    private function debitwallet()
    {
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
        try {
        } catch (\Exception $e) {
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

