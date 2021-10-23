<?php
namespace Logistics\Service\Factory;

use General\Service\GeneralService;
use Laminas\ServiceManager\FactoryInterface;
use Logistics\Service\LogisticsService;
use JWT\Service\ApiAuthenticationService;
use Wallet\Service\WalletService;
use General\Service\FlutterwaveService;

/**
 *
 * @author mac
 *        
 */
class LogisticsServiceFactory implements FactoryInterface
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $xserv = new LogisticsService();
        $generalService = $serviceLocator->get(GeneralService::class);
        var_dump("OLLL");
        $apiAuthService = $serviceLocator->set(ApiAuthenticationService::class);
        var_dump("SER");
        $walletService = $serviceLocator->get(WalletService::class);
        var_dump("WAller");
        var_dump("JUUUS");
        $flutterwaveService = $serviceLocator->get(FlutterwaveService::class);
        $xserv->setGeneralService($generalService)
            ->setEntityManager($generalService->getEntityManager())
            ->setWalletService($walletService)
            ->setFlutterwaveService($flutterwaveService)
            ->setApiAuthService($apiAuthService);

        return $xserv;
    }
}

