<?php
namespace JWT\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use JWT\Controller\ApiController;
use JWT\Service\ApiAuthenticationService;
use General\Service\GeneralService;

/**
 *
 * @author mac
 *        
 */
class ApiControllerFactory implements FactoryInterface
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
        $ctr = new ApiController();
        $googleClient = new \Google_Client();
        $apiAuthService = $serviceLocator->getServiceLocator()->get(ApiAuthenticationService::class);
        $generalService = $serviceLocator->getServiceLocator()->get(GeneralService::class);
        $ctr->setApiAuthService($apiAuthService)
            ->setGoogleClient($googleClient)
            ->setGeneralService($generalService);
        
        return $ctr;
    }
}

