<?php
namespace Customer\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Customer\Service\CustomerService;
use General\Service\GeneralService;
use Laminas\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class CustomerServiceFactory implements FactoryInterface
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
        $xserv = new CustomerService();
        $bookingSession = new Container("booking_session");
        
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setAuth($generalService->getAuth())
            ->setBookingSession($bookingSession);
        return $xserv;
    }
}

