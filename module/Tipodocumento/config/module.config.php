<?php
namespace Tipodocumento;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    
'router' => [
    'routes' => [
        'tipodocumento' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/tipodocumento',
                'defaults' => [
                    'controller' => Controller\TipodocumentoController::class,
                    'action'     => 'index',
                ],
            ],

            // The following allows "/news" to match on its own if no child
            // routes match:
            'may_terminate' => true,
             // Child routes begin:
            'child_routes' => [
                'add' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/add',
                        'defaults' => [
                            'action' => 'add',
                        ],
                    ],
                ],
                'edit' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/edit[/:Cod_Documento]',
                        'defaults' => [
                            'action' => 'edit',
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
            'tipodocumento' => __DIR__ . '/../view',
        ],
    ],
];