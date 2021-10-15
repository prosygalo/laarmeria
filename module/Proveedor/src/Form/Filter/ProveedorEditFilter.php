<?php
namespace Proveedor\Form\Filter;

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
class ProveedorEditFilter  extends InputFilter
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
            'name' => 'Cod_Proveedor',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
             ],
           ]);

       $this->add([
            'name' => 'Nombre_Proveedor',
            'filters' => [
               ['name' => StripTags::class],
              
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Nombre es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Este campo es obligatorio y debe contener m&aacute;s de 3 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Este campo  debe contener menos de 100 car&aacute;cteres',
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
            'name' => 'RTN_Proveedor',
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
            'name' => 'Direccion_Proveedor',
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
            'name' => 'Telefono_Proveedor',
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

  }
}