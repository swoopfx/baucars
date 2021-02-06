<?php
namespace Driver\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Driver\Service\DriverService;
use Zend\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class DriverServiceFactory implements FactoryInterface
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
        $xserv = new DriverService();
        $amotixedSession = new Container("amotized_session");
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $bookingService = $serviceLocator->get("Customer\Service\BookingService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService)
            ->setBookingService($bookingService)
            ->setAmotizedSession($amotixedSession);
        return $xserv;
    }
}

