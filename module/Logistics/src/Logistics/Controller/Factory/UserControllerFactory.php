<?php
namespace Logistics\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Logistics\Controller\UserController;
use General\Service\GeneralService;
use General\Service\JwtService;
use General\ApiAuth\JWTStorage;
use JWT\Service\JWTIssuer;

/**
 *
 * @author mac
 *        
 */
class UserControllerFactory implements FactoryInterface
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
        $ctr = new UserController();
        $generalService = $serviceLocator->getServiceLocator()->get(GeneralService::class);
       
        $jwtStorage = $serviceLocator->getServiceLocator()->get(JWTIssuer::class);
//         $ctr->setJwtService($jwtService);
       
        $ctr->setJwtStorage($jwtStorage);
        return $ctr;
    }
}

