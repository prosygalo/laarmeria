<?php
namespace Cliente\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class ClienteForm extends Form
{
/**
 * 
 */
     
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('cliente');
        

    
        // We will ignore the name provided to the constructor
         //parent::__construct('conductor');

        $this->add([
            'name' => 'Cod_Cliente',
            'type' => 'hidden',
        ]);

        
        $this->add([
            'name' => 'Nombres_Cliente',
            'type' => 'text',
            'options' => [
                'label' => 'Nombres',
            ],
        ]);

          $this->add([
            'name' => 'Apellidos_Cliente',
            'type' => 'text',
            'options' => [
                'label' => 'Apellidos',
            ],
        ]);
         $this->add([
            'name' => 'Rtn_Dni',
            'type' => 'text',
            'options' => [
                'label' => 'RTN/Documento de Identificación',
            ],
            'attributes' => [
                'maxlength' => '14',
                'id'    => 'RTN_DNI',
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