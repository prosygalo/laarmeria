<?php
namespace Notadebito;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
'router' => [
    'routes' => [
        'notadebito' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/notadebito',
                'defaults' => [
                    'controller' => Controller\NotadebitoController::class,
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
                'cliente' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/cliente[/:Rtn_Dni]',
                        'defaults' => [
                            'action' => 'cliente',
                        ],
                    ],
                ],
                'precio' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/precio[/:Producto]',
                        'defaults' => [
                            'action' => 'precio',
                        ],
                    ],
                ],
                'producto' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/producto[/:Cod_Producto]',
                        'defaults' => [
                            'action' => 'producto',
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
                        'route'    => '/detalle[/:Cod_Nota]',
                        'defaults' => [
                            'action' => 'detalle',
                        ],   
                    ],
                ],

                'reporte' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/reporte[/:Cod_Nota]',
                        'defaults' => [
                            'action' => 'reporte',
                        ],   
                    ],
                ],
                
                 'pdf' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/pdf[/:Cod_Nota]',
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
                 'prueba' => [
                    'type' =>Segment::class,
                    'options' => [
                         'route'    => '/prueba[/:Cod_Nota]',
                        'defaults' => [
                            'action' => 'prueba',
                        ],
                    ],
                ],
                 
            ],

        ],
    ],
],
 
    'view_manager' => [
     'template_path_stack' => [
            'notadebito' => __DIR__ . '/../view',
       ],
    
    'strategies' => [
            'ViewJsonStrategy',
           ],
      ],  
];
