<?php
namespace Wallet\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Controller\ApiController;
use General\Service\GeneralService;
use JWT\Service\ApiAuthenticationService;
use General\Service\FlutterwaveService;
use Wallet\Service\WalletService;
use General\Service\MonnifyService;
use General\Service\PaystackService;

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
        $monnifyService = $serviceLocator->getServiceLocator()->get(MonnifyService::class);
        $paystackService= $serviceLocator->getServiceLocator()->get(PaystackService::class);
        $walletService = $serviceLocator->getServiceLocator()->get(WalletService::class);
        // var_dump($walletService);
        $ctr->setApiAuthService($apiAuthService)
            ->setMonnifyService($monnifyService)
            ->setGeneralService($generalService)
            ->setWalletService($walletService)
            ->setPaystackService($paystackService)
            ->setFlutterwaveService($flutterwaveService);
        return $ctr;
    }
}

