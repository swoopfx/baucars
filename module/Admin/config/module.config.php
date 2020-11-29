<?php
use Admin\Controller\Factory\AdminControllerFactory;
use Admin\Controller\Factory\CustomerControllerFactory;
use Admin\Controller\Factory\BookingControllerFactory;
use Admin\Controller\Factory\DriverControllerFactory;
use Admin\Controller\Factory\CarControllerFactory;
use Admin\Controller\Factory\SettingsControllerFactory;

return array(
    'controllers' => array(
        'invokables' => array(
            // 'Admin\Controller\Driver' => 'Admin\Controller\DriverController',
        ),
        'factories' => array(
            'Admin\Controller\Admin' => AdminControllerFactory::class,
            "Admin\Controller\Customer" => CustomerControllerFactory::class,
            "Admin\Controller\Booking" => BookingControllerFactory::class,
            "Admin\Controller\Driver" => DriverControllerFactory::class,
            "Admin\Controller\Car"=>CarControllerFactory::class,
            "Admin\Controller\Settings"=>SettingsControllerFactory::class
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
            'Admin' => __DIR__ . '/../view',
            
            
        ),
        "template_map"=>[
            'booking-menu-list' => __DIR__ . '/../view/admin/booking/partial/booking_menu_list.phtml',
            
            // email
            'admin-new-booking' => __DIR__ . '/../view/email/admin-user-new-booking.phtml'
        ],
        'strategies' => array(
            'ViewJsonStrategy'
        )
    )
);
