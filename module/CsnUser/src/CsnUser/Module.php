<?php
/**
 * CsnUser - Coolcsn Zend Framework 2 User Module
 * 
 * @link https://github.com/coolcsn/CsnUser for the canonical source repository
 * @copyright Copyright (c) 2005-2013 LightSoft 2005 Ltd. Bulgaria
 * @license https://github.com/coolcsn/CsnUser/blob/master/LICENSE BSDLicense
 * @author Stoyan Cheresharov <stoyan@coolcsn.com>
 * @author Svetoslav Chonkov <svetoslav.chonkov@gmail.com>
 * @author Nikola Vasilev <niko7vasilev@gmail.com>
 * @author Stoyan Revov <st.revov@gmail.com>
 * @author Martin Briglia <martin@mgscreativa.com>
 */
namespace CsnUser;

use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;
use General\Service\TriggerService;
use Wallet\Entity\Wallet;
use Wallet\Entity\Credit;
use Wallet\Service\WalletService;
use Wallet\Service\CreditService;

// use Laminas\EventManager\StaticEventManager;
// use Wallet\Entity\Wallet;
// use Wallet\Service\WalletService;
class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__
                )
            )
        );
    }

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvent = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvent->attach(__NAMESPACE__, 'dispatch', function ($e) {
            $controller = $e->getTarget();
            $controller->layout('layout/login');
        });
    }

    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $sm = $app->getServiceManager();
        
        $shareEventManager = $e->getApplication()
            ->getEventManager()
            ->getSharedManager();
//         $shareEventManager->attach("Laminas\Mvc\Controller\AbstractActionController", TriggerService::USER_REGISTER_INITIATED, function ($e) use ($sm) {
//             // Handle all post initiate user register event handler here
           
//         });
    }
}
