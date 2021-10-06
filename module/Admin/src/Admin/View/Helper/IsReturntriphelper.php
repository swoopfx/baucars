<?php
namespace Admin\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;

class IsReturntriphelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
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

