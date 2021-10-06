<?php
namespace CsnUser\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use CsnUser\Controller\IndexController;
use CsnUser\Entity\User;
use General\Service\GeneralService;

/**
 *
 * @author swoopfx
 *        
 */
class IndexControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new IndexController();
        $trans = $serviceLocator->getServiceLocator()->get('MvcTranslator');
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        
        $em = $generalService->getEntityManager();
      
        $ctr->setTransLator($trans);
        $form = $serviceLocator->getServiceLocator()->get('csnuser_user_form');

        $at = $serviceLocator->getServiceLocator()->get('Laminas\Authentication\AuthenticationService');

        $op = $serviceLocator->getServiceLocator()->get('csnuser_module_options');
        $errorView = $serviceLocator->getServiceLocator()->get('csnuser_error_view');

        $ctr->setAuth($at);
        
        $ue = new User();
        $userSelectDql = $serviceLocator->getServiceLocator()->get('CsnUser\Service\NewUserService');
        $ctr->selectUserService($userSelectDql);
        $ctr->setErrorView($errorView)
            ->setLoginForm($form)
            ->setAuth($at)
            ->setEntityManager($em)
            ->setUserEntity($ue)
            ->setOptions($op);

        return $ctr;
    }
}

?>