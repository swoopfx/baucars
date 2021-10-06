<?php
use Logistics\Controller\UserController;
use Logistics\Controller\Factory\UserControllerFactory;

return array(
    'controllers' => array(
        'invokables' => array(
            'Logistics\Controller\Logistics' => 'Logistics\Controller\LogisticsController'
        
        ),
        'factories' => array(
            "Logistics\Controller\User" => UserControllerFactory::class
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
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
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
    )
);
