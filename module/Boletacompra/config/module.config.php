<?php
namespace Boletacompra;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
'router' => [
    'routes' => [
        'boletacompra' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/boletacompra',
                'defaults' => [
                    'controller' => Controller\BoletacompraController::class,
                    'action'     => 'index',
                ],
            ],

            'may_terminate' => true,
             // Child routes begin:
            'child_routes' => [
             'add' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/add[/:Sucursal]',
                        'defaults' => [
                            'action' => 'add',
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

                'detalle' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/detalle[/:Cod_Boleta_Compra]',
                        'defaults' => [
                            'action' => 'detalle',
                        ],   
                    ],
                ],

                'reporte' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/reporte[/:Cod_Boleta_Compra]',
                        'defaults' => [
                            'action' => 'reporte',
                        ],   
                    ],
                ],
                
                 'pdf' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/pdf[/:Cod_Boleta_Compra]',
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
            'boletacompra' => __DIR__ . '/../view',
       ],
    
    'strategies' => [
            'ViewJsonStrategy',
           ],
      ],  
];
