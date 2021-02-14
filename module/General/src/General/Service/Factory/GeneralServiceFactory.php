<?php
namespace General\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class GeneralServiceFactory implements FactoryInterface
{

    private $em;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    private $userId;

    private $userEntity;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $xserv = new GeneralService();
        
      $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        //$mailService = $serviceLocator->get("acmailer.mailservice.default");
        $mailService = (getenv('APPLICATION_ENV') == "development" ? $serviceLocator->get("acmailer.mailservice.default") : $serviceLocator->get("acmailer.mailservice.live"));
        $viewRenderer = $serviceLocator->get("ViewRenderer");
       $auth = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        //$viewRenderer = $serviceLocator->get("ViewRenderer");
        $this->em = $em;
        $this->auth = $auth;
        $xserv->setEntityManager($em)
            ->setAuth($auth)
            ->setMailService($mailService)
            ->setRenderer($viewRenderer);
        return $xserv;
    }

    private function getUserRole()
    {
        if ($this->auth->hasIdentity()) {
            $data = $this->auth->getIdentity()
                ->getRole()
                ->getId();
            $this->userRole = $data;
            return $data;
        }
    }

    private function getUserId()
    {
        if ($this->auth->hasIdentity()) {
            $userEntity = $this->auth->getIdentity();
            $this->userId = $userEntity->getId();
            return $this->userId;
        }
    }

    private function getUserEntity()
    {
        if ($this->auth->hasIdentity()) {
            $this->userEntity = $this->auth->getIdentity();
            
            return $this->userEntity;
        }
    }
}

