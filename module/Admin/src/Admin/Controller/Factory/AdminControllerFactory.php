<?php
namespace Admin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\AdminController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class AdminControllerFactory implements FactoryInterface
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
        
        $ctr = new AdminController();
        /**
         * 
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $customerService = $serviceLocator->getServiceLocator()->get("Customer\Service\CustomerService");
        $ctr->setEntityManager($generalService->getEntityManager())->setGeneralService($generalService)->setCustomerService($customerService);
        return $ctr;
    }
}

