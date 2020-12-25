<?php
namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use Customer\Service\BookingService;
use Zend\View\Model\ViewModel;

/**
 *
 * @author otaba
 *        
 */
class BookingsController extends AbstractActionController
{

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var BookingService
     */
    private $bookingService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function boardAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }
    /**
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return the $bookingService
     */
    public function getBookingService()
    {
        return $this->bookingService;
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
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param \Customer\Service\BookingService $bookingService
     */
    public function setBookingService($bookingService)
    {
        $this->bookingService = $bookingService;
        return $this;
    }

}

