<?php
namespace Logistics\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Carnage\JwtZendAuth\Authentication\Storage\Jwt;
use General\Service\JwtService;
use General\ApiAuth\JWTStorage;
use JWT\Service\JWTIssuer;

/**
 *
 * @author mac
 *        
 */
class UserController extends AbstractActionController
{
    
    /**
     * 
     * @var JWTIssuer
     */
    private  $jwtStorage;
  

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function loginAction(){
        
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        
        if($request->isPost()){
            $post = $request->getPost();
           try {
              
               
           } catch (\Exception $e) {
           }
          
        }else{
            $response->setStatusCode(401);
            $jsonModel->setVariables([
                "message"=>"Not Authorized",
            ]);
        }
        return $jsonModel;
        
    }
    
    
    public function registerAction(){
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if($request->isPost()){
            
        }
        return $jsonModel;
    }
    /**
     * @return the $jwtStorage
     */
    public function getJwtStorage()
    {
        return $this->jwtStorage;
    }

    /**
     * @param field_type $jwtStorage
     */
    public function setJwtStorage($jwtStorage)
    {
        $this->jwtStorage = $jwtStorage;
        return $this;
    }

   
    
    
    

   


}

