<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 *
 * @author otaba
 *        
 */
class DriverController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    // private
    
    
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function driversAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    
    public  function createdriverAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

