<?php
namespace Admin\Controller\Factory;

use Admin\Controller\RidersController;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Service\GeneralService;
use Logistics\Service\LogisticsService;

class RidersControllerFactory implements \Laminas\ServiceManager\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new RidersController();
        $generalService = $serviceLocator->getServiceLocator()->get(GeneralService::class);
        
        $logisticsService = $serviceLocator->getServiceLocator()->get(LogisticsService::class);
        $em = $generalService->getEntityManager();
        $ctr->setEntityManager($em)
            ->setGeneralService($generalService)
            ->setLogisticsService($logisticsService);
        return $ctr;
    }
}