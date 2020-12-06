<?php
namespace Admin\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\BookingController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class BookingControllerFactory implements FactoryInterface
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
        $ctr = new BookingController();
        // var_dump("HHHHH");
        $bookingPaginator = $serviceLocator->getServiceLocator()->get("allBookingPaginator");
        $initiatedBooking = $serviceLocator->getServiceLocator()->get("adminInitiatedBokkingPaginator");
        $activeTrip = $serviceLocator->getServiceLocator()->get("allBookingPaginator");
        $cancelBooking = $serviceLocator->getServiceLocator()->get("allBookingPaginator");
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $bookingService = $serviceLocator->getServiceLocator()->get("Customer\Service\BookingService");
        $ctr->setBookingService($bookingService)
            ->setEntityManager($generalService->getEntityManager())
            ->setCancelBooking($cancelBooking)
            ->setActiveBooking($activeTrip)
            ->setInitiTitedBooking($initiatedBooking)
            ->setAllBookingPaginator($bookingPaginator);
        return $ctr;
    }
}

