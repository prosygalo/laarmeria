<?php
namespace Conductor\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;

/**
 * 
 */
class ConductorFilter  extends InputFilter
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
          'name' => 'Cod_Conductor',
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
                            'table' => 'conductores',
                            'field' => 'Cod_Conductor',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El código de conductor ya existe',
                           ],
                        ],
                  ],
              ],
        ]);


       $this->add([
            'name' => 'Nombres_Conductor',
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
                        \Zend\Validator\StringLength::INVALID=>'Nombres es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Este campo es obligatorio y debe contener m&aacute;s de 3 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Este campo  debe contener menos de 50 car&aacute;cteres',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de nombres incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);

       $this->add([
            'name' => 'Apellidos_Conductor',
               'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ],
               'validators' => [
                    ['name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 50,
                            'messages' => [
                            \Zend\Validator\StringLength::INVALID=>'Apellidos es  incorrecto',
                            \Zend\Validator\StringLength::TOO_SHORT=>'Este campo es obligatorio y debe contener m&aacute;s de 3 car&aacute;cteres',
                            \Zend\Validator\StringLength::TOO_LONG=>'Este campo  debe contener menos de 50 car&aacute;cteres',
                            ],
                        ],
                    ],
                    ['name' => Regex::class, 
                        'options' => [
                            'pattern' => '/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/',
                            'messages'=>[
                             \Zend\Validator\Regex::NOT_MATCH=>'Formato de apellidos incorrecto',
                           ],
                        ],
                    ],
                ],
            ]);

          $this->add([
            'name' => 'Licencia_Conducir',
               'filters' => [
                    ['name' => StripTags::class],
                  //['name' => StringTrim::class],
                    ],
               'validators' => [
                    ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 13,
                        'max' => 13,
                        'messages' => [
                            \Zend\Validator\StringLength::INVALID=>'Licencia de conducir  es incorrecto',
                            \Zend\Validator\StringLength::TOO_SHORT=>'Licencia de conducir es obligatorio y debe tener 13 d&iacute;gitos',
                            \Zend\Validator\StringLength::TOO_LONG=>'Licencia de conducir debe tener  máximo 13 d&iacute;gitos',
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
                   ['name' =>NoRecordExists::class,
                          'options' => [
                            'table' => 'conductores',
                            'field' => 'Licencia_Conducir',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Este número ya esta registrado',
                           ],
                        ],
                  ], 
                ],
            ]);

  }
}