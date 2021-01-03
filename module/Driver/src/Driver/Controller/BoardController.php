<?php
namespace Driver\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Driver\Service\DriverService;

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
    
    

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    public function boardAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * @return the $driverService
     */
    public function getDriverService()
    {
        return $this->driverService;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param \General\Service\GeneralService $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     * @param \Driver\Service\DriverService $driverService
     */
    public function setDriverService($driverService)
    {
        $this->driverService = $driverService;
        return $this;
    }

}

