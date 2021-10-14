<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Logistics for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Logistics;

use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use JWT\Service\ApiAuthenticationService;
use Laminas\Json\Json;
use Laminas\View\Model\JsonModel;

class Module implements AutoloaderProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Laminas\Loader\StandardAutoloader' => array(
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

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $app = $e->getApplication();
        $sm = $app->getServiceManager();
        $sharedEvent = $eventManager->getSharedManager();
        $sharedEvent->attach(__NAMESPACE__, "dispatch", function ($e) use ($sm) {
            /**
             *
             * @var ApiAuthenticationService $apiAuthService
             */
            $apiAuthService = $sm->get(ApiAuthenticationService::class);
            // var_dump($apiAuthService->hasIdentity());
            
            if (! $apiAuthService->hasIdentity()) {
                
                $controller = $e->getTarget();
                
                
                $response = $e->getResponse();
                $response->getHeaders()
                    ->addHeaders(array(
                    'Content-Type' => 'application/json'
                    //
                ));
                // set status 403 (forbidden)
                $response->setStatusCode(403);
                $response->setContent(Json::encode([
                    "message" => "NOt Authorizes"
                ]));
                
                return $response;
            }
        });
    }
}
