<?php
namespace Customer\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Customer\Paginator\CustomerAdapter;
use Doctrine\ORM\EntityManager;
use CsnUser\Entity\User;
use Laminas\Paginator\Paginator;

/**
 *
 * @author otaba
 *        
 */
class CustomerAdapterInterface implements FactoryInterface
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
        $adapter = new CustomerAdapter();
        
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        /**
         *
         * @var EntityManager $entityManager
         */
        $entityManager = $generalService->getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $adapter->setCustomerRepository($userRepository);
        
        $page = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("page");
        $paginator = new Paginator($adapter);
        
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(50);
        return $paginator;
    }
}

