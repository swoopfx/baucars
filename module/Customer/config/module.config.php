<?php
namespace Customer;
use Customer\Service\Factory\CustomerServiceFactory;
use Customer\Service\Factory\BookingServiceFactory;
use Customer\Paginator\Factory\CustomerAdapterInterface;
use Customer\Paginator\Factory\AllBookingAdapterInterface;
use Customer\Paginator\Factory\AdminInitiatedBookingFactory;

return array(
    'controllers' => array(
        'invokables' => array(
//             'Customer\Controller\Customer' => 'Customer\Controller\CustomerController',
        ),
        'factories' => array(
            'Customer\Controller\Customer' => 'Customer\Controller\Factory\CustomerControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'customer' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/customer',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Customer\Controller',
                        'controller'    => 'Customer',
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
                            'route'    => '/[:action[/:id]]',
                            'constraints' => array(
                                'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
            'Customer' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            "customer-booking-details-snippet"=> __DIR__ . '/../view/customer/partials/booking-details-snippet.phtml'
        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            "Customer\Service\CustomerService"=>CustomerServiceFactory::class,
            "Customer\Service\BookingService"=>BookingServiceFactory::class,
            
            "CustomerPaginator"=>CustomerAdapterInterface::class,
            "allBookingPaginator"=>AllBookingAdapterInterface::class,
            "adminInitiatedBokkingPaginator"=>AdminInitiatedBookingFactory::class
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
