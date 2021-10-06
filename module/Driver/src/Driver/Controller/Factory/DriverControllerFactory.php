<?php
namespace Driver\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Driver\Controller\DriverController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class DriverControllerFactory implements FactoryInterface
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
        
       $ctr = new DriverController();
       /**
        *
        * @var GeneralService $generalService
        */
       $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
       $driverService = $serviceLocator->getServiceLocator()->get("driverService");
       var_dump($generalService->getEntityManager());
       $ctr->setEntityManager($generalService->getEntityManager())
       ->setGeneralService($generalService)
       ->setDriverService($driverService);
       return $ctr;
    }
}

