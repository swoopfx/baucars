<?php

namespace Admin\Controller\Factory;

use Admin\Controller\RidersController;
use Laminas\ServiceManager\ServiceLocatorInterface;

class RidersControllerFactory implements \Laminas\ServiceManager\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new RidersController();
        return $ctr;
    }
}