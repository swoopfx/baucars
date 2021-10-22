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
                            "message" => "Success",
                            "txRef"=>uniqid("inv"),
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
     * @OA\GET( path="/wallet/api/prefund-wallet", tags={"Wallet"}, description="Call this function to get details that would be fed to the flutterwave api",
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
                    "email" => $user->getEmail()
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
     * @OA\Schema(required={"txRef", "status"},
     * @OA\Property(property="status", type="string", example="success", description="Flutterwave transaction reference Id"),
     * @OA\Property(property="txRef", type="string", example="booking61706f10b762a", description="Google Place id (Unique) of the pickup"),
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
        try {
            if ($request->isPost()) {
                $post = Json::decode(file_get_contents("php://input"));
                $this->walletService->fundWalletLogic(get_object_vars($post));
               
                $response->setStatusCode(201);
                $jsonModel->setVariables([
                    "message"=>"Wallet Funded"
                ]);
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
}

