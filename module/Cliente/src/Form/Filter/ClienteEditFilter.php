<?php
namespace Cliente\Form\Filter;

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
class ClienteEditFilter  extends InputFilter
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
            'name' => 'Cod_Cliente',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
             ],
           ]);

        $this->add([
            'name' => 'Nombres_Cliente',
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
            'name' => 'Apellidos_Cliente',
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
                            \Zend\Validator\StringLength::TOO_SHORT=>'RTN/DNI debe tener mínimo 13 d&iacute;gitos',
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

  }
}