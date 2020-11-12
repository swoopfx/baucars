<?php
namespace Customer\Paginator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Customer\Paginator\AllBookingAdapter;
use General\Service\GeneralService;
use Zend\Paginator\Paginator;
use Customer\Entity\CustomerBooking;

/**
 *
 * @author otaba
 *        
 */
class AllBookingAdapterInterface implements FactoryInterface
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
        $adapter = new AllBookingAdapter();
        
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

