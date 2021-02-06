<?php
namespace Customer\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Customer\Entity\Bookings;
use Customer\Controller\BookingsController;

/**
 *
 * @author otaba
 *        
 */
class BookinsControllerFactory implements FactoryInterface
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
        $ctr = new BookingsController();
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $bookingService = $serviceLocator->getServiceLocator()->get("Customer\Service\BookingService");
        // $customerService = $serviceLocator->getServiceLocator()->get("Customer\Service\CustomerService");
        $flutterwaveService = $serviceLocator->getServiceLocator()->get("General\Service\FlutterwaveService");
        $ctr->setGeneralService($generalService)
            ->setFlutterwaveService($flutterwaveService)
            ->setBookingService($bookingService)
            ->setEntityManager($generalService->getEntityManager());
        
        return $ctr;
    }
}

