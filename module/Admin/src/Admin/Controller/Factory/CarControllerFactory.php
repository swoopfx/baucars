<?php
namespace Admin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
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
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
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

