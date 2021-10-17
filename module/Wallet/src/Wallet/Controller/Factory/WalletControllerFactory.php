<?php
namespace Wallet\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Controller\WalletController;
use General\Service\GeneralService;
use JWT\Service\ApiAuthenticationService;

/**
 *
 * @author mac
 *        
 */
class WalletControllerFactory implements FactoryInterface
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
        
       $ctr = new WalletController();
       $generalService = $serviceLocator->getServiceLocator()->get(GeneralService::class);
       $apiAuthService = $serviceLocator->getServiceLocatro()->get(ApiAuthenticationService::class);
       $ctr->setGeneralService($generalService)->setApiAuthService($apiAuthService);
       return $ctr;
    }
}

