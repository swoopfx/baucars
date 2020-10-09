<?php
namespace CsnUser\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use CsnUser\Controller\RegistrationController;
use General\Service\GeneralService;

/**
 *
 * @author swoopfx
 *        
 */
class RegisterControllerFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new RegistrationController();
        $trans = $serviceLocator->getServiceLocator()->get('MvcTranslator');
        
        /**
         * 
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");

        $em = $generalService->getEntityManager();
        $et = $generalService->getAuth();

        $er = $serviceLocator->getServiceLocator()->get('csnuser_error_view');
       
//         $mailService = $generalService->getMailService();
        $registerForm = $serviceLocator->getServiceLocator()->get('csnuser_user_form');
        $op = $serviceLocator->getServiceLocator()->get('csnuser_module_options');
//         $chatkitService = $serviceLocator->getServiceLocator()->get('GeneralServicer\Service\PusherChatkitService');
        
        $ctr->setTranslator($trans)
            ->setErroView($er)
            ->setEntityManager($em)
            ->setAuthService($et)
            ->setRegisterForm($registerForm)
            ->setOptions($op)
            ->setGeneralService($generalService);
        
        return $ctr;
    }
}

?>