<?php
namespace Logistics;


use Logistics\Controller\UserController;
use Logistics\Controller\Factory\UserControllerFactory;
use Logistics\Controller\Factory\LogisticsControllerFactory;
use Logistics\Service\LogisticsService;
use Logistics\Service\Factory\LogisticsServiceFactory;

return array(
    'controllers' => array(
        'invokables' => array(
//              => 'Logistics\Controller\LogisticsController'
        
        ),
        'factories' => array(
            "Logistics\Controller\User" => UserControllerFactory::class,
            'Logistics\Controller\Logistics'=>LogisticsControllerFactory::class
        )
    ),
    'router' => array(
        'routes' => array(
            'logistics' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/logistics',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Logistics\Controller',
                        'controller' => 'Logistics',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "uid"=>"[a-zA-Z0-9_-]*"
                            ),
                            'defaults' => array()
                        )
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Logistics' => __DIR__ . '/../view'
        )
    ),
    
    'service_manager' => array(
        'factories' => array(
            LogisticsService::class=>LogisticsServiceFactory::class
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
    )
);
