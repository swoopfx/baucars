<?php
use Admin\Controller\Factory\AdminControllerFactory;
use Admin\Controller\Factory\CustomerControllerFactory;
use Admin\Controller\Factory\BookingControllerFactory;

return array(
    'controllers' => array(
        'invokables' => array(
            // 'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
        ),
        'factories' => array(
            'Admin\Controller\Admin' => AdminControllerFactory::class,
            "Admin\Controller\Customer" => CustomerControllerFactory::class,
            "Admin\Controller\Booking"=>BookingControllerFactory::class,
        )
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/controller',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Admin',
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
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*'
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
            'Admin' => __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    )
);
