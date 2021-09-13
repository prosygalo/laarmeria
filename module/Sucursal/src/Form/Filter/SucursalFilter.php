<?php
namespace Sucursal\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\EmailAddress;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;


class SucursalFilter   extends InputFilter
{ 

  private $dbAdapter; 
 
  public function __construct(Adapter $dbAdapter)
  {

      $this->dbAdapter = $dbAdapter;
  
          $this->add([
            'name' => 'Cod_Sucursal',
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
                       'pattern' => '/^[a-zA-Z0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de c&oacute;digo incorrecto',
            
                      ],
                  ],
                ],
                ['name' =>NoRecordExists::class,
                          'options' => [
                            'table' => 'sucursales',
                            'field' => 'Cod_Sucursal',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El código de sucursal ya existe',
                           ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'Nombre_Sucursal',
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
                 ['name' =>NoRecordExists::class,
                          'options' => [
                            'table' => 'sucursales',
                            'field' => 'Nombre_Sucursal',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El nombre de sucursal ya existe',
                           ],
                    ],
                ],
            ],
        ]);

         $this->add([
            'name' => 'RTN',
            'filters' => [
               ['name' => StripTags::class],
               //['name' => StringTrim::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 14,
                        'max' => 14,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'RTN  es incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'RTN es obligatorio y  debe tener 14 d&iacute;gitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'RTN debe tener  14 d&iacute;gitos',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de RTN incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'Direccion',
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
                        \Zend\Validator\StringLength::INVALID=>'Direcci&acute;on es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Direcci&acute;on n es obligatorio y  debe contener m&aacute;s de 4 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Direcci&acute;on  debe contener menos de 200 car&aacute;cteres',
                        ]
                    ],
            
                ],
            ],
        ]);

        $this->add([
            'name' => 'Telefono',
            'filters' => [
               ['name' => StripTags::class],
               //['name' => StringTrim::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' =>9,
                        'max' =>9,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Tel&eacute;fono  es incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Tel&eacute;fono es obligatorio y  debe tener 9 d&iacute;gitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'Tel&eacute;fono debe tener  8 d&iacute;gitos seg&aucute,un el formato',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[0-9]{3,4}(-[0-9]{3,4})?$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de tel&eacute;fono incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'Correo',
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
                        'max' => 40,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'correo eletr&oacute;nico es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'correo eletr&oacute;nico  es obligatorio',
                        \Zend\Validator\StringLength::TOO_LONG=>'correo  eletr&oacute;nico  debe contener menos de 40 car&aacute;cteres',
                        ]
                    ],
                ],
                ['name' => EmailAddress::class,
                ],      
            ],
        ]);
    
    }
    
}

