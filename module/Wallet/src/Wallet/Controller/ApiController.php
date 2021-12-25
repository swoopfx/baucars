<?php
namespace Wallet\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Json\Json;
use Laminas\View\Model\JsonModel;
use Wallet\Entity\Wallet;
use General\Service\GeneralService;
use General\Service\FlutterwaveService;
use JWT\Service\ApiAuthenticationService;
use Wallet\Service\WalletService;
use Laminas\InputFilter\InputFilter;
use CsnUser\Entity\User;
use General\Service\MonnifyService;
use Laminas\Http\PhpEnvironment\RemoteAddress;
use General\Service\PaystackService;

/**
 *
 * @author mac
 *        
 */
class ApiController extends AbstractActionController
{

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var ApiAuthenticationService
     */
    private $apiAuthService;

    /**
     *
     * @var FlutterwaveService
     */
    private $flutterwaveService;

    /**
     *
     * @var MonnifyService
     */
    private $monnifyService;

    /**
     *
     * @var PaystackService
     */
    private $paystackService;

    /**
     *
     * @var WalletService
     */
    private $walletService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
        $request = $this->getRequest();
        $response = $this->getResponse();
        
        if (is_bool($this->apiAuthService->hasIdentity())) {
            if (! $this->apiAuthService->hasIdentity()) {
                
                // var_dump($apiAuthService->hasIdentity())
                // set status 403 (forbidden)
                $response->setStatusCode(403);
                $response->setContent(Json::encode([
                    "message" => "Not Authorized"
                ]));
                
                return $response;
            }
        } else {
            // set status 403 (forbidden)
            $response->setStatusCode(401);
            $response->setContent(Json::encode([
                "message" => "Not Authorized"
            ]));
            
            return $response;
        }
    }

    /**
     *
     * @OA\GET( path="/wallet/api/wallet-balance", tags={"Wallet"}, description="Used to retrive the present wallet value of the logged in user",
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function walletBalanceAction()
    {
        try {
            
            /**
             *
             * @var EntityManager $em
             */
            
            $apiAuthService = $this->apiAuthService;
            $userId = $apiAuthService->getIdentity();
            $em = $this->generalService->getEntityManager();
            $jsonModel = new JsonModel();
            /**
             *
             * @var Wallet $repo
             */
            $repo = $em->getRepository(Wallet::class)->findOneBy([
                "user" => $userId
            ]);
            $jsonModel->setVariables([
                "balance" => ($repo == null ? 0 : $repo->getBalance())
            ]);
            return $jsonModel;
        } catch (\Exception $e) {
            return Json::encode($e->getMessage());
        }
    }

    /**
     *
     *
     *
     * @OA\POST( path="/wallet/api/charge-wallet", tags={"Wallet"}, description="This is used to charge the wallet of the user",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"amount"},
     * @OA\Property(property="amount", type="float", example="240.90"),
     *
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function chargeWalletAction()
    {
        try {
            
            $jsonModel = new JsonModel();
            $request = $this->getRequest();
            $response = $this->getResponse();
            $response->setStatusCode(400);
            if ($request->isPost()) {
                // $post = $request->getPost();
                $post = Json::decode(file_get_contents("php://input"));
                
                try {
                    $inputFilter = new InputFilter();
                    $inputFilter->add(array(
                        'name' => 'amount',
                        'required' => true,
                        'allow_empty' => false,
                        'filters' => array(
                            array(
                                'name' => 'StripTags'
                            ),
                            array(
                                'name' => 'StringTrim'
                            )
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Amount is required'
                                    )
                                )
                            )
                        )
                    ));
                    $inputFilter->setData(get_object_vars($post));
                    
                    if ($inputFilter->isValid()) {
                        $data = $inputFilter->getValues();
                        
                        $resp = $this->walletService->chargeWallet($data["amount"]);
                        $response->setStatusCode(201);
                        $jsonModel->setVariables([
                            "message" => "success",
                            "txRef" => uniqid("inv")
                        ]);
                    } else {
                        $jsonModel->setVariables([
                            "message" => $inputFilter->getMessages()
                        ]);
                    }
                } catch (\Exception $e) {
                    $jsonModel->setVariables([
                        "message" => $e->getMessage()
                    ]);
                }
            } else {
                $jsonModel->setVariables([
                    "message" => "Invalid Action"
                ]);
            }
        } catch (\Exception $e) {
            $jsonModel->setVariables([
                "Noooo"
            ]);
        }
        return $jsonModel;
    }

    /**
     *
     * @OA\GET( path="/wallet/api/payment-config", tags={"Wallet"}, description="Call this function to get type of payment and its configuration files",
     *
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     *
     *
     */
    public function paymentConfigAction()
    {
        $response = $this->getResponse();
        try {
            $jsonModel = new JsonModel();
            $flutterwaveService = $this->flutterwaveService;
            $jsonModel->setVariables([
                "channel" => "Flutterwave",
                "public_key" => $flutterwaveService->getFlutterwavePublicKey(),
                "secret_key" => $flutterwaveService->getFlutterwaveSecretKey(),
                "encrption_key" => $flutterwaveService->getFlutterwaveEncrypKey()
            ]);
            return $jsonModel;
        } catch (\Exception $e) {
            $response->setStatusCode(403);
            return Json::encode($e->getMessage());
        }
    }

    /**
     *
     * @OA\GET( path="/wallet/api/prefund-wallet-monnify", tags={"Wallet"}, description="This api is prequel funding of a wallet. it retrives preconfig parameters required to fund the wallet. Call this function to get details that would be fed to the flutterwave api",
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     *
     *
     */
    public function prefundWalletMonnifyAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        $remote = new RemoteAddress();
        try {
            $em = $this->generalService->getEntityManager();
            $userid = $this->apiAuthService->getIdentity();
            /**
             *
             * @var User $user
             */
            $user = $em->find(User::class, $userid);
            $flutterwaveService = $this->monnifyService;
            $jsonModel->setVariables([
                "channel" => "Monnify",
                "secret_key" => $flutterwaveService->getSecretKey(),
                "api_key" => $flutterwaveService->getApikey(),
                "contract_code" => $flutterwaveService->getContractCode(),
                "sub_account" => $flutterwaveService->getSubAccount(),
                "ip" => $remote->getIpAddress(),
                "bau_tx_ref" => uniqid("inv"),
                "customer" => [
                    'uid' => $user->getUserUid(),
                    "full_name" => $user->getFullName(),
                    "email" => $user->getEmail(),
                    "phoneNumber" => $user->getPhoneNumber()
                ]
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(403);
            return Json::encode($e->getMessage());
        }
        return $jsonModel;
    }

    /**
     *
     * @OA\GET( path="/wallet/api/prefund-wallet-paystack", tags={"Wallet"}, description="This api is prequel funding of a wallet. it retrives preconfig parameters required to fund the wallet. Call this function to get details that would be fed to the flutterwave api",
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     *
     *
     */
    public function prefundWalletPaystackAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        $remote = new RemoteAddress();
        try {
            $em = $this->generalService->getEntityManager();
            $userid = $this->apiAuthService->getIdentity();
            /**
             *
             * @var User $user
             */
            $user = $em->find(User::class, $userid);
            $flutterwaveService = $this->paystackService;
            $jsonModel->setVariables([
                "channel" => "Paystack",
                "secret_key" => $flutterwaveService->getSecretKey(),
                "public_key" => $flutterwaveService->getPublicKey(),
                // "contract_code" => $flutterwaveService->getContractCode(),
                // "sub_account"=>$flutterwaveService->getSubAccount(),
                "ip" => $remote->getIpAddress(),
                "bau_tx_ref" => uniqid("inv"),
                "customer" => [
                    'uid' => $user->getUserUid(),
                    "full_name" => $user->getFullName(),
                    "email" => $user->getEmail(),
                    "phoneNumber" => $user->getPhoneNumber()
                ]
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(403);
            return Json::encode($e->getMessage());
        }
        return $jsonModel;
    }

    /**
     *
     * @OA\GET( path="/wallet/api/prefund-wallet", tags={"Wallet"}, description="This api is prequel funding of a wallet. it retrives preconfig parameters required to fund the wallet. Call this function to get details that would be fed to the flutterwave api",
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     *
     *
     */
    public function prefundWalletAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        try {
            $em = $this->generalService->getEntityManager();
            $userid = $this->apiAuthService->getIdentity();
            /**
             *
             * @var User $user
             */
            $user = $em->find(User::class, $userid);
            $flutterwaveService = $this->flutterwaveService;
            $jsonModel->setVariables([
                "channel" => "Flutterwave",
                "public_key" => $flutterwaveService->getFlutterwavePublicKey(),
                "secret_key" => $flutterwaveService->getFlutterwaveSecretKey(),
                "encrption_key" => $flutterwaveService->getFlutterwaveEncrypKey(),
                "bau_tx_ref" => uniqid("inv"),
                "customer" => [
                    'uid' => $user->getUserUid(),
                    "full_name" => $user->getFullName(),
                    "email" => $user->getEmail(),
                    "phoneNumber" => $user->getPhoneNumber()
                ]
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(403);
            return Json::encode($e->getMessage());
        }
        return $jsonModel;
    }

    /**
     *
     *
     *
     * @OA\POST( path="/wallet/api/fund-wallet", tags={"Wallet"}, description="This function is called after a successful call to fluuterwave portal and ",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"txRef", "status", "amountPayed"},
     * @OA\Property(property="status", type="string", example="success", description="Flutterwave transaction reference Id"),
     * @OA\Property(property="txRef", type="string", example="booking61706f10b762a", description="Transaction Reference generated by our system"),
     * @OA\Property(property="amountPayed", type="string", example="234.00", description="Amount charged by flutterwave"),
     *
     * )
     * ),
     * ),
     * @OA\Response(response="201", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function fundWalletAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setStatusCode(400);
       
            if ($request->isPost()) {
                try {
                $post = Json::decode(file_get_contents("php://input"));
//                 var_dump($post);
                $this->walletService->fundWalletLogic(get_object_vars($post));
                
                $response->setStatusCode(201);
                $jsonModel->setVariables([
                    "data" => "Wallet Funded"
                ]);
                } catch (\Exception $e) {
                    return Json::encode($e->getMessage());
                }
            } else {
                $response->setStatusCode(403);
                $jsonModel->setVariables([
                    "message" => "Not Perminted Verb"
                ]);
            }
       
        return $jsonModel;
    }

    /**
     *
     *
     *
     * @OA\POST( path="/wallet/api/verifypayment", tags={"Wallet"}, description="This function is verify flutterwave transaction",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"txRef", "status", "amountPayed"},
     * @OA\Property(property="status", type="string", example="success", description="Flutterwave transaction reference Id"),
     * @OA\Property(property="txRef", type="string", example="booking61706f10b762a", description="Transaction Reference generated by our system"),
     * @OA\Property(property="amountPayed", type="string", example="234.00", description="Amount charged by flutterwave"),
     *
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function verifypaymentAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setStatusCode(400);
        try {
            if ($request->isPost()) {
                $post = Json::decode(file_get_contents("php://input"));
                $data = $this->walletService->verifyPayment(get_object_vars($post));
                
                $response->setStatusCode(201);
                // $jsonModel->setVariables([
                // "message" => "Wallet Funded"
                // ]);
                return new JsonModel($data);
            } else {
                $response->setStatusCode(403);
                $jsonModel->setVariables([
                    "message" => "Not Perminted Verb"
                ]);
            }
        } catch (\Exception $e) {
            return Json::encode($e->getMessage());
        }
        return $jsonModel;
    }

    /**
     *
     *
     *
     * @OA\POST( path="/wallet/api/verifypaymentmonnify", tags={"Wallet"}, description="This function is verify flutterwave transaction",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"transactionReference", "amountPayed"},
     * @OA\Property(property="status", type="string", example="success", description="Flutterwave transaction reference Id"),
     * @OA\Property(property="transactionReference", type="string", example="1234fknlfjsvnrvkjsnv", description="This is the reference generated by monnify"),
     * @OA\Property(property="amountPayed", type="string", example="234.00", description="Amount charged by monnify"),
     *
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function verifyPaymentmonnifyAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setStatusCode(400);
        try {
            if ($request->isPost()) {
                $post = Json::decode(file_get_contents("php://input"));
                // $data = $this->walletService->verifyPayment(get_object_vars($post));
                $data = $this->monnifyService->transactionStatus(get_object_vars($post));
                $response->setStatusCode(200);
                // $jsonModel->setVariables([
                // "message" => "Wallet Funded"
                // ]);
                return new JsonModel($data);
            } else {
                $response->setStatusCode(403);
                $jsonModel->setVariables([
                    "message" => "Not Perminted Verb"
                ]);
            }
        } catch (\Exception $e) {
            return Json::encode($e->getMessage());
        }
        return $jsonModel;
    }

    /**
     *
     *
     *
     * @OA\POST( path="/wallet/api/verifypaymentpaystack", tags={"Wallet"}, description="This function is verify flutterwave transaction",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"transactionReference", "amountPayed"},
     * @OA\Property(property="status", type="string", example="success", description="Flutterwave transaction reference Id"),
     * @OA\Property(property="transactionReference", type="string", example="1234fknlfjsvnrvkjsnv", description="This is the reference generated by monnify"),
     * @OA\Property(property="amountPayed", type="string", example="234.00", description="Amount charged by monnify"),
     *
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function verifypaymentpaystackAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->setStatusCode(400);
        
        if ($request->isPost()) {
            try {
               
                $post = Json::decode(file_get_contents("php://input"));
                $data = $this->paystackService->verifyTrasaction(get_object_vars($post));
                
                $response->setStatusCode(200);
                $jsonModel->setVariables([
                    "data"=>$data
                ]);
               
            } catch (\Exception $e) {
                return Json::encode($e->getMessage());
            }
        } else {
            $response->setStatusCode(403);
            $jsonModel->setVariables([
                "message" => "Not Perminted Verb"
            ]);
        }
        
        return $jsonModel;
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
     * @return the $apiAuthService
     */
    public function getApiAuthService()
    {
        return $this->apiAuthService;
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
     * @param field_type $apiAuthService            
     */
    public function setApiAuthService($apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
        return $this;
    }

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
     * @param \General\Service\FlutterwaveService $flutterwaveService            
     */
    public function setFlutterwaveService($flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
        return $this;
    }

    /**
     *
     * @return the $walletService
     */
    public function getWalletService()
    {
        return $this->walletService;
    }

    /**
     *
     * @param \Wallet\Service\WalletService $walletService            
     */
    public function setWalletService($walletService)
    {
        $this->walletService = $walletService;
        return $this;
    }

    /**
     *
     * @return the $monnifyService
     */
    public function getMonnifyService()
    {
        return $this->monnifyService;
    }

    /**
     *
     * @param \General\Service\MonnifyService $monnifyService            
     */
    public function setMonnifyService($monnifyService)
    {
        $this->monnifyService = $monnifyService;
        return $this;
    }

    /**
     *
     * @return the $paystackService
     */
    public function getPaystackService()
    {
        return $this->paystackService;
    }

    /**
     *
     * @param \General\Service\PaystackService $paystackService            
     */
    public function setPaystackService($paystackService)
    {
        $this->paystackService = $paystackService;
        return $this;
    }
}

