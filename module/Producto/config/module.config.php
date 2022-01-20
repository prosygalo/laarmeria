<?php

namespace Producto;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;


return [
    
'router' => [
    'routes' => [
        'productos' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/productos',
                'defaults' => [
                    'controller' => Controller\ProductoController::class,
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
                        'route'    => '/edit[/:Cod_Producto]',
                        'defaults' => [
                            'action' => 'edit',
                        ],
                    ],
                ],

                
                 'delete' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/delete[/:Cod_Producto]',
                        'defaults' => [
                            'action' => 'delete',
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
                 'verproducto' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/verproducto[/:Cod_Producto]',
                        'defaults' => [
                            'action' => 'verproducto',
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
            'producto' => __DIR__ . '/../view',
        ],
    ],
];