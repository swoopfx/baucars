<?php
namespace Driver\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Driver\Service\DriverService;

/**
 *
 * @author otaba
 *        
 */
class DriverServiceFactory implements FactoryInterface
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
        
       $xserv = new DriverService();
       $generalService = $serviceLocator->get("General\Service\GeneralService");
       $xserv->setEntityManager($generalService->getEntityManager());
       return $xserv;
    }
}

