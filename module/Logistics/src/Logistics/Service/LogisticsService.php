<?php
namespace Logistics\Service;

use Laminas\Http\Request;
use Laminas\Http\Client;
use Laminas\Json\Json;
use Laminas\InputFilter\InputFilter;
use Laminas\View\Model\JsonModel;
use Logistics\Entity\LogisticsRequest;
use Doctrine\ORM\EntityManager;
use Logistics\Entity\LogisticsPaymentMode;
use Logistics\Entity\LogisticsServiceType;
use CsnUser\Entity\User;
use JWT\Service\ApiAuthenticationService;
use Wallet\Service\WalletService;
use General\Service\FlutterwaveService;

/**
 *
 * @author mac
 *        
 */
class LogisticsService
{

    const LOGISTICS_DELIVERY_TYPE_NORMAL = 10;

    const LOGISTICS_PAYMENT_MODE_WALLET = 10;

    const LOGISTICS_PAYMENT_MODE_CARD = 20;

    const LOGISTICS_MINIMUM_PRICE = 300;

    const LOGISTICS_EXPRESS_FEE = 1000;

    // In Naira
    const LOGISTICS_MINIMUM_DISTANCE = 5;

    const LOGISTICS_SERVICE_TYPE_DELIVER = 10;

    const LOGISTICS_SERVICE_TYPE_PICKUP = 20;

    const LOGISTICS_SERVICE_TYPE_DROP_RETURN = 10;

    const LOGISTICS_DELIVERY_MODE_NORMAL = 10;

    const LOGISTICS_DELIVERY_MODE_EXPRESS = 20;

    // kilometers
    private $generalService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var ApiAuthenticationService
     */
    private $apiAuthService;

    /**
     *
     * @var WalletService
     */
    private $walletService;

    /**
     *
     * @var FlutterwaveService
     */
    private $flutterwaveService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    private function invoiceuid()
    {
        return uniqid("invoice");
    }

    /**
     *
     * @param string $matrix1
     *            Pickup placeId
     * @param unknown $matrix2
     *            Destination PlaceId
     * @throws \Exception
     * @return mixed|unknown|void|array|stdClass|NULL|boolean|string
     */
    public function distanceMatrix($matrix1, $matrix2)
    {
        if ($matrix1 != NULL && $matrix2 != NULL) {
            
            $endPoint = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=place_id:{$matrix1}&key=AIzaSyBobkXMM-uzqQLM5pqs_n7prJKJJ4-JK5I&destinations=place_id:{$matrix2}";
            $client = new Client();
            
            $client->setMethod(Request::METHOD_GET);
            $client->setUri($endPoint);
            
            $response = $client->send();
            
            if ($response->isSuccess()) {
                
                return Json::decode($response->getBody());
            }
        } else {
            throw new \Exception("Absent Identifier");
        }
    }

    private function calculatePricing($distanceValue, $serviceType, $deliveryType = 10)
    {
        if ($deliveryType == self::LOGISTICS_DELIVERY_MODE_NORMAL) {
            return $this->normalpricing($distanceValue, $serviceType);
        } else {
            $this->expresspricing($distanceValue, $serviceType);
        }
    }

    private function pricing($distanceValue)
    {
        if ($distanceValue < self::LOGISTICS_MINIMUM_DISTANCE) {
            return self::LOGISTICS_MINIMUM_PRICE;
        } else {
            return $distanceValue * 100;
        }
    }

    /**
     *
     * @param int $distanceValue            
     * @param int $serviceType            
     * @return number
     */
    private function normalpricing(int $distanceValue, int $serviceType = null)
    {
        if ($serviceType < 30) {
            return round($this->pricing($distanceValue), 2);
        } else {
            $finalPrice = $this->pricing($distanceValue);
            return round(($finalPrice + ($finalPrice * 0.5)), 2);
        }
    }

    /**
     *
     * @param int $distanceValue            
     * @param int $serviceType            
     * @return number
     */
    private function expresspricing(int $distanceValue, int $serviceType = null)
    {
        if ($serviceType < 30) {
            return (round($this->pricing($distanceValue), 2) + self::LOGISTICS_EXPRESS_FEE);
        } else {
            $finalPrice = $this->pricing($distanceValue);
            return (round(($finalPrice + ($finalPrice * 0.5)), 2) + self::LOGISTICS_EXPRESS_FEE);
        }
    }

    private function filter($post)
    {}

