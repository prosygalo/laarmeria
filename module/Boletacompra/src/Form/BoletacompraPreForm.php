<?php
namespace Boletacompra\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Date;

class BoletacompraPreForm extends Form
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
        $Sucursal = new Element\Select('Sucursal');
        $Sucursal->setAttribute('name', 'Sucursal');
        $Sucursal->setAttribute('id', 'Sucursal');
        $Sucursal->setLabel('Sucursal');
        $Sucursal->setEmptyOption('Seleccione');
        $Sucursal->setAttribute('class', 'form-control');
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