<?php
namespace General\ApiAuth\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Authentication\Storage\Chain;
use Laminas\Authentication\Storage\StorageInterface;
use General\Service\JwtService;
use General\ApiAuth\JWTStorage;

/**
 *
 * @author mac
 *        
 */
class JwtStorageFactory implements FactoryInterface
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
       
            
         
        return new JwtStorage(
            $container->get(JwtService::class),
            $this->buildBaseStorage($container),
            $config['expiry']
            );
        
        
    }
    
    private function buildBaseStorage(ServiceLocatorInterface $container): StorageInterface
    {
        $config = $container->get('Config')['jwt_auth']['storage'];
        
        if ($config['useChainAdaptor'] !== true) {
            return $container->get($config['adaptor']);
        }
        
        $chainAdaptor = new Chain();
        foreach ($config['adaptors'] as $adaptor) {
            $chainAdaptor->add($container->get($adaptor));
        }
        
        return $chainAdaptor;
    }
}

