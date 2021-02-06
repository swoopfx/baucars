<?php
namespace Customer\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Customer\Service\BookingService;
use General\Service\GeneralService;
use Zend\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class BookingServiceFactory implements FactoryInterface
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
        $xserv = new BookingService();
        
        $bookingSession = new Container("new_booking_session");
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setAppSettings($generalService->getAppSeettings())
            ->setPricaRangeSettings($generalService->getPriceRange())
            ->setBookingSession($bookingSession)
            ->setAuth($generalService->getAuth());
        
        return $xserv;
    }
}

