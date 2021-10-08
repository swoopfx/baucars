<?php
namespace JWT\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use JWT\Service\JWTService;
use JWT\Service\JWTIssuer;

/**
 *
 * @author mac
 *        
 */
class JWTServiceFactory implements  FactoryInterface
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function createService(ServiceLocatorInterface $serviceLocator){
        $xserv = new JWTService();
        $jwtIssuer = $serviceLocator->get(JWTIssuer::class);
        $xserv->setJwtIssuer($jwtIssuer);
        return $xserv;
    }
}

