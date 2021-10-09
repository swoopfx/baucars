<?php
namespace Logistics\Service;

use Laminas\Http\Request;
use Laminas\Http\Client;

/**
 *
 * @author mac
 *        
 */
class LogisticsService
{

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
                // print_r($response->getBody());
                return json_decode($response->getBody());
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

