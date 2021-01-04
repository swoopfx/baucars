<?php
namespace Driver\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Driver\Service\DriverService;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Customer\Entity\Bookings;
use Doctrine\ORM\Query;
use Customer\Service\CustomerService;

/**
 *
 * @author otaba
 *        
 */
class BoardController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var DriverService
     */
    private $driverService;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        
        return $response;
    }

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function boardAction()
    {
        $userEntity = $this->identity();
        $viewModel = new ViewModel([
            "user"=>$userEntity
        ]);
        return $viewModel;
    }

    public function previousTripsAction()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
        $data = $repo->createQueryBuilder("p")
            ->where("p.status = :status")
            ->setParameters([
            "status" => CustomerService::BOOKING_STATUS_COMPLETED
        ])
            ->orderBy("desc", "p.id")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    /**
     * This gets the present active trip or in transit
     * As there can only be one active trip at a time
     */
    public function activeTripAction()
    {
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
        $data = $repo->createQueryBuilder("b")
        ->where("b.user = :user")
        ->andWhere("b.status = :status")
        ->setParameters([
            "user" => $this->identity()
            ->getId(),
            "status" => CustomerService::BOOKING_STATUS_ACTIVE
        ])
        ->getQuery()
        ->getResult(Query::HYDRATE_ARRAY);
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel = new JsonModel();
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    public function assignedBookingAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(Bookings::class);
        $data = $repo->createQueryBuilder("b")
            ->where("b.user = :user")
            ->andWhere("b.status = :status")
            ->setParameters([
            "user" => $this->identity()
                ->getId(),
            "status" => CustomerService::BOOKING_STATUS_ASSIGN
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @return the $driverService
     */
    public function getDriverService()
    {
        return $this->driverService;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \Driver\Service\DriverService $driverService            
     */
    public function setDriverService($driverService)
    {
        $this->driverService = $driverService;
        return $this;
    }
}

