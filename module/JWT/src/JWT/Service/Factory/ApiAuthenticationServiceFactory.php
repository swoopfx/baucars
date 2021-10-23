<?php
namespace JWT\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use JWT\Service\ApiAuthenticationService;
use General\Service\GeneralService;
use JWT\Service\JWTService;

/**
 *
 * @author mac
 *        
 */
class ApiAuthenticationServiceFactory implements FactoryInterface
{



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
        $generalService = $serviceLocator->get(GeneralService::class);
        $urlPlugin = $serviceLocator->get("ControllerPluginManager")->get("Url");
        $requestObject = $serviceLocator->get("Request");
        $jwtService = $serviceLocator->get(JWTService::class);
        // $responseObject = $serviceLocator->get("")
        $xserv->setAuthenticationService($authenticationService)
            ->setRequestObject($requestObject)
            ->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService)
//            ->setUrlPlugin($urlPlugin)
            ->setJwtService($jwtService);
        return $xserv;
    }
}

