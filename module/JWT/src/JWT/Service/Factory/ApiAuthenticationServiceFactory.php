<?php
namespace JWT\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use JWT\Service\ApiAuthenticationService;

/**
 *
 * @author mac
 *        
 */
class ApiAuthenticationServiceFactory implements FactoryInterface
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $xserv = new ApiAuthenticationService();
        $authenticationService = $serviceLocator->get('Laminas\Authentication\AuthenticationService');
        $requestObject = $serviceLocator->get("Request");
        // $responseObject = $serviceLocator->get("")
        $xserv->setAuthenticationService($authenticationService)->setRequestObject($requestObject);
        return $xserv;
    }
    
    
}

