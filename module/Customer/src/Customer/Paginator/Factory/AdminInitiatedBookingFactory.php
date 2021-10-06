<?php
namespace Customer\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Customer\Paginator\AllBookingAdapter;
use General\Service\GeneralService;
use Laminas\Paginator\Paginator;
use Customer\Entity\CustomerBooking;
use Customer\Paginator\AdminInitiatedBooking;

/**
 *
 * @author otaba
 *        
 */
class AdminInitiatedBookingFactory implements FactoryInterface
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
        
        $adapter = new AdminInitiatedBooking();
        
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        
        $entityManager = $generalService->getEntityManager();
        
        $bookingRepository = $entityManager->getRepository(CustomerBooking::class);
        $adapter->setBookingRepository($bookingRepository);
        
        $page = $serviceLocator->get("Application")
        ->getMvcEvent()
        ->getRouteMatch()
        ->getParam("page");
        
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(50);
        
        return $paginator;
    }
}

