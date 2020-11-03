<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 *
 * @author otaba
 *        
 */
class CarController extends AbstractActionController
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function indexAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}

