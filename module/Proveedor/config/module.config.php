<?php
namespace Proveedor;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    
'router' => [
    'routes' => [
        'proveedor' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/proveedor',
                'defaults' => [
                    'controller' => Controller\ProveedorController::class,
                    'action'     => 'index',
                ],
            ],

            // The following allows "/news" to match on its own if no child
            // routes match:
            'may_terminate' => true,
             // Child routes begin:
            'child_routes' => [
                'edit' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/edit[/:Cod_Proveedor]',
                        'defaults' => [
                            'action' => 'edit',
                        ],   
                    ],
                ],

                'add' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/add',
                        'defaults' => [
                            'action' => 'add',
                        ],
                    ],
                ],
                
                 'listo' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/listo',
                        'defaults' => [
                            'action' => 'listo',
                        ],
                    ],
                ],
                'error' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/error',
                        'defaults' => [
                            'action' => 'error',
                        ],
                    ],
                ],
                 
            ],

        ],
    ],
],

    'view_manager' => [
        'template_path_stack' => [
            'proveedor' => __DIR__ . '/../view',
        ],
    ],
];