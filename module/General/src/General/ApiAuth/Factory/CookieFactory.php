<?php
namespace General\ApiAuth\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\ApiAuth\Cookie;
use Laminas\Mvc\MvcEvent;
use Laminas\Http\Response;
use Laminas\EventManager\EventManager;

/**
 *
 * @author mac
 *        
 */
class CookieFactory implements FactoryInterface
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $container)
    {
        
        $config = $container->get('Config')['jwt_auth'];
        
        $config['cookieOptions']['expiry'] = $config['expiry'];
        
        $cookieStorage = new Cookie(
            $container->get('Request'),
            $config['cookieOptions']
            );
        
        /** @var EventManager $eventManager This fetches the main mvc event manager. */
        $eventManager = $container->get('Application')->getEventManager();
        $eventManager->attach(
            MvcEvent::EVENT_FINISH,
            function (MvcEvent $e) use ($cookieStorage) {
                $response = $e->getResponse();
                if ($response instanceof Response) {
                    $cookieStorage->close($response);
                }
            }
            );
        
        return $cookieStorage;
    }
}

