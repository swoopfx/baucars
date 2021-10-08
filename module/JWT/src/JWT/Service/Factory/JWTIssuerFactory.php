<?php
namespace JWT\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use JWT\Service\JWTIssuer;
use JWT\Service\JWTConfiguration;

/**
 *
 * @author mac
 *        
 */
class JWTIssuerFactory implements FactoryInterface
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get(JWTConfiguration::class);
        $requestObject = $serviceLocator->get("Request");
        $xserv = new JWTIssuer($config->getConfiguration());
        $xserv->setRequestObject($requestObject);
        return $xserv;
        
    }

}

