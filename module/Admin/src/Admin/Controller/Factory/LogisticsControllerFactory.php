<?php

namespace Admin\Controller\Factory;

use Admin\Controller\LogisticsConroller;
use Laminas\ServiceManager\ServiceLocatorInterface;

class LogisticsControllerFactory implements \Laminas\ServiceManager\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $ctr = new LogisticsConroller();
         return $ctr;
    }
}