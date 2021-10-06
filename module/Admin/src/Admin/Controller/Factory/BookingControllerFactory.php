<?php
namespace Admin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
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
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new BookingController();
        $bookingPaginator = $serviceLocator->getServiceLocator()->get("allBookingPaginator");
        $initiatedBooking = $serviceLocator->getServiceLocator()->get("adminInitiatedBokkingPaginator");
        $activeTrip = $serviceLocator->getServiceLocator()->get("adminActiveTripPaginator");
        $cancelBooking = $serviceLocator->getServiceLocator()->get("adminCanceledBookingPaginator");
        $upcomingBooking = $serviceLocator->getServiceLocator()->get("adminUpcomingBookingPaginator");
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
            ->setGeneralService($generalService)
            ->setUpcomgBooking($upcomingBooking)
            ->setAllBookingPaginator($bookingPaginator);
        return $ctr;
    }
}

