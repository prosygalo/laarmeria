<?php
namespace Usuario\Form\Filter;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;

/**
 * Este método crea input filter (usado para filtering/validation).
 */
class RestablecerFormFilter  implements InputFilterAwareInterface
{ 
  
    // agrega propiedades
    private $inputFilter;

    /**
     * Este método crea input filter (usado para filtering/validation).
     */
     public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
          }

          $inputFilter = new InputFilter();

          $inputFilter->add([
            'name' => 'Cod_Usuario',
            'filters' => [
                ['name' => ToInt::class],
               ],
            ]);

         $inputFilter->add([
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

       $inputFilter->add([
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


        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}