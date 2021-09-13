<?php
namespace Tipodocumento\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class TipodocumentoForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('tipodocumento');

        $this->add([
            'name' => 'Cod_Documento',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'Nombre_Documento',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre de documento',
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