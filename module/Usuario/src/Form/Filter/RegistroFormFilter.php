<?php
namespace Usuario\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Db\Adapter\AdapterInterface;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\Db\NoRecordExists;


/**
 * Este método crea input filter (usado para filtering/validation).
 */
class RegistroFormFilter extends InputFilter
{ 
  
    // agrega propiedades
    private $dbAdapter; 

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;

        $this->add([
            'name' => 'Cod_Usuario',
            'filters' => [
                ['name' => ToInt::class],
               ],
        ]);

        $this->add([
            'name' => 'Cod_Empleado',
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
            ],
        ]);
        
         $this->add([
            'name' => 'Departamento',
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
            ],
        ]);
         
        $this->add([
            'name' => 'Sucursal',
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
            ],
        ]);



        $this->add([
            'name' => 'Usuario',
            'filters' => [
               ['name' => StripTags::class],
              
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 50,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'No válido',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Este campo es obligatorio y debe contener m&aacute;s de  5car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Este campo  debe contener menos de 50 car&aacute;cteres',
                        ]
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
                    'options' => [
                        'messages' => [
                        \Zend\Validator\EmailAddress::INVALID=>'Tipo no válido dado. Cadena esperada',
                        \Zend\Validator\EmailAddress::INVALID_FORMAT=>'La entrada no es una dirección de correo electrónico válida. Utilice el formato',
                        \Zend\Validator\EmailAddress::INVALID_HOSTNAME=>'No es un nombre de host válido para la dirección de correo electrónico',
                        \Zend\Validator\EmailAddress::INVALID_MX_RECORD=>'No parece tener registros MX o A válidos para la dirección de correo electrónico',
                        \Zend\Validator\EmailAddress::INVALID_SEGMENT=>'no está en un segmento de red enrutable. La dirección de correo electrónico no debe resolverse desde la red pública.',
                        \Zend\Validator\EmailAddress::DOT_ATOM=>'no se puede comparar con el formato dot-atom',
                        \Zend\Validator\EmailAddress::QUOTED_STRING=>'no se puede comparar con el formato de cadena entre comillas',
                        \Zend\Validator\EmailAddress::INVALID_LOCAL_PART=>'no es una parte local válida para la dirección de correo electrónico',
                        \Zend\Validator\EmailAddress::LENGTH_EXCEEDED=>'La entrada excede la longitud permitida',
                        ],
                    ],

                ],
                ['name' => NoRecordExists::class,
                        'options' => [
                            'table' => 'usuarios',
                            'field' => 'correo',
                            'adapter' =>$this->dbAdapter,
                            'messages' => [
                                \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'El correo ya existe',
                           ],
                        ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'Rol',
            'filters' => [
               ['name' => StripTags::class],
               //['name' => StringTrim::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 20,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Rol  es inválido',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Rol es obligatorio y  debe tener mas de 5 d&iacute;gitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'Rol debe tener  menos de  20 d&iacute;gitos',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de Rol incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'Clave',
            'filters' => [
               ['name' => StripTags::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 8,
                        'max' => 15,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Es inválida',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Ingrese contraseña de 8 caracteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'La contraseña excede la longitud permitida ',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Ingrese contraseña que contenga letras y números',
                         ],
                       ],
                    ],
                 ],
              ]);

      $this->add([
           'name' => 'Confirmarclave',
            'filters' => [
               ['name' => StripTags::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 8,
                        'max' => 15,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Es inválida',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Ingrese contraseña que contenga números y letras',
                        \Zend\Validator\StringLength::TOO_LONG=>'La contraseña excede la longitud permitida',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Ingrese contraseña que contenga letras y números',
                         ],
                       ],
                    ],
                    ['name' => Identical::class, 
                     'options' => [
                       'token' => 'Clave',
                       'messages'=>[
                        \Zend\Validator\Identical::NOT_SAME =>'Las contraseñas no son identicas',
                        \Zend\Validator\Identical::MISSING_TOKEN =>'Ingrese una contraseña para confirmar',
            
                      ],
                    ],
                ],
            ],
        ]);


        $this->add([
            'name' => 'Estado',
            'filters' => [
               ['name' => StripTags::class],
               //['name' => StringTrim::class],
               ],
             'validators' => [
                       ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 6,
                        'max' => 8,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Estado  es inválido',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Estado es obligatorio',
                        \Zend\Validator\StringLength::TOO_LONG=>'Sobrepasa longitud permitida',
                         ],
                       ],
                      ],
                     ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z]+$/',
                       'messages'=>[
                        // \Zend\Validator\Regex::INVALID_CHARACTERS =>'Caracteres invalidos',
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato de Estado incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]);
    }
}