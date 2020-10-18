<?php
namespace General\Service;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;

/**
 *
 * @author otaba
 *        
 */
class GeneralService
{

    /**
     * 
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * 
     * @var AuthenticationService
     */
    private $auth;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
    /**
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param field_type $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }


}

