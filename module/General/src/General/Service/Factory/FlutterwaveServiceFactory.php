<?php
namespace General\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use General\Service\FlutterwaveService;
use Zend\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class FlutterwaveServiceFactory implements FactoryInterface
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
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $flutterSession = new Container("flutter_session");
        $config = $serviceLocator->get('config');
        $flutterwaveConfig = (getenv('APPLICATION_ENV') == "development" ? $config["flutterwave"]["dev"] : $config['flutterwave']['live']);
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        
        $xserv = new FlutterwaveService();
        $xserv->setGeneralService($generalService)
            ->setEntityManager($generalService->getEntityManager())
            ->setAuth($generalService->getAuth())
            ->setFlutterSession($flutterSession)
            ->setFlutterwavePublicKey($flutterwaveConfig["public_key"])
            ->setFlutterwaveEncrypKey($flutterwaveConfig["encryption_key"])
            ->setFlutterwaveSecretKey($flutterwaveConfig["secret_key"]);
        return $xserv;
    }
}

