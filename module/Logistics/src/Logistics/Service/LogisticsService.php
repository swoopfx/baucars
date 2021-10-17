<?php
namespace Logistics\Service;

use Laminas\Http\Request;
use Laminas\Http\Client;
use Laminas\Json\Json;
use Laminas\InputFilter\InputFilter;
use Laminas\View\Model\JsonModel;

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
 // In Naira
    const LOGISTICS_MINIMUM_DISTANCE = 5;
 // kilometers
    private $generalService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
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

    private function pricing($distanceValue, $serviceType = null)
    {
        if ($dmDistance < self::LOGISTICS_MINIMUM_DISTANCE) {
            return self::LOGISTICS_MINIMUM_PRICE;
        } else {}
    }
    
    private function filter($post){
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
        $inputFilter->setData($post);
        return $inputFilter;
    }

    /**
     * This fun
     * 
     * @param array $post            
     * @return array
     */
    public function priceandDistanceCalculator($post)
    {
        
        $inputFilter = $this->filter($post);
       
       
        if ($inputFilter->isValid()) {
            $data = [];
            $dm = $this->distanceMatrix($post["pickup"], $post["destination"]);
            $distanceValue = $dm->rows[0]->elements[0]->distance->value;
            $distanceText = $dm->rows[0]->elements[0]->distance->text;
            $dmDistance = $distanceValue / 1000;
            $price = $this->pricing($dmDistance);
            $data["price"] = $price;
            $data['distance'] = $distanceText;
            return $data;
        } else {
           
            throw new \Exception(Json::encode($inputFilter->getMessages()));
        }
    }

    public function createRequest($post){
       $inputFilter = $this->filter($post);
       if($inputFilter->isValid()){
           $data = [];
           
       }else{
           
       }
       
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
}

