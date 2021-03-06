<?php
namespace General;

use General\Service\Factory\GeneralServiceFactory;
use General\Service\Factory\FlutterwaveServiceFactory;
use General\View\Helper\MyCurrency;
use General\View\Helper\StatusHelper;

return array(
    'controllers' => array(
        'invokables' => array(
            'General\Controller\General' => 'General\Controller\GeneralController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            "General\Service\GeneralService"=>GeneralServiceFactory::class,
            "General\Service\FlutterwaveService"=>FlutterwaveServiceFactory::class,
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
        'template_map' => array(
            "general-mail-transaction-success" => __DIR__ . '/../view/mail/general-transaction-success.phtml',
            "general-customer-assigned-driver" => __DIR__ . '/../view/mail/general-customer-assigned-todriver-mail.phtml',
            "general-customer-driver-dispatch" => __DIR__ . '/../view/mail/general-customer-driver-dispatched-mail.phtml',
            
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
    'view_helpers' => array(
        'invokables' => array(
            "myCurrency"=>MyCurrency::class,
            "statusHelper"=>StatusHelper::class,
        ),
    ),
);
