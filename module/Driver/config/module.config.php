<?php
namespace Driver;
use Driver\Paginator\Factory\DriverAdapterInterface;
use Driver\Service\Factory\DriverServiceFactory;
use Driver\Controller\Factory\BoardControllerFactory;
use Driver\Controller\Factory\DriverControllerFactory;

return array(
    'controllers' => array(
        'invokables' => array(
            'Driver\Controller\Driver' => 'Driver\Controller\DriverController',
            
        ),
        'factories' => array(
            "Driver\Controller\Board"=>BoardControllerFactory::class,
            "Driver\Controller\Driver"=>DriverControllerFactory::class
        ),
    ),
    'router' => array(
        'routes' => array(
            'driver' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/driver',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Driver\Controller',
                        'controller'    => 'Board',
                        'action'        => 'board',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Driver' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            "allDriverPaginator"=>DriverAdapterInterface::class,
            "driverService"=>DriverServiceFactory::class,
            
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
