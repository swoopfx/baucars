<?php
namespace Driver\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Driver\Paginator\DriverAdapter;
use Doctrine\ORM\EntityManager;
use Driver\Entity\DriverBio;
use Laminas\Paginator\Paginator;

/**
 *
 * @author otaba
 *        
 */
class DriverAdapterInterface implements FactoryInterface
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
        $adapter = new DriverAdapter();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        /**
         *
         * @var EntityManager $entityManager
         */
        $entityManager = $generalService->getEntityManager();
        $driverRepository = $entityManager->getRepository(DriverBio::class);
        $adapter->setDriverRepository($driverRepository);
        
        $page = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("page");
        $paginator = new Paginator($adapter);
        
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(50);
        return $paginator;
    }
}

