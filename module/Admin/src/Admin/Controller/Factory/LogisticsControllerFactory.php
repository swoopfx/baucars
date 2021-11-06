<?php

namespace Admin\Controller\Factory;

// use Admin\Controller\LogisticsConroller;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Service\GeneralService;
use Admin\Controller\LogisticsController;

class LogisticsControllerFactory implements \Laminas\ServiceManager\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $ctr = new LogisticsController();
         $generalService = $serviceLocator->getServiceLocator()->get(GeneralService::class);
         $em = $generalService->getEntityManager();
         $ctr->setEntityManager($em)->setGeneralService($generalService);
         return $ctr;
    }
}