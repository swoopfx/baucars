<?php
namespace Application\Paginator;

use Zend\Paginator\Adapter\AdapterInterface;

/**
 *
 * @author otaba
 *        
 */
class CarAdapater implements AdapterInterface
{
    
    private $carRepository;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * {@inheritDoc}
     * @see \Zend\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        
        
    }

    /**
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
        // TODO Auto-generated method stub
        
    }

}

