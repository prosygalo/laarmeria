<?php
namespace Constanciaretencion;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
'router' => [
    'routes' => [
        'constanciaretencion' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/constanciaretencion',
                'defaults' => [
                    'controller' => Controller\ConstanciaretencionController::class,
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

             'proveedor' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/proveedor[/:RTN_Proveedor]',
                        'defaults' => [
                            'action' => 'proveedor',
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
                        'route'    => '/detalle[/:Cod_Constancia]',
                        'defaults' => [
                            'action' => 'detalle',
                        ],   
                    ],
                ],

                'reporte' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/reporte[/:Cod_Constancia]',
                        'defaults' => [
                            'action' => 'reporte',
                        ],   
                    ],
                ],
                
                 'pdf' => [
                    'type' =>Segment::class,
                    'options' => [
                        'route'    => '/pdf[/:Cod_Constancia]',
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
            'constanciaretencion' => __DIR__ . '/../view',
       ],
    
    'strategies' => [
            'ViewJsonStrategy',
           ],
      ],  
];