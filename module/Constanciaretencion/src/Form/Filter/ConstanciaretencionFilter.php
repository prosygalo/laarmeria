<?php
namespace Constanciaretencion\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\Date;
use Zend\Validator\EmailAddress;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;
use Zend\I18n\Validator\IsFloat;



class  ConstanciaretencionFilter  extends InputFilter
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
            'name' => 'Cod_Constancia',
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
                        \Zend\Validator\StringLength::INVALID=>'No. de correlativo es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'No. de correlativo es muy corto 000-000-00-00000000',
                        \Zend\Validator\StringLength::TOO_LONG=>'No. de correlativo debe contener máximo 16 dígitos  separados por guiones 000-000-00-00000000',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-Z0-9_-]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'use el formato  000-000-00-00000000',
            
                      ],
                    ],
                ],
            ],
        ]);
        $this->add([
            'name' => 'Cai_Documento',
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
                        \Zend\Validator\StringLength::INVALID=>'CAI es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'CAI debe contener 32 car&aacute;cteres alfanuméricos separados por guiones',
                        \Zend\Validator\StringLength::TOO_LONG=>'CAI debe contener máximo 32 car&aacute;cteres alfanuméricos separados por guiones',
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
            'name' => 'Base_Gravable_Impuesto',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' =>10,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Base Gravable del Impuesto es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Base Gravable del Impuesto  debe  tener mínimo 4 dígitos',
                        \Zend\Validator\StringLength::TOO_LONG=>'Base Gravable del Impuesto debe tener como máximo 10 dígitos',
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
            'name' => 'Importe_Retencion',
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
                        'max' => 9,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Importe de retención es incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Importe de retención esta por debajo de mínimo',
                        \Zend\Validator\StringLength::TOO_LONG=>'Importe de retención debe contener máximo 8 digitos y dos cifras despúes del punto',
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
            'name' => 'Cai_Documento',
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
            'name' => 'Documento_Retencion',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [
                      ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 50,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'Documento de retención es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Documento de retención debe contener mínimo 5 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Documento de retención debe contener máximo 50 car&aacute;cteres',
                        ],
                    ],
                ],
            ],
        ]);

          $this->add([
            'name' => 'Descripcion_Tributo_Retenido',
            'required' => true,
            'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
               ],
             'validators' => [
                      ['name' => StringLength::class,
                        'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 100,
                        'messages' => [
                        \Zend\Validator\StringLength::INVALID=>'La descripción del tributo retenido es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'La descripción del tributo retenido debe contener mínimo 5 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'La descripción del tributo retenido debe contener máximo 100 car&aacute;cteres',
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
    }   
}