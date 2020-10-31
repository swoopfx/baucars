<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Customer\Service\CustomerService;

/**
 *
 * @author otaba
 *        
 */
class CustomerController extends AbstractActionController
{
    
    private $entityManager;
    
    /**
     * 
     * @var CustomerService
     */
    private $customerService;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function indexAction(){
        return  new ViewModel();
    }
    
    public function allcustomercountAction(){
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel->setVariable("count", $this->customerService->getAllCustomerCount());
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
     * @return the $customerService
     */
    public function getCustomerService()
    {
        return $this->customerService;
    }

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param \Customer\Service\CustomerService $customerService
     */
    public function setCustomerService($customerService)
    {
        $this->customerService = $customerService;
        return $this;
    }

}

