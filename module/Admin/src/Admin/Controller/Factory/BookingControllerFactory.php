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
        /**
         * 
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $bookingService = $serviceLocator->getServiceLocator()->get("Customer\Service\BookingService");
        $ctr->setBookingService($bookingService)->setEntityManager($generalService->getEntityManager());
        
        return $ctr;
    }
}

