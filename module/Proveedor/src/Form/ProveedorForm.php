<?php
namespace Proveedor\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class ProveedorForm extends Form
{
/**
 * 
 */
     
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('proveedor');
        

    
        // We will ignore the name provided to the constructor
         //parent::__construct('conductor');

        $this->add([
            'name' => 'Cod_Proveedor',
            'type' => 'hidden',
        ]);

        
        $this->add([
            'name' => 'Nombre_Proveedor',
            'type' => 'text',
            'options' => [
                'label' => 'Proveedor',
            ],
        ]);

        $this->add([
            'name' => 'Direccion_Proveedor',
            'type' => 'text',
            'options' => [
                'label' => 'Dirección',
            ],
        ]);

        $this->add([
            'name' => 'Telefono_Proveedor',
            'type' => 'text',
            'options' => [
                'label' => 'Teléfono',
            ],
        ]);
        $this->add([
            'name' => 'RTN_Proveedor',
            'type' => 'text',
            'options' => [
                'label' => 'RTN',
            ],
        ]);
         
         $this->add([
            'name' => 'Cai_Proveedor',
            'type' => 'text',
            'options' => [
                'label' => 'C.A.I',
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