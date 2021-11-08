<?php
namespace Notadebito\Form\Filter;

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



class NotadebitoFilter  extends InputFilter
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
            'name' => 'Cod_Nota',
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
                        \Zend\Validator\Date::INVALID=>'Fecha Emisión no válida',
                        \Zend\Validator\Date::INVALID_DATE=>'Fecha Inválida',
                        \Zend\Validator\Date::FALSEFORMAT=>'Formato de fecha incorrecto',
                         ],
                      ],

                    ],              
                ],
        ]);
          $this->add([
            'name' => 'Fecha_Emision_Comprobante',
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
                        \Zend\Validator\Date::INVALID=>'Fecha Emisión Comprobante no válida',
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
                            'table' => 'notas_debito',
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
            'name' => 'Cliente',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
             'validators' => [
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],
          ]);

         $this->add([
            'name' => 'No_Correlativo',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 19,
                        'max' => 19,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'No. Correlativo es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'No. Correlativo  debe contener 19 car&aacute;cteres numéricos separados por guiones',
                        \Zend\Validator\StringLength::TOO_LONG=>'No. Correlativo debe contener máximo 19 car&aacute;cteres numéricos separados por guiones',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9_-]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de No. Correlativo  incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);
    


        $this->add([
            'name' => 'Cai_Comprobante',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 37,
                        'max' => 37,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'C.A.I. es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'C.A.I. debe contener 32 car&aacute;cteres alfanuméricos separados por guiones',
                        \Zend\Validator\StringLength::TOO_LONG=>'C.A.I. debe contener máximo 32 car&aacute;cteres alfanuméricos separados por guiones',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9_-]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de CAI incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'RTN_DNI',
               'filters' => [
                    ['name' => StripTags::class],
                  //['name' => StringTrim::class],
                    ],
               'validators' => [
                    ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 13,
                        'max' => 14,
                        'messages' => [
                            \Zend\Validator\StringLength::INVALID=>'RTN/DNI es incorrecto',
                            \Zend\Validator\StringLength::TOO_SHORT=>'RTN/DNI  debe tener mínimo 13 d&iacute;gitos',
                            \Zend\Validator\StringLength::TOO_LONG=>'RTN/DNI debe tener  máximo 14 d&iacute;gitos',
                           ],
                        ],
                    ],
                    ['name' => Regex::class, 
                        'options' => [
                        'pattern' => '/^[0-9]+$/',
                        'messages'=>[
                            // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                            \Zend\Validator\Regex::NOT_MATCH=>'Formato  incorrecto, use solo d&iacute;gitos',
            
                           ],
                        ],
                    ],
                ],
            ]);
  
        $this->add([
            'name' => 'Usuario',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
             'validators' => [
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
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
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
             'validators' => [
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],
          ]);
    }    
}