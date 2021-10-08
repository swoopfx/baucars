<?php
namespace General\ApiAuth\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\EventManager\EventManager;
use General\ApiAuth\Header;
use Laminas\Http\Response;
use Laminas\Mvc\MvcEvent;

/**
 *
 * @author mac
 *        
 */
class HeaderFactory implements FactoryInterface
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
        
        $headerStorage = new Header(
            $container->get('Request')
            );
        
        /** @var EventManager $eventManager This fetches the main mvc event manager. */
        $eventManager = $container->get('Application')->getEventManager();
        $eventManager->attach(
            MvcEvent::EVENT_FINISH,
            function (MvcEvent $e) use ($headerStorage) {
                $response = $e->getResponse();
                if ($response instanceof Response) {
                    $headerStorage->close($response);
                }
            }
            );
        
        return $headerStorage;
    }
}

