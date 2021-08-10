<?php
namespace Conductor;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    
'router' => [
    'routes' => [
        'conductor' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/conductor',
                'defaults' => [
                    'controller' => Controller\ConductorController::class,
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
                        'route'    => '/edit[/:Cod_Conductor]',
                        'defaults' => [
                            'action' => 'edit',
                        ],   
                    ],
                ],

                 'vercodigo' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/vercodigo[/:Cod_Conductor]',
                        'defaults' => [
                            'action' => 'vercodigo',
                        ],   
                    ],
                ],

                
                 'delete' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/delete[/:Cod_Conductor]',
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
            'conductor' => __DIR__ . '/../view',
        ],
    ],
];