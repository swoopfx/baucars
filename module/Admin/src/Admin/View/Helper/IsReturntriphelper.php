<?php
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class IsReturntriphelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        
        
    }
    
    
    public function __invoke($data){
        if($data == TRUE){
            return "<span class='label label-success'>RETURN TRIP</label>";
        }else{
            return "<span class='label label-warning'>NORMAL TRIP<label>";
        }
    }

}

