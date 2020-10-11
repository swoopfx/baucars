<?php
use General\Service\Factory\GeneralServiceFactory;

return array(
    'controllers' => array(
        'invokables' => array(
            'General\Controller\General' => 'General\Controller\GeneralController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            "General\Service\GeneralService"=>GeneralServiceFactory::class
        ),
    ),
    'router' => array(
        'routes' => array(
            'general' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/general',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'General\Controller',
                        'controller'    => 'General',
                        'action'        => 'index',
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
            'General' => __DIR__ . '/../view',
        ),
    ),
);
