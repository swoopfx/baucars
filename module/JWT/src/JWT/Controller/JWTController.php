<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/JWT for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace JWT\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

class JWTController extends AbstractActionController
{
    private $googleClient;
    
//     private 
    public function indexAction()
    {
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /jWT/j-w-t/foo
        return array();
        
    }
    
    
    public  function loginAction(){
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
        return $jsonModel;
    }
    
    
    public function forgotpasswordAction(){
        $jsonModel = new JsonModel();
    }
    
    public function googleloginAction(){
        
    }
    
    
    public function googleregisterAction(){
        
    }
}
