<?php
namespace Tipodocumento\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\Date;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;

/**
 * 
 */
class TipodocumentoEditFilter  extends InputFilter
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
            'name' => 'Cod_Documento',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
             ],
           ]);

         $this->add([
            'name' => 'Nombre_Documento',
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
                        \Zend\Validator\StringLength::INVALID=>'Nombre documento  es  incorrecto',
                        \Zend\Validator\StringLength::TOO_SHORT=>'Nombre de documento debe contener 5 car&aacute;cteres',
                        \Zend\Validator\StringLength::TOO_LONG=>'Nombre de documento debe contener máximo 50 car&aacute;cteres',
                        ]
                    ],
                ],
                 ['name' => Regex::class, 
                     'options' => [
                       'pattern' => '/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/',
                       'messages'=>[
                        \Zend\Validator\Regex::NOT_MATCH=>'Formato  incorrecto',
            
                      ],
                    ],
                ],
            ],
        ]); 

        }    
    
}
