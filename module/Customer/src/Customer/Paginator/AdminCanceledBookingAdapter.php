<?php
namespace Customer\Paginator;

use Zend\Paginator\Adapter\AdapterInterface;
use Customer\Entity\Repostory\CustomerBookingRepository;

/**
 *
 * @author otaba
 *        
 */
class AdminCanceledBookingAdapter implements AdapterInterface
{
    
    /**
     *
     * @var CustomerBookingRepository
     */
    private $bookingRepository;

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
        return $this->bookingRepository->findAdminAllInitiatedBooking($offset, $itemCountPerPage);
        
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

