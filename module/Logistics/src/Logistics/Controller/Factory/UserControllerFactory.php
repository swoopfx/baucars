<?php
namespace Logistics\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Logistics\Controller\UserController;
use General\Service\GeneralService;
use General\Service\JwtService;

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
        
        $jwtService = $serviceLocator->getServiceLocator()->get("General\Service\JwtService");
        
        $ctr->setJwtService($jwtService);
        return $ctr;
    }
}

