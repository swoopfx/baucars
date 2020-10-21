<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Customer for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use Customer\Service\CustomerService;

class CustomerController extends AbstractActionController
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
     * @var CustomerService
     */
    private $customerService;

    public function indexAction()
    {
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /customer/customer/foo
        return array();
    }

    public function boardAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function bookingHistoryAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        try {
            $response->setStatusCode(200);
            $jsonModel->setVariables([
                "data" => $this->customerService->getBookingHistory()
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::STATUS_CODE_400);
            $jsonModel->setVariables([
                "messages" => $e->getMessage()
            ]);
        }
        return $jsonModel;
    }
    
    
    public function profileAction(){
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        try {
            $response->setStatusCode(200);
            $jsonModel->setVariables([
                "datas"=>$this->customerService->getProfile()
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::STATUS_CODE_400);
            $jsonModel->setVariables([
                "messages" => $e->getMessage()
            ]);
        }
        return $jsonModel;
    }

    public function getSubscribtionAction()
    {
        $jsonModel = new JsonModel();
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
     * @return the $customerService
     */
    public function getCustomerService()
    {
        return $this->customerService;
    }

    /**
     *
     * @param \Customer\Service\CustomerService $customerService            
     */
    public function setCustomerService($customerService)
    {
        $this->customerService = $customerService;
        return $this;
    }
}
