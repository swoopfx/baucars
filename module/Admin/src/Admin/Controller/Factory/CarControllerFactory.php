<?php
namespace Admin\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\CarController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class CarControllerFactory implements FactoryInterface
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
        $ctr = new CarController();
        $allCArPaginator = $serviceLocator->getServiceLocator()->get("allcarsRegisteredPaginator");
        
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        
        $ctr->setGeneralService($generalService)
            ->setAllCarsPaginator($allCArPaginator)
            ->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}

