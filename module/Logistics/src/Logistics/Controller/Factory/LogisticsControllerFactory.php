<?php
namespace Logistics\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Logistics\Controller\LogisticsController;
use General\Service\GeneralService;

/**
 *
 * @author mac
 *        
 */
class LogisticsControllerFactory implements FactoryInterface
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
        $ctr = new LogisticsController();
        $generalService = $serviceLocator->getServiceLocator()->get(GeneralService::class);
//         var_dump($generalService->getEntityManager());
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService);
        return $ctr;
    }
}

