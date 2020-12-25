<?php
namespace Customer\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Customer\Entity\Bookings;

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
        $ctr = new Bookings();
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $customerService = $serviceLocator->getServiceLocator()->get("Customer\Service\CustomerService");
        $flutterwaveService = $serviceLocator->getServiceLocator()->get("General\Service\FlutterwaveService");
        $ctr->setGeneralService($generalService)
        ->setCustomerService($customerService)
        ->setEntityManager($generalService->getEntityManager())
        ->setFlutterwaveService($flutterwaveService);
        return $ctr;
    }
}

