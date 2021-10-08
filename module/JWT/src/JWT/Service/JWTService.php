<?php
namespace JWT\Service;

/**
 *
 * @author mac
 *        
 */
class JWTService
{
    
    private $jwtIssuer;
    
    private $claim;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    
    public function generate(){
        $jwtIssuer = $this->jwtIssuer;
        if($jwtIssuer instanceof  JWTIssuer){
            return $jwtIssuer->issueToken($this->claim);
        }
    }
    
    
    public function validate(){
        
    }
}

