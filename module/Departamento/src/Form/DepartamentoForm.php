<?php
namespace Departamento\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class DepartamentoForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('departamento');

        $this->add([
            'name' => 'Cod_Departamento',
            'type' => 'text',
            'options' => [
                'label' => 'Código de departamento',
            ],
        ]);
       
        $this->add([
            'name' => 'Nombre_Depto',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre',
            ],
        ]);

        $Sucursal = new Element\Select('Sucursal');
        $Sucursal->setAttribute('name', 'Sucursal');
        $Sucursal->setAttribute('id', 'Sucursal');
        $Sucursal->setLabel('Sucursal');
        $Sucursal->setEmptyOption('Seleccione'); 
        $this->add($Sucursal);

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