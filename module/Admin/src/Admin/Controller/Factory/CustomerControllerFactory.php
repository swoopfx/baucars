<?php
namespace Admin\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\CustomerController;
use Customer\Service\CustomerService;

/**
 *
 * @author otaba
 *        
 */
class CustomerControllerFactory implements FactoryInterface
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
        
        $ctr = new CustomerController();
        $customerpaginator = $serviceLocator->getServiceLocator()->get("CustomerPaginator");
        $allBooking = $serviceLocator->getServicelocator()->get("allBookingPaginator");
        /**
         * 
         * @var CustomerService $customerService
         */
        $customerService = $serviceLocator->getServiceLocator()->get("Customer\Service\CustomerService");
        $ctr->setCustomerService($customerService)->setCustomerPaginator($customerpaginator);
        return $ctr;
    }
}

