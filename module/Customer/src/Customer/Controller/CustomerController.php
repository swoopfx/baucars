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
use General\Entity\BookingType;
use Customer\Entity\CustomerBooking;
use General\Entity\BookingStatus;

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

    public function profileAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        try {
            $response->setStatusCode(200);
            $jsonModel->setVariables([
                "datas" => $this->customerService->getProfile()
            ]);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::STATUS_CODE_400);
            $jsonModel->setVariables([
                "messages" => $e->getMessage()
            ]);
        }
        return $jsonModel;
    }

    /**
     * Gets all booking Service Type
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function bookingServiceTypeAction()
    {
        $em = $this->entityManager;
        
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $response->setStatusCode(200);
        
        $jsonModel->setVariable("data", $this->customerService->getAllBookingServiceType());
        return $jsonModel;
    }

    public function initiatedBookingAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $response->setStatusCode(200);
        $jsonModel->setVariables([
            "data" => $this->customerService->getAllInitiatedBooking()
        ]);
        return $jsonModel;
    }

    /**
     * Creates a booking
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function createBookingAction()
    {
        $em = $this->entityManager;
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $dump = explode("-", $post["bookingDate"]);
            // var_dump(strip_tags($dump[0]));
            // var_dump(strip_tags($dump[1]));
            $startDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[0]));
            $endDate = \DateTime::createFromFormat("m/d/Y h:i A", trim($dump[1]));
            $bookingTypeId = $post["selectedService"];
            try {
                $booking = new CustomerBooking();
                
                $booking->setBookingUid(CustomerService::bookingUid())
                    ->setCreatedOn(new \DateTime())
                    ->setEndTime($endDate)
                    ->setStartTime($startDate)
                    ->setUser($this->identity())
                    ->setStatus($em->find(BookingStatus::class, CustomerService::BOOKING_STATUS_INITIATED))
                    ->setBookingType($em->find(BookingType::class, $bookingTypeId));
                
                $em->persist($booking);
                $em->flush();
                
                $response->setStatusCode(201);
                $jsonModel->setVariables([
                    "messages" => "Successfully initated Your  Booking"
                ]);
            } catch (\Exception $e) {
                $response->setStatusCode(400);
                $jsonModel->setVariables([
                    "messages" => $e->getMessage()
                ]);
            }
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
