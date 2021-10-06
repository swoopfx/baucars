<?php
namespace Customer\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Customer\Controller\CustomerController;
use General\Service\GeneralService;

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
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new CustomerController();
        /**
         *
         * @var GeneralService $generalService
         */
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