    /**
     * This fun
     *
     * @param array $post            
     * @return array
     */
    public function priceandDistanceCalculator($post)
    {
        $inputFilter = new InputFilter();
        
        $inputFilter->add(array(
            'name' => 'pickUpPlaceId',
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
                            'isEmpty' => 'Pick up PLace Id  is required'
                        )
                    )
                )
            
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'destinationPlaceId',
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
                            'isEmpty' => 'Destination PlaceId is required'
                        )
                    )
                )
            
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'pickAddress',
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
                            'isEmpty' => 'Pick up address is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'destinationAddress',
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
                            'isEmpty' => 'Destination Address is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'pickupLat',
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
                            'isEmpty' => 'Pick Up Latidue is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'pickupLong',
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
                            'isEmpty' => 'Pick Up longitude is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'destinationLat',
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
                            'isEmpty' => 'Destination Latitude is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'destinationLong',
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
                            'isEmpty' => 'Destination Latitude is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'quantity',
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
                            'isEmpty' => 'Quantity is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'iten_name',
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
                            'isEmpty' => 'Item Name is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'service_type',
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
                            'isEmpty' => 'Service Type is required'
                        )
                    )
                )
            )
        ));
        
        $inputFilter->add(array(
            'name' => 'delivery_type',
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
                            'isEmpty' => 'Delivery Type is required'
                        )
                    )
                )
            )
        ));
        $inputFilter->setData($post);
        
        if ($inputFilter->isValid()) {
            // var_dump("Something");
            $data = $inputFilter->getValues();
            
            $dm = $this->distanceMatrix($data["pickUpPlaceId"], $data["destinationPlaceId"]);
            
            $distanceValue = $dm->rows[0]->elements[0]->distance->value;
            // var_dump($distanceValue);
            $distanceText = $dm->rows[0]->elements[0]->distance->text;
            $dmDistance = $distanceValue / 1000;
            $price = $this->calculatePricing($dmDistance, $data["service_type"], $data["delivery_type"]);
            $data["price"] = $price;
            $data['distance'] = $distanceText;
            $data["distanceValue"] = $distanceValue;
            $data["bauTxRef"] = $this->invoiceuid();
            return $data;
        } else {
            
            throw new \Exception(Json::encode($inputFilter->getMessages()));
        }
    }

    public function createRequest($post)
    {
        if ($post["status"] == "success") {
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'pickUpPlaceId',
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
                                'isEmpty' => 'Pick up PLace Id  is required'
                            )
                        )
                    )
                
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'destinationPlaceId',
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
                                'isEmpty' => 'Destination PlaceId is required'
                            )
                        )
                    )
                
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'pickAddress',
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
                                'isEmpty' => 'Pick up address is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'destinationAddress',
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
                                'isEmpty' => 'Destination Address is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'pickupLat',
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
                                'isEmpty' => 'Pick Up Latidue is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'pickupLong',
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
                                'isEmpty' => 'Pick Up longitude is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'destinationLat',
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
                                'isEmpty' => 'Destination Latitude is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'destinationLong',
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
                                'isEmpty' => 'Destination Latitude is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'quantity',
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
                                'isEmpty' => 'Quantity is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'iten_name',
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
                                'isEmpty' => 'Item Name is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'service_type',
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
                                'isEmpty' => 'Service Type is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'delivery_type',
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
                                'isEmpty' => 'Delivery Type is required'
                            )
                        )
                    )
                )
            ));
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();
                $dm = $this->distanceMatrix($data["pickUpPlaceId"], $data["destinationPlaceId"]);
                
                $distanceValue = $dm->rows[0]->elements[0]->distance->value;
                // var_dump($distanceValue);
                $distanceText = $dm->rows[0]->elements[0]->distance->text;
                $dmDistance = $distanceValue / 1000;
                $price = $this->calculatePricing($dmDistance, $data["service_type"], $data["delivery_type"]);
                $data["price"] = $price;
                $data['distanceText'] = $distanceText;
                $data["distanceValue"] = $distanceValue;
                if ($data["status"] == FlutterwaveService::PAYMENT_SUCCESS) {
                    if ($data["payment_mode"] == self::LOGISTICS_PAYMENT_MODE_CARD) {
                        $res = $this->flutterwaveService->verifyPaymentApi($data);
                        if($res instanceof  \Exception){
                            throw new \Exception("We cound not charge your card");
                        }
                    }
                    $this->hydrateLogisticRequest($data);
                    $transactionData = []; //TODO creates transaction data
                    $this->flutterwaveService->hydrateTransactionApi($transactionData);
                    // send email
                    
                }
                
                $data = [];
            } else {}
        } else {
            // payment was not successfull
            throw new \Exception(Json::encode("We could not process you payment"));
        }
    }

    private function hydrateLogisticRequest($data)
    {
        $logistics = new LogisticsRequest();
        $em = $this->entityManager;
        $logistics->setCalculatedDistanceText($data["distance"])
            ->setCalculatedDistanceValue($data["distanceValue"])
            ->
        // ->setCalculatedTimeText($data[""])
        setCreatedOn(new \Datetime())
            ->setDeliveryNote($data["note"])
            ->setDestination($data["destinationAddress"])
            ->setDestinationLatitude($data["destinationLat"])
            ->setDestinationLongitude($data["destinationLong"])
            ->setDestinationPlaceId($data["destinationPlaceId"])
            ->setIsActive(TRUE)
            ->setItemName($data["iten_name"])
            ->setLogisticsUid(uniqid("lr"))
            ->setPaymentmode($em->find(LogisticsPaymentMode::class, $data["payment_mode"]))
            ->setPickupAddress($data["pickAddress"])
            ->setPickupLatitude($data["pickupLat"])
            ->setPickupLongitude($data["pickupLong"])
            ->setPickupPlaceId($data["pickUpPlaceId"])
            ->setServiceType($em->find(LogisticsServiceType::class, $data["service_type"]))
            ->setUpdatedOn(new \Datetime())
            ->setQuantity($data["quantity"])
            ->setUser($em->find(User::class, $this->apiAuthService->getIdentity()));
        $em->persist($logistics);
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
     * @param field_type $generalService            
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
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
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
     * @param \JWT\Service\ApiAuthenticationService $apiAuthService            
     */
    public function setApiAuthService($apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
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
     * @return the $flutterwaveService
     */
    public function getFlutterwaveService()
    {
        return $this->flutterwaveService;
    }

    /**
     * @param \General\Service\FlutterwaveService $flutterwaveService
     */
    public function setFlutterwaveService($flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
        return $this;
    }

}

