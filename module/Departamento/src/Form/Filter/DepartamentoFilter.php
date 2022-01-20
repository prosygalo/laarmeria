<?php
namespace Departamento\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;


class DepartamentoFilter  extends InputFilter   
{ 
    private $dbAdapter; 

    public function __construct(Adapter $dbAdapter)
    {
        
        $this->dbAdapter = $dbAdapter;
        
        $this->add([
            'name' => 'Cod_Departamento',
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
                            'table' => 'departamentos',
                            'field' => 'Cod_Departamento',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El código de departamento  ya existe',
                           ],
                        ],
                  ],
            ],
        ]);


        $this->add([
            'name' => 'Nombre_Depto',
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
                       'pattern' => '/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato  incorrecto',
            
                      ],
                    ],
                ],
                 ['name' =>NoRecordExists::class,
                          'options' => [
                            'table' => 'departamentos',
                            'field' => 'Nombre_Depto',
                            'adapter' =>  $this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El nombre de departamento  ya existe',
                           ],
                        ],
                  ],
            ],
        ]);


    }
    
}

