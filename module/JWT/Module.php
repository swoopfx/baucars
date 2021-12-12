<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/JWT for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace JWT;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
                )
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(\Laminas\Mvc\MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new \Laminas\Mvc\ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $app = $e->getApplication();
        $sm = $app->getServiceManager();
        $sharedEvent = $eventManager->getSharedManager();
        $sharedEvent->attach(__NAMESPACE__, "dispatch", function ($e) use ($sm) {
            
//             $response = $e->getResponse();
//             $response->getHeaders()
//                 ->addHeaders(array(
//                 'Content-Type' => 'application/json'
//                 //
//             ));
            
//             $response->getHeaders()
//                 ->addHeaderLine('Access-Control-Allow-Origin', '*');
//             $response->getHeaders()
//                 ->addHeaderLine('Access-Control-Allow-Credentials', 'true');
//             $response->getHeaders()
//                 ->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET');
            
//             return $response;
        });
    }
}
