<?php
namespace Boletasremision\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
use Zend\Db\Adapter\Adapter;


class BoletasremisionPreFilter  extends InputFilter
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
            'name' => 'Sucursal_Remitente',
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
        
    }
    
}