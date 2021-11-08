<?php

namespace Producto\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ProductoForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('producto');

         
           $this->add([
            'name' => 'Cod_Producto',
            'type' => 'text',
            'options' => [
                'label' => 'Código de producto',
            ],
        ]);
       
        $this->add([
            'name' => 'Nombre_Producto',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre de producto',
            ],
        ]);

        $this->add([
            'name' => 'Descripcion',
            'type' => 'text',
            'options' => [
                'label' => 'Descripción',
            ],
        ]);

        $this->add([
            'name' => 'Precio',
            'type' => 'text',
            'options' => [
                'label' => 'Precio',
            ],
            'attributes' => [
                 'value' => '0',
            ],
        ]);


         $this->add([
            'type' => Element\Select::class,
            'name' => 'Tipo_Importe',
            'options' => [
                'label' => 'Tipo de Importe',
                'value_options' => [
                       'G' => 'G',
                       'E' => 'E',
               ],
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