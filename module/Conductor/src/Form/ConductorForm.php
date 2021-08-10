<?php
namespace Conductor\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class ConductorForm extends Form
{
/**
 * 
 */
     
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('conductor');
        

    
        // We will ignore the name provided to the constructor
         //parent::__construct('conductor');

        $this->add([
            'name' => 'Cod_Conductor',
            'type' => 'text',
            'options' => [
                'label' => 'Código de conductor',
            ],
        ]);

        
        $this->add([
            'name' => 'Nombres_Conductor',
            'type' => 'text',
            'options' => [
                'label' => 'Nombres',
            ],
        ]);

          $this->add([
            'name' => 'Apellidos_Conductor',
            'type' => 'text',
            'options' => [
                'label' => 'Apellidos',
            ],
        ]);
         $this->add([
            'name' => 'Dni',
            'type' => 'text',
            'options' => [
                'label' => 'Documento Nacional de Identificación(DNI)',
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
                       'No disponible' => 'No disponible',
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