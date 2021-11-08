<?php
namespace Cliente;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    
'router' => [
    'routes' => [
        'cliente' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/cliente',
                'defaults' => [
                    'controller' => Controller\ClienteController::class,
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
                        'route'    => '/edit[/:Cod_Cliente]',
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
            'cliente' => __DIR__ . '/../view',
        ],
    ],
];