<?php
namespace Customer\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Customer\Service\BookingService;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class BookingServiceFactory implements FactoryInterface
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
        $xserv = new BookingService();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setAuth($generalService->getAuth());
        
        return $xserv;
    }
}

