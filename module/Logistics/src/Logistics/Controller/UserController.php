<?php
namespace Logistics\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Carnage\JwtZendAuth\Authentication\Storage\Jwt;
use General\Service\JwtService;

/**
 *
 * @author mac
 *        
 */
class UserController extends AbstractActionController
{
    
    
    /**
     * 
     * @var JwtService
     */
   private $jwtService;

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
//         print_r($this->jwtHeader);

        
        if($request->isPost()){
           $data = [];
           $jsonModel->setVariables([
               "token"=>($this->jwtService->createSignedTokenLoc())
           ]);
        }else{
            
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
     * @return the $jwtService
     */
    public function getJwtService()
    {
        return $this->jwtService;
    }

    /**
     * @param field_type $jwtService
     */
    public function setJwtService($jwtService)
    {
        $this->jwtService = $jwtService;
        return $this;
    }

   


}

