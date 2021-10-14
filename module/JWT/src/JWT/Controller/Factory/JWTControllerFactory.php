<?php
namespace JWT\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use JWT\Controller\JWTController;
use JWT\Service\ApiAuthenticationService;

/**
 *
 * @author mac
 *        
 */
class JWTControllerFactory implements FactoryInterface
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
        $ctr = new JWTController();
        $googleClient = new \Google_Client();
        $apiAuthService = $serviceLocator->getServiceLocator()->get(ApiAuthenticationService::class);
        $ctr->setApiAuthService($apiAuthService)->setGoogleClient($googleClient);
        return $ctr;
    }
}

