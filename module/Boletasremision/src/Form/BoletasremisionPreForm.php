<?php
namespace Boletasremision\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Date;

class BoletasremisionPreForm extends Form
{
 /**Este form  proporciona un conjunto de elementos especializados para realizar tareas de  recolección de  datos necesarios  para la emision de las boletas. Estos incluyen varios elementos de entrada HTML5 con validadores del lado del servidor.
*
*/
    public function __construct($name = null)
    {
        // Ignorar el nombre que provee el constructor
        parent::__construct('boletas');
        //Listado de elementos agregados al formulario

        //Agregar ojeto de selección Sucursales
        $Sucursal_Remitente = new Element\Select('Sucursal_Remitente');
        $Sucursal_Remitente->setAttribute('name', 'Sucursal_Remitente');
        $Sucursal_Remitente->setAttribute('id', 'Sucursal');
        $Sucursal_Remitente->setLabel('Sucursal');
        $Sucursal_Remitente->setEmptyOption('Seleccione');
        $Sucursal_Remitente->setAttribute('class', 'form-control');
        $this->add($Sucursal);



        //Agregar botón submit
        $enviar = new Element\Button('enviar');
        $enviar->setLabel("Enviar");
        $enviar->setAttribute('type','submit');
        $enviar->setAttribute('id','enviar');
        $enviar->setAttribute('class', 'btn btn-success btn-block');
        $this->add($enviar);
     }

}