<?php
namespace Customer\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Customer\Paginator\AdminUpcomingBookingAdapter;
use General\Service\GeneralService;
use Customer\Entity\CustomerBooking;
use Laminas\Paginator\Paginator;

/**
 *
 * @author otaba
 *        
 */
class AdminUpcomingBookingAdapterInterface implements FactoryInterface
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
        
       $adapter = new AdminUpcomingBookingAdapter();
       
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

