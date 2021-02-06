<?php
namespace Admin\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\DriverController;
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
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new DriverController();
        $allDriverPaginator = $serviceLocator->getServiceLocator()->get("allDriverPaginator");
        
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $driverService = $serviceLocator->getServiceLocator()->get("driverService");
        // $generalService = $serviceLocator->getServiceLocator()->get("");
        
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setDriverPaginator($allDriverPaginator)
            ->setGeneralService($generalService)
            ->setDriverService($driverService);
        return $ctr;
    }
}

