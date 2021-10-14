<?php
namespace Logistics\Service;

use Laminas\Http\Request;
use Laminas\Http\Client;
use Laminas\Json\Json;

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
    private $generalService;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    
    
    
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
    
    
    public function priceCalculator(){
       
    }
    
    
    public function createLogistics(){
        
    }
    /**
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * @param field_type $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

}

