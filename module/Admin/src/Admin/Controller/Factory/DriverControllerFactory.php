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
        
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        // $generalService = $serviceLocator->getServiceLocator()->get("");
        
        $ctr->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}

