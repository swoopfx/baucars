<?php
namespace Customer\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
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
     * @see \Zend\ServiceManager\FactoryInterface::createService()
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
        $ctr->setGeneralService($generalService)->setCustomerService($customerService)->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}

