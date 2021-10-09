<?php
namespace Logistics\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Logistics\Service\LogisticsService;

/**
 *
 * @author mac
 *        
 */
class LogisticsServiceFactory implements FactoryInterface
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $xserv = new LogisticsService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setGeneralService($generalService);
        return $xserv;
        
    }

}

