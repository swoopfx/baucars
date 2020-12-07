<?php
namespace Application\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 *
 * @author otaba
 *        
 */
class CarRepository extends EntityRepository
{

    // TODO - Insert your code here
    
    

  public function count($criteria = null){
      
  }
  
  public function findRegisteredCars(){
      $repo = $this->getEntityManager()->createQueryBuilder("c");
      $data = $repo
  }
}

