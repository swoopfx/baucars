<?php

namespace Admin\Controller;

use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class RidersController extends \Laminas\Mvc\Controller\AbstractActionController
{



    public function riderAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }



}