<?php
namespace Driver\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Driver\Service\DriverService;
use Laminas\Session\Container;

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
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
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

