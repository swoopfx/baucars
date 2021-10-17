<?php
namespace Wallet\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Controller\ApiController;
use General\Service\GeneralService;
use JWT\Service\ApiAuthenticationService;
use General\Service\FlutterwaveService;

/**
 *
 * @author mac
 *        
 */
class ApiControllerFactory implements FactoryInterface
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
        $ctr = new ApiController();
        $generalService = $serviceLocator->getServiceLocator()->get(GeneralService::class);
        $apiAuthService = $serviceLocator->getServiceLocator()->get(ApiAuthenticationService::class);
        $flutterwaveService = $serviceLocator->getServiceLocator()->get(FlutterwaveService::class);
        $ctr->setApiAuthService($apiAuthService)
            ->setGeneralService($generalService)
            ->setFlutterwaveService($flutterwaveService);
        return $ctr;
    }
}

