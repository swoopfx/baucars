<?php
$host = "localhost";
$username = "root";
$password = "";

return array(
    'doctrine' => array(
        'connection' => array(
           
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    
                    'host' => $host,
                    'port' => '3308',
                    'user' => $username,
                    'password' => $password,
                    'dbname' => 'baucars',
                    
                    // 'host' => 'us-cdbr-azure-east-c.cloudapp.net',
                    // 'port' => '3306',
                    // 'user' => 'b7488980d7038c',
                    // 'password' => '45329998',
                    // 'dbname' => 'imapp',
                    
//                     'host' => 'localhost',
//                     'port' => '3306',
//                     'user' => 'divancre_crest',
//                     'password' => 'Simple123!@#',
//                     'dbname' => 'divancre_divan',
                    
                    'charset' => 'utf8', // extra
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    )
                )
            ),
            
            
        
        ),
        
        'doctrine' => array(
            'driver' => array(
                __NAMESPACE__ . '_driver' => array(
                    'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                    'cache' => 'array',
                    'paths' => array(
                        __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                    )
                ),
                'orm_default' => array(
                    'drivers' => array(
                        __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                    )
                )
            )
        ),
        
//         'entitymanager' => array(
//             'orm_default' => array(
//                 'connection' => 'orm_default',
//                 'configuration' => 'orm_default'
//             ),
//             // This is the alternative config
//             'orm_imapp_direct' => array(
//                 'connection' => 'orm_imapp_direct',
//                 'configuration' => 'orm_imapp_direct'
//             ),
//             'orm_imapp_cm' => array(
//                 'connection' => 'orm_imapp_cm',
//                 'configuration' => 'orm_imapp_cm'
//             )
//         ),
        // We need to define now the 'orm_alternative' config,
        // the default one is already defined at the level of
        // doctrine module code
        'configuration' => array(
            'orm_imapp_cm' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'driver' => 'orm_imapp_cm', // This driver will be defined later
                'generate_proxies' => true,
//                 'proxy_dir' => 'data/DoctrineORMModule/Proxy/Cm',
//                 'proxy_namespace' => 'DoctrineORMModule\Proxy\Cm',
                'filters' => array()
            ),
            'orm_imapp_direct' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'driver' => 'orm_imapp_direct', // This driver will be defined later
                'generate_proxies' => true,
                'proxy_dir' => 'data/DoctrineORMModule/Proxy/Direct',
                'proxy_namespace' => 'DoctrineORMModule\Proxy\Direct',
                'filters' => array()
            ),
        )
        
        
        
    ),
    

);

