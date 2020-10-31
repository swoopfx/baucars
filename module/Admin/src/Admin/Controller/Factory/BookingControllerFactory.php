<?php
namespace Admin\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\BookingController;

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
        $bookingService = $serviceLocator->getServiceLocator()->get("Customer\Service\BookingService");
        $ctr->setBookingService($bookingService);
        
        return $ctr;
    }
}

