<?php
namespace Boletasremision;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
'router' => [
    'routes' => [
        'boletasremision' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/boletasremision',
                'defaults' => [
                    'controller' => Controller\BoletasremisionController::class,
                    'action'     => 'index',
                ],
            ],

            'may_terminate' => true,
             // Child routes begin:
            'child_routes' => [
             'add' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/add[/:Sucursal_Remitente]',
                        'defaults' => [
                            'action' => 'add',
                        ],
                    ],
                ],
                'sucdes' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/sucdes[/:Sucursal_Destino]',
                        'defaults' => [
                            'action' => 'sucdes',
                        ],
                    ],
                ],

                'errorautorizacion' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/errorautorizacion',
                        'defaults' => [
                            'action' => 'errorautorizacion',
                        ],
                    ],
                ],
                 'vencimientofecha' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/vencimientofecha',
                        'defaults' => [
                            'action' => 'vencimientofecha',
                        ],
                    ],
                ],
                 'expirocorrelativo' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/expirocorrelativo',
                        'defaults' => [
                            'action' => 'expirocorrelativo',
                        ],
                    ],
                ],
                 'inactiva' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/inactiva',
                        'defaults' => [
                            'action' => 'inactiva',
                        ],
                    ],
                ],

                'detalle' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/detalle[/:Cod_Boleta]',
                        'defaults' => [
                            'action' => 'detalle',
                        ],   
                    ],
                ],

                'reporte' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/reporte[/:Cod_Boleta]',
                        'defaults' => [
                            'action' => 'reporte',
                        ],   
                    ],
                ],
                
                 'pdf' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/pdf[/:Cod_Boleta]',
                        'defaults' => [
                            'action' => 'pdf',
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
            'boletasremision' => __DIR__ . '/../view',
       ],
    
    'strategies' => [
            'ViewJsonStrategy',
           ],
      ],  
];