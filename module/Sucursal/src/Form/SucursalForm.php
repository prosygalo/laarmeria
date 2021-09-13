<?php

namespace Sucursal\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Form\Element\Csrf;


class SucursalForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('sucursal');
        
        $this->add([
            'name' => 'Cod_Sucursal',
            'type' => 'text',
            'options' => [
                'label' => 'Código de sucursal',
            ],
        ]);
       
        $this->add([
            'name' => 'Nombre_Sucursal',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre',
            ],
        ]);

        $this->add([
            'name' => 'RTN',
            'type' => 'text',
            'options' => [
                'label' => 'RTN',
            ],
        ]);

        $this->add([
            'name' => 'Direccion',
            'type' => 'text',
            'options' => [
                'label' => 'Dirección',
            ],
        ]);

        $this->add([
            'name' => 'Telefono',
            'type' => 'text',
            'options' => [
                'label' => 'Teléfono',
            ],
        ]);

         
         $this->add([
            'name' => 'Correo',
            'type' => 'text',
            'options' => [
                'label' => 'Correo electrónico',
            ],
        ]);

         $this->add([
            'type' => Element\Select::class,
            'name' => 'Estado',
            'options' => [
                'label' => 'Estado',
                'empty_option' => 'Seleccione',
                'value_options' => [
                       'Disponible' => 'Disponible',
                       'Cierre Parcial' => 'Cierre Parcial',
                       'Cierre Total' => 'Cierre Total',
               ],
            ],
        ]);
               
        $this->add([
              'type'  => 'csrf',
              'name' => 'csrf',
              'options' => [                
                'csrf_options' => [
                  'timeout' => 600
                ]
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