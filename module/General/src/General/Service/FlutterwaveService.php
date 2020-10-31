<?php
namespace General\Service;

use Doctrine\ORM\EntityManager;
use Zend\Http\Client;
use Zend\Session\Container;
use Application\Entity\Transactions;
use General\Entity\TransactionStatus;
use CsnUser\Entity\User;

/**
 *
 * @author otaba
 *        
 */
class FlutterwaveService
{

    private $jsonContent = "application/json";

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

    private $header = [];

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

    public function hydrateTransaction()
    {
        $em = $this->entityManager;
        $transactionEntity = new Transactions();
        $flutterSession = $this->flutterSession;
        $transactionEntity->setCreatedOn(new \DateTime())
            ->setAmount($this->amountPayed)
            ->setFlwId($this->flwId)
            ->setFlwRef($this->flwRef)
            ->setStatus($em->find(TransactionStatus::class, $this->transactStatus))
            ->setSettledAmount($this->settledAmount)
            ->setTxRef($this->txRef)
            ->setUser($em->find(User::class, $this->transactUser));
        
        $em->persist($transactionEntity);
        $em->flush();
        
        // send transaction mail
    }

    public function transferFunds()
    {
        $endPoint = "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify";
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
            return $rBody;
        } else {
            $rBody = json_decode($response->getBody());
            throw new \Exception($rBody->message);
        }
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
     * @return the $settledAmount
     */
    public function getSettledAmount()
    {
        return $this->settledAmount;
    }

    /**
     * @param field_type $settledAmount
     */
    public function setSettledAmount($settledAmount)
    {
        $this->settledAmount = $settledAmount;
        return $this;
    }

}

