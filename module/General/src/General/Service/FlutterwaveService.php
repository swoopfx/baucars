<?php
namespace General\Service;

use Doctrine\ORM\EntityManager;
use Zend\Http\Client;
use Zend\Session\Container;
use Application\Entity\Transactions;
use General\Entity\TransactionStatus;
use CsnUser\Entity\User;
use Customer\Entity\CustomerBooking;
use Zend\Http\Request;
use Application\Entity\InitatedTransfer;
use Application\Entity\TransferStatus;
use Application\Entity\ConcludedTransfer;
use Zend\Authentication\AuthenticationService;

/**
 *
 * @author otaba
 *        
 */
class FlutterwaveService
{

    const TRANSFER_STATUS_INITIATED = 10;

    const TRANSFER_STATUS_COMPLETED = 200;

    const TRANSFER_STATUS_FAILED = 300;

    private $jsonContent = "application/json";
    
    /**
     * 
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Container
     */
    private $flutterSession;

    /**
     * 
     * @var GeneralService
     */
    private $generalService;

    private $flutterwaveConfig;

    /**
     *
     * @var string
     */
    private $flutterwavePublicKey;

    /**
     *
     * @var string
     */
    private $flutterwaveSecretKey;

    /**
     *
     * @var string
     */
    private $flutterwaveEncrypKey;

    // private $
    
    // Flutterwave
    
    /**
     *
     * @var string
     */
    private $txRef;

    /**
     *
     * @var int
     */
    private $transactionId;

    /**
     *
     * @var integer
     */
    private $transactStatus;

    /**
     *
     * @var string
     */
    private $amountPayed;

    private $settledAmount;

    private $flwRef;

    private $flwId;

    private $transactUser;

    /**
     *
     * @var CustomerBooking
     */
    private $booking;

    private $header = [];

    private $transferRecipientAcc;

    private $transaferRecipientBank;

    private $transferAmount;

    private $transferResponseRaveRef;

    private $initiatedTransferId;

    const TRANSACTION_STATUS_PAID = 100;

    const TRANSACTION_STATUS_FAILED = 200;

    // TODO - Insert your code here
    public static function generateTransaction()
    {
        return uniqid("booking");
    }

    /**
     */
    public function __construct()
    {
        $this->header = [
            "Accept" => $this->jsonContent
            // "Authorization" => "Bearer " . $this->flutterSecretKey
        ];
    }

    public function verifyPayment()
    {
        $endPoint = "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify";
        $flutterSessioin = $this->flutterSession;
        $body = [
            "txref" => $this->txRef,
            "SECKEY" => $this->flutterwaveSecretKey
        ];
        $this->header["Content-Type"] = $this->jsonContent;
        $client = new Client();
        $client->setMethod("POST");
        $client->setUri($endPoint);
        $client->setHeaders($this->header);
        $client->setRawBody(json_encode($body));
        $response = $client->send();
        if ($response->isSuccess()) {
            $rBody = json_decode($response->getBody());
            
            $flutterSessioin->amountPayed = $rBody->data->amount;
            // $flutterSessioin->
            // insert into transation table
            return $rBody;
        } else {
            $rBody = json_decode($response->getBody());
            throw new \Exception($rBody->message);
        }
    }

    /**
     *
     * @return \Application\Entity\Transactions
     */
    public function hydrateTransaction()
    {
        $em = $this->entityManager;
        $auth = $this->auth;
        $transactionEntity = new Transactions();
        $flutterSession = $this->flutterSession;
        $transactionEntity->setCreatedOn(new \DateTime())
            ->setAmount($this->amountPayed)
            ->setFlwId($this->flwId)
            ->setFlwRef($this->flwRef)
            ->setStatus($em->find(TransactionStatus::class, $this->transactStatus))
            ->setSettledAmount($this->settledAmount)
            ->setTxRef($this->txRef)
            ->setBooking($this->booking)
            ->setUser($em->find(User::class, $this->transactUser));
        
        $em->persist($transactionEntity);
       $generalService = $this->generalService;
       $pointer["to"] = $auth->getIdentity()->getEmail();
       $pointer["fromName"] = "Bau Cars Limited";
       $pointer['subject'] = "Successfull Transaction";
       
       $template['template'] = "";
       $template["var"] = [
           
       ];
       $generalService->sendMails($pointer, $template);
        // send transaction mail to customer
        return $transactionEntity;
        
        // send transaction mail
    }

    public function transaferCost()
    {
        $endpoint = "https://api.ravepay.co/v2/gpx/transfers/fee";
        $params = [
            "seckey" => $this->flutterwaveSecretKey,
            "currency" => "NGN",
            "amount" => $this->settledAmount
        ];
        
        // $this->header["Content-Type"] = $this->jsonContent;
        $client = new Client();
        $client->setMethod(Request::METHOD_GET);
        $client->setUri($endpoint);
        $client->setHeaders($this->header);
        $client->setParameterGet($params);
        // $client->setRawBody(json_encode($params));
        $response = $client->send();
        if ($response->isSuccess()) {
            $rBody = json_decode($response->getBody());
            return $rBody;
        } else {
            $rBody = json_decode($response->getBody());
            throw new \Exception($rBody->message);
        }
    }

    private function transferUid()
    {
        return uniqid("transfer");
    }

    public function initiateTrasnfer()
    {
        $transfercost = $this->transaferCost();
       
        $this->initiatedTransferId = $this->hydrateTransferInitiate();
        $transferCharge = $transfercost->data[0]->fee + 15;
        $uid = $this->transferUid();
        $transferAmount = $this->settledAmount - $transferCharge;
        $endPoint = "https://api.ravepay.co/v2/gpx/transfers/create";
        $body = [
            "account_bank" => "058",
            "account_number" => "0018666738",
            "amount" => $transferAmount,
            "currency" => "NGN",
            "narration" => "Booking Remittance",
            "reference" => $uid,
            "seckey" => $this->flutterwaveSecretKey
        ];
        $this->header["Content-Type"] = $this->jsonContent;
        $client = new Client();
        $client->setMethod("POST");
        $client->setUri($endPoint);
        $client->setHeaders($this->header);
        $client->setRawBody(json_encode($body));
        $response = $client->send();
        
        if ($response->isSuccess()) {
            $rBody = json_decode($response->getBody());
            
            if ($rBody->status == "success") {
                $rData = $rBody->data;
                $this->hydrateTransferConclude($rBody);
            }
            
            return $rBody;
        } else {
            $rBody = json_decode($response->getBody());
            throw new \Exception($rBody->message);
        }
    }

    public function hydrateTransferInitiate()
    {
        $em = $this->entityManager;
        $init = new InitatedTransfer();
        $init->setCreatedOn(new \DateTime())
            ->setTransaction($em->find(Transactions::class, $this->getTransactionId()))
            ->setTransferAmount($this->transferAmount)
            ->setTransferStatus($em->find(TransferStatus::class, self::TRANSFER_STATUS_INITIATED))
            ->setTransferUid(self::transferUid());
        $em->persist($init);
        $em->flush();
        return $init->getId();
    }

    public function hydrateTransferConclude($data)
    {
        $em = $this->entityManager;
        $conclude = new ConcludedTransfer();
        $conclude->setCreatedOn(new \DateTime())
            ->setAmountTransfered($data->data->amount)
            ->setInitiateId($em->find(InitatedTransfer::class, $this->initiatedTransferId))
            ->setRaveId($data->data->id)
            ->setRaveMessage($data->message)
            ->setRaveRef($data->data->reference);
        $em->persist($conclude);
        $em->flush();
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
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @return the $flutterwavePublicKey
     */
    public function getFlutterwavePublicKey()
    {
        return $this->flutterwavePublicKey;
    }

    /**
     *
     * @return the $flutterwaveSecretKey
     */
    public function getFlutterwaveSecretKey()
    {
        return $this->flutterwaveSecretKey;
    }

    /**
     *
     * @return the $flutterwaveEncrypKey
     */
    public function getFlutterwaveEncrypKey()
    {
        return $this->flutterwaveEncrypKey;
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
     * @param field_type $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param string $flutterwavePublicKey            
     */
    public function setFlutterwavePublicKey($flutterwavePublicKey)
    {
        $this->flutterwavePublicKey = $flutterwavePublicKey;
        return $this;
    }

    /**
     *
     * @param string $flutterwaveSecretKey            
     */
    public function setFlutterwaveSecretKey($flutterwaveSecretKey)
    {
        $this->flutterwaveSecretKey = $flutterwaveSecretKey;
        return $this;
    }

    /**
     *
     * @param string $flutterwaveEncrypKey            
     */
    public function setFlutterwaveEncrypKey($flutterwaveEncrypKey)
    {
        $this->flutterwaveEncrypKey = $flutterwaveEncrypKey;
        return $this;
    }

    /**
     *
     * @return the $flutterSession
     */
    public function getFlutterSession()
    {
        return $this->flutterSession;
    }

    /**
     *
     * @return the $flutterwaveConfig
     */
    public function getFlutterwaveConfig()
    {
        return $this->flutterwaveConfig;
    }

    /**
     *
     * @return the $txRef
     */
    public function getTxRef()
    {
        return $this->txRef;
    }

    /**
     *
     * @return the $amountPayed
     */
    public function getAmountPayed()
    {
        return $this->amountPayed;
    }

    /**
     *
     * @return the $header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     *
     * @param \Zend\Session\Container $flutterSession            
     */
    public function setFlutterSession($flutterSession)
    {
        $this->flutterSession = $flutterSession;
        return $this;
    }

    /**
     *
     * @param field_type $flutterwaveConfig            
     */
    public function setFlutterwaveConfig($flutterwaveConfig)
    {
        $this->flutterwaveConfig = $flutterwaveConfig;
        return $this;
    }

    /**
     *
     * @param string $txRef            
     */
    public function setTxRef($txRef)
    {
        $this->txRef = $txRef;
        return $this;
    }

    /**
     *
     * @param string $amountPayed            
     */
    public function setAmountPayed($amountPayed)
    {
        $this->amountPayed = $amountPayed;
        return $this;
    }

    /**
     *
     * @param
     *            Ambigous <multitype:, multitype:string > $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     *
     * @return the $transactStatus
     */
    public function getTransactStatus()
    {
        return $this->transactStatus;
    }

    /**
     *
     * @return the $flwRef
     */
    public function getFlwRef()
    {
        return $this->flwRef;
    }

    /**
     *
     * @return the $flwId
     */
    public function getFlwId()
    {
        return $this->flwId;
    }

    /**
     *
     * @param number $transactStatus            
     */
    public function setTransactStatus($transactStatus)
    {
        $this->transactStatus = $transactStatus;
        return $this;
    }

    /**
     *
     * @param field_type $flwRef            
     */
    public function setFlwRef($flwRef)
    {
        $this->flwRef = $flwRef;
        return $this;
    }

    /**
     *
     * @param field_type $flwId            
     */
    public function setFlwId($flwId)
    {
        $this->flwId = $flwId;
        return $this;
    }

    /**
     *
     * @return the $transactUser
     */
    public function getTransactUser()
    {
        return $this->transactUser;
    }

    /**
     *
     * @param field_type $transactUser            
     */
    public function setTransactUser($transactUser)
    {
        $this->transactUser = $transactUser;
        return $this;
    }

    /**
     *
     * @return the $settledAmount
     */
    public function getSettledAmount()
    {
        return $this->settledAmount;
    }

    /**
     *
     * @param field_type $settledAmount            
     */
    public function setSettledAmount($settledAmount)
    {
        $this->settledAmount = $settledAmount;
        return $this;
    }

    /**
     *
     * @return the $booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     *
     * @param \Customer\Entity\CustomerBooking $booking            
     */
    public function setBooking($booking)
    {
        $this->booking = $booking;
        return $this;
    }

    /**
     *
     * @return the $transferRecipientAcc
     */
    public function getTransferRecipientAcc()
    {
        return $this->transferRecipientAcc;
    }

    /**
     *
     * @return the $transaferRecipientBank
     */
    public function getTransaferRecipientBank()
    {
        return $this->transaferRecipientBank;
    }

    /**
     *
     * @return the $transferAmount
     */
    public function getTransferAmount()
    {
        return $this->transferAmount;
    }

    /**
     *
     * @param field_type $transferRecipientAcc            
     */
    public function setTransferRecipientAcc($transferRecipientAcc)
    {
        $this->transferRecipientAcc = $transferRecipientAcc;
        return $this;
    }

    /**
     *
     * @param field_type $transaferRecipientBank            
     */
    public function setTransaferRecipientBank($transaferRecipientBank)
    {
        $this->transaferRecipientBank = $transaferRecipientBank;
        return $this;
    }

    /**
     *
     * @param field_type $transferAmount            
     */
    public function setTransferAmount($transferAmount)
    {
        $this->transferAmount = $transferAmount;
        return $this;
    }

    /**
     *
     * @return the $initiatedTransferId
     */
    public function getInitiatedTransferId()
    {
        return $this->initiatedTransferId;
    }

    /**
     *
     * @param field_type $initiatedTransferId            
     */
    public function setInitiatedTransferId($initiatedTransferId)
    {
        $this->initiatedTransferId = $initiatedTransferId;
        return $this;
    }

    /**
     *
     * @return the $transactionId
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     *
     * @param number $transactionId            
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }
    /**
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param \Zend\Authentication\AuthenticationService $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

}

