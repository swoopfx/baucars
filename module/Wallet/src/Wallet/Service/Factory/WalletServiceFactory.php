<?php
namespace Wallet\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Service\WalletService;
use General\Service\GeneralService;
use General\Service\FlutterwaveService;
use JWT\Service\ApiAuthenticationService;

/**
 *
 * @author mac
 *        
 */
class WalletServiceFactory implements FactoryInterface
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
        $xserv = new WalletService();
        $generalService = $serviceLocator->get(GeneralService::class);
        $flutterwaveService = $serviceLocator->get(FlutterwaveService::class);
        $apiAuthService = $serviceLocator->get(ApiAuthenticationService::class);
        $entityManager = $generalService->getEntityManager();
        $xserv->setFlutterwaveService($flutterwaveService)
            ->setGeneralService($generalService)
            ->setApiAuthService($apiAuthService)
            ->setEntityManager($entityManager);
        return $xserv;
    }
}

