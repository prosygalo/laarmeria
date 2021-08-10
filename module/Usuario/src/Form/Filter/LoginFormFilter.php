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
class LoginFormFilter  implements InputFilterAwareInterface
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
                [
                    'name' => EmailAddress::class,
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
                 ],
              ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}