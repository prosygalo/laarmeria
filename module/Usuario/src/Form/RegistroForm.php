<?php
namespace Usuario\Form;

use Zend\Form\Element;
use Zend\Form\Form;

/**
 * Este formulario para registrar el usuario.
 */
class RegistroForm extends Form
{ 
    /**
     * Constructor.     
     */
    public function __construct($name = null)
    {
        // Define el nombre del formulario 
        parent::__construct('registro');
        
        //Agregar campo Código de usuario
        $this->add([
            'name' => 'Cod_Usuario',
            'type' => 'hidden',   
        ]);

        //Agregar campo Código de empleado
        $this->add([
            'name' => 'Cod_Empleado',
            'type' => 'text',
            'options' => [
                'label' => 'Código de empleado',
            ],
        ]);
        //Agregar campo Sucursal
        $this->add([
            'type' => Element\Select::class,
            'name' => 'Sucursal',
            'options' => [
                'label' => 'Sucursal',
            ],
        ]);
        
        //Agregar campo Departamento
        $this->add([
            'type' => Element\Select::class,
            'name' => 'Departamento',
            'options' => [
                'label' => 'Departamento',
            ],
        ]);
        

        //Agregar campo Usuario
        $this->add([
            'name' => 'Usuario',
            'type' => 'text',
            'options' => [
                'label' => 'Usuario',
            ],
        ]);
         
        //Agregar campo Correo
        $this->add([
            'name' => 'Correo',
            'type' => 'text',
            'options' => [
                'label' => 'Correo electrónico',
            ],
        ]);

        //Agregar campo Clave
        $this->add([
            'name' => 'Clave',
            'type' => 'Password',
            'options' => [
                'label' => 'Contraseña',    
            ],
            'attributes' => [
                'size'  => '8',
            ]
        ]);

        //Agregar campo Confirmarclave
        $this->add([
            'name' => 'Confirmarclave',
            'type' => 'Password',
            'options' => [
                'label' => 'Repetir contraseña',
            ],
            'attributes' => [
                'size'  => '8',
            ]
        ]);

        //Agregar campo clave solo para vista de contraseña user admin
        $this->add([
            'name' => 'ClaveView',
            'type' => 'text',
            'options' => [
                'label' => 'Contraseña',
            ],
        ]);

        //Agregar campo Rol
        $this->add([
            'type' => Element\Select::class,
            'name' => 'Rol',
            'options' => [
                'label' => 'Rol',
                'value_options' => [ 
                      'Invitado'=>'Invitado',
                      'Miembro'   => 'Miembro',
                      'Especial'   => 'Especial',
               ],
            ],
        ]);
        
        //Agregar campo Estado
        $this->add([
            'type' => Element\Select::class,
            'name' => 'Estado',
            'options' => [
                'label' => 'Estado',
                'value_options' => [
                      'Activo' =>'Activo' , 
                      'Retirado' =>'Retirado' ,
              ],
            ],
        ]);
        
        //Agregar campo  submit
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