<?php
namespace  Wallet;
use Wallet\Controller\Factory\WalletControllerFactory;
use Wallet\Controller\Factory\ApiControllerFactory;
use Wallet\Service\WalletService;
use Wallet\Service\Factory\WalletServiceFactory;

return array(
    'controllers' => array(
//         'invokables' => array(
//             'Wallet\Controller\Wallet' => 'Wallet\Controller\WalletController',
//         ),
        'factories' => array(
            "Wallet\Controller\Wallet"=>WalletControllerFactory::class,
            "Wallet\Controller\Api"=>ApiControllerFactory::class,
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            WalletService::class=>WalletServiceFactory::class
        ),
    ),
    'router' => array(
        'routes' => array(
            'wallet' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/wallet',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Wallet\Controller',
                        'controller'    => 'Wallet',
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
            'Wallet' => __DIR__ . '/../view',
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
