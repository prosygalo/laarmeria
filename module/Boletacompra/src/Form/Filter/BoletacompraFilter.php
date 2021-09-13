<?php
namespace Boletacompra\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\ArrayInput;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\Date;
use Zend\Validator\EmailAddress;
//use Zend\Validator\InArray;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;



class BoletacompraFilter  extends InputFilter
{ 
  // Add this property:    
    private $dbAdapter;    

    /**
     * Constructor.     
     */
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;

        $this->add([
            'name' => 'Cod_Boleta',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
             ],
        ]);

        $this->add([
            'name' => 'Fecha_Emision',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [
                    ['name'=>Date::class,
                      'options'=>[
                      'format' => 'Y-m-d',
                      'messages' => [
                        \Zend\Validator\Date::INVALID=>'Fecha emisión no válida',
                        \Zend\Validator\Date::INVALID_DATE=>'Fecha Inválida',
                        \Zend\Validator\Date::FALSEFORMAT=>'Formato de fecha incorrecto',
                         ],
                      ],

                    ],              
                ],
        ]);

        $this->add([
            'name' => 'Consecutivo_Actual_Establ',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 3,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Establ   incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Establ es obligatorio y debe contener 3 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Establ debe contener 3 car&aacute;cteres',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],

        ]);

        $this->add([
            'name' => 'Consecutivo_Actual_Punto',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 3,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Punto   incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Punto es obligatorio y debe contener 3 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Punto debe contener 3 car&aacute;cteres',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato es incorrecto',
            
                      ],
                    ],
                ],
            ],

        ]);

        $this->add([
            'name' => 'Consecutivo_Actual_Tipo',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 2,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Tipo   incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Tipo es obligatorio',
                        \Zend\Validator\StringLength::TOO_LONG=>'Tipo debe contener dos car&aacute;cteres',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],

        ]);

        $this->add([
            'name' => 'Consecutivo_Actual_Correlativo',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' =>8 ,
                        'max' =>8,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Correlativo  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Correlativo es obligatorio y debe contener 8 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Correlativo debe contener 8 car&aacute;cteres',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
                ['name' =>NoRecordExists::class,
                          'options' => [
                            'table' => 'boletas_guia_remision',
                            'field' => 'Consecutivo_Actual_Correlativo',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El correlativo ya existe',
                           ],
                        ],
                  ],
            ],

        ]);

        $this->add([
            'name' => 'Motivo_Traslado',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
              
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 50,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Motivo de traslado es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Motivo traslado debe contener m&aacute;s de 3 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Motivo de traslado  debe contener menos de 50 car&aacute;cteres',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);
      
        
        $this->add([
            'name' => 'Fecha_Inicio_Traslado',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [ 
                    ['name'=>Date::class,
                      'options'=>[
                      'format' => 'Y-m-d',
                      'messages' => [
                        \Zend\Validator\Date::INVALID=>'Fecha  no válida',
                        \Zend\Validator\Date::INVALID_DATE=>'Fecha inválida',
                        \Zend\Validator\Date::FALSEFORMAT=>'Formato de fecha incorrecto',
                         ],
                      ],

                    ],              
                ],
        ]);

        $this->add([
            'name' => 'Fecha_Final_Traslado',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [
                    ['name'=>Date::class,
                      'options'=>[
                      'format' => 'Y-m-d',
                      'messages' => [
                        \Zend\Validator\Date::INVALID=>'Fecha  no válida',
                        \Zend\Validator\Date::INVALID_DATE=>'Fecha inválida',
                        \Zend\Validator\Date::FALSEFORMAT=>'Formato de fecha incorrecto',
                         ],
                      ],

                    ],              
              ],
        ]);
          
        $this->add([
            'name' => 'Punto_Partida',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' => 200,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Punto de artida es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Punto de partida es obligatorio y  debe contener m&aacute;s de 4 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Punto pde artida  debe contener menos de 200 car&aacute;cteres',
                        ]
                    ],
            
                ],
            ],
        ]);

        $this->add([
            'name' => 'Punto_Destino',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' => 200,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Punto de destino es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Punto de destino es obligatorio y  debe contener m&aacute;s de 4 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Punto de destino debe contener menos de 200 car&aacute;cteres',
                        ]
                    ],
            
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'Sucursal',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'Autorizacion_Sar',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
             ],
           ]);

          $this->add([
            'name' => 'Unidad_Transporte',
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        //'min' => 3,
                        'max' => 18,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Unidad de transporte es incorrecto',
                        //\Zend\Validator\StringLength::TOO_SHORT=>'Unidad de transportees obligatorio y  debe tener  m&aacute;s de 3 digitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'Unidad de transporte debe tener menos de 18 digitos',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato  incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);
         
        $this->add([
            'name' => 'Conductor',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 18,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Conductor es incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Conductores obligatorio y  debe tener  m&aacute;s de 3 digitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'Conductor debe tener menos de 18 digitos',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de Conductor incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);
    }
    
}