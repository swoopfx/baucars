<?php

namespace Admin\Controller;

use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class RidersController extends \Laminas\Mvc\Controller\AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    private $generalService;



    public function ridersAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function createriderAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }



}