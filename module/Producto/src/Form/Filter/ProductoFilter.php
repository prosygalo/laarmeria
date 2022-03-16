<?php
namespace Producto\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\Validator\IsFloat;
use Zend\I18n\Validator\IsInt;


class ProductoFilter  extends InputFilter   
{ 
    private $dbAdapter; 

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        
        $this->add([
            'name' => 'Cod_Producto',
            'filters' => [
               ['name' => StripTags::class],
               //['name' => StringTrim::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 18,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'C&oacute;digo es incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'C&oacute;digo es obligatorio y  debe tener  m&aacute;s de 3 digitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'C&oacute;digo debe tener menos de 18 digitos',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de c&oacute;digo incorrecto',
            
                         ],
                       ],
                     ],
                      ['name' =>NoRecordExists::class,
                          'options' => [
                            'table' => 'productos',
                            'field' => 'Cod_Producto',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El código de producto ya existe',
                           ],
                        ],
                  ],
                ],
            ]);
        

        $this->add([
            'name' => 'Nombre_Producto',
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 50,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Nombre es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Nombre es obligatorio y debe contener m&aacute;s de 3 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Nombre debe contener menos de 50 car&aacute;cteres',
                        ]
                    ],
                ],
                ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-z\d\-_\s]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'Descripcion',
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 100,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Descripci&acute;on es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Descripci&oacute;n es obligatorio y  debe contener m&aacute;s de 2 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Debe contener menos de 100 car&aacute;cteres',
                        ]
                    ],
            
                ],
               ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9\s-]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);
          $this->add([
            'name' => 'Precio',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' =>3,
                        'max' =>10,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Precio es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Precio debe tener mínimo 4 dígitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'Precio debe tener máximo 8 dígitos y dos decimales',
                        ]
                    ],
                ],
                 ['name' => IsFloat::class,
                     'options' => [
                       'messages'=>[
                        \Zend\I18n\Validator\IsFloat::INVALID=>'Tipo no válido',
                        \Zend\I18n\Validator\IsFloat::NOT_FLOAT=>'Se proporcionó un tipo no válido. Se espera entero o decimal',
            
                      ],
                    ],
                ],
            ],
        ]);
           $this->add([
            'name' => 'Cantidad',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' =>1,
                        'max' =>10,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Cantidad es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Cantidad debe tener mínimo 1 dígito',
                        \Zend\Validator\StringLength::TOO_LONG=>'Cantidad debe tener máximo 8 dígitos',
                        ]
                    ],
                ],
                 ['name' => IsInt::class,
                     'options' => [
                       'messages'=>[
                        \Zend\I18n\Validator\IsInt::INVALID=>'Tipo no válido',
                        \Zend\I18n\Validator\IsInt::NOT_INT =>'Se proporcionó un tipo no válido. Se espera entero',
            
                      ],
                    ],
                ],
            ],
        ]);
    }
    
}

