<?php
namespace Usuario;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [

'router' => [
    'routes' => [
        'usuario' => [
            // Define las opciones basicas para la ruta padre:
            'type' => Literal::class,
            'options' => [
                'route'    => '/usuario',
                'defaults' => [
                    'controller' => Controller\UsuarioController::class,
                    'action'     => 'index',
                ],
            ],

            // permite que concida con las rutas hijas
            // routes match:
            'may_terminate' => true,
             // Child routes begin:
            'child_routes' => [
                'registro' => [
                    'type' =>Segment::class,
                    'options' => [
                       'route'    => '/registro',
                        'defaults' => [
                            'action' => 'registro',
                        ],
                    ],
                ],

                'registroadminuser' => [
                    'type' =>Segment::class,
                    'options' => [
                       'route'    => '/registroadminuser',
                        'defaults' => [
                            'action' => 'registroadminuser',
                        ],
                    ],
                ],

                'perfil' => [
                    'type' =>Segment::class,
                    'options' => [
                       'route'    =>'/perfil[/:Cod_Usuario]',
                        'defaults' => [
                            'action' =>'perfil',
                        ],
                    ],
                  ],

                'edit' => [
                    'type' =>Segment::class,
                    'options' => [
                       'route'    =>'/edit[/:Cod_Usuario]',
                        'defaults' => [
                            'action' => 'edit',
                        ],
                    ],
                  ], 


                'cambiarclave' => [
                    'type' =>Segment::class,
                    'options' => [
                       'route'    =>'/cambiarclave[/:Cod_Usuario]',
                        'defaults' => [
                            'action' => 'cambiarclave',
                        ],
                    ],
                  ],


                'restablecerclave' => [
                    'type' =>Segment::class,
                    'options' => [
                       'route'    =>'/restablecerclave[/:Cod_Usuario]',
                        'defaults' => [
                            'action' => 'restablecerclave',
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
                
         
          'login' => [
            // First we define the basic options for the parent route:
            'type' => Literal::class,
            'options' => [
                'route'    => '/login',
                'defaults' => [
                    'controller' => Controller\AuthController::class,
                    'action'     => 'login',
                    ],
                ],

             ],

            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'denegado' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/denegado',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'denegado',
                    ],
                ],
            ],
         ],

     ],

   'service_manager' => [
        'factories' => [
             Storage\AuthStorage::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
             \Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
        ],
    ],

     'controllers' => [
        'factories' => [
            Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
            Controller\UsuarioController::class => Controller\Factory\UsuarioControllerFactory::class
        ],

    ],
    
     'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],

        'strategies' => [
            'ViewJsonStrategy',
           ],
    ],

];