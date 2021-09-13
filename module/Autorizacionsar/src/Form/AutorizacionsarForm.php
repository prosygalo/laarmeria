<?php
namespace Autorizacionsar\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class AutorizacionsarForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('autorizacionsar');

        $this->add([
            'name' => 'Cod_Autorizacion',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'Cai',
            'type' => 'text',
            'options' => [
                'label' => '(C.A.I.)',
            ],
        ]);

        $this->add([
            'name' => 'Consecutivo_Inicial_Establ',
            'type' => 'text',
            'options' => [
                'label' => 'Establ',
            ],
        ]);
         $this->add([
            'name' => 'Consecutivo_Inicial_Punto',
            'type' => 'text',
            'options' => [
                'label' => 'Punto',
            ],
        ]);
          $this->add([
            'name' => 'Consecutivo_Inicial_Tipo',
            'type' => 'text',
            'options' => [
                'label' => 'Tipo',
            ],
        ]);
           $this->add([
            'name' => 'Consecutivo_Inicial_Correlativo',
            'type' => 'text',
            'options' => [
                'label' => 'Correlativo',
            ],
        ]);
        
        $this->add([
            'name' => 'Consecutivo_Final_Establ',
            'type' => 'text',
            'options' => [
                'label' => 'Establ',
            ],
        ]);
         $this->add([
            'name' => 'Consecutivo_Final_Punto',
            'type' => 'text',
            'options' => [
                'label' => 'Punto',
            ],
        ]);
          $this->add([
            'name' => 'Consecutivo_Final_Tipo',
            'type' => 'text',
            'options' => [
                'label' => 'Tipo',
            ],
        ]);
           $this->add([
            'name' => 'Consecutivo_Final_Correlativo',
            'type' => 'text',
            'options' => [
                'label' => 'Correlativo',
            ],
        ]);
        $this->add([
            'name' => 'Consecutivo_Actual_Establ',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'Consecutivo_Actual_Punto',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'Consecutivo_Actual_Tipo',
            'type' => 'text',
        ]);
        $this->add([
            'name' => 'Consecutivo_Actual_Correlativo',
            'type' => 'text',
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'Sucursal',
            'options' => [
                'label' => 'Sucursal',
                'empty_option' => 'Seleccione',
             ],
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'Tipo_de_Documento',
            'options' => [
                'label' => 'Tipo de documento',
                'empty_option' => 'Seleccione',
             ],
        ]);

        $this->add([
            'name' => 'Fecha_Limite',
            'type' => 'text',
            'options' => [
                'label' => 'Fecha Límite de emisión',
            ],
            'attributes' => [
                'id'    => 'Fecha_Limite',
                'placeholder'=>'dd/mm/aaaa',
                'readonly'=>'readonly',

            ],
        ]);
    
         $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}