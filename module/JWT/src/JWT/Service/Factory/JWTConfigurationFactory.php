<?php
namespace JWT\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use JWT\Service\JWTConfiguration;

/**
 *
 * @author mac
 *        
 */
class JWTConfigurationFactory implements  FactoryInterface
{

    
    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $key = InMemory::base64Encoded("T2x1d2FzZXVuMUA=");
        $configuration = Configuration::forSymmetricSigner(new Sha256(), $key);
        $xserv = new JWTConfiguration();
        $xserv->setConfiguration($configuration);
        return $xserv;
    }

}

