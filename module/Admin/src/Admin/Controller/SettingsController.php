<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 *
 * @author otaba
 *        
 */
class SettingsController extends AbstractActionController
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function configAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
}

