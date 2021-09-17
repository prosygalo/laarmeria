<?php
namespace Boletacompra\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Date;

class BoletacompraForm extends Form
{
 /**Este form  proporciona un conjunto de elementos especializados para realizar tareas de  recolección de  datos necesarios  para la emision de las boletas. Estos incluyen varios elementos de entrada HTML5 con validadores del lado del servidor.
*
*/
    public function __construct($name = null)
    {
        // Ignorar el nombre que provee el constructor
        parent::__construct('boletas');
        //Listado de elementos agregados al formulario

        //Agregar entrada  Código de boleta
        $Cod_Boleta_Compra = new Element\Text('Cod_Boleta_Compra');
        $Cod_Boleta_Compra->setAttribute('type','hidden');
        $this->add($Cod_Boleta_Compra);

        //Agregar entada  fecha de emisión
        $Fecha_Emision = new Element\Text('Fecha_Emision');
        $Fecha_Emision->setAttribute('type','text');
        $Fecha_Emision->setLabel("Fecha emisión");
        $Fecha_Emision->setAttribute('class', 'form-control autofocus');
        $Fecha_Emision->setAttribute('readonly', 'readonly');
        $Fecha_Emision->setAttribute('required', 'required');
        $this->add($Fecha_Emision);

        //Agregar entrada Consecutivo Actual establecimiento 
        $Consecutivo_Actual_Establ = new Element\Text('Consecutivo_Actual_Establ');
        $Consecutivo_Actual_Establ->setAttribute('class', 'form-control');
        $Consecutivo_Actual_Establ->setLabel("Establ");
        $Consecutivo_Actual_Establ->setAttribute('placeholder', '000');
        $Consecutivo_Actual_Establ->setAttribute('readonly', 'readonly');
        $Consecutivo_Actual_Establ->setAttribute('required', 'required');
        $this->add($Consecutivo_Actual_Establ);

        //Agregar entrada consecutivo actual punto
        $Consecutivo_Actual_Punto = new Element\Text('Consecutivo_Actual_Punto');
        $Consecutivo_Actual_Punto->setAttribute('class', 'form-control');
        $Consecutivo_Actual_Punto->setLabel("Punto");
        $Consecutivo_Actual_Punto->setAttribute('placeholder', '000');
        $Consecutivo_Actual_Punto->setAttribute('readonly', 'readonly');
        $Consecutivo_Actual_Punto->setAttribute('required', 'required');
        $this->add($Consecutivo_Actual_Punto);

        //Agregar entrada consecutivo actual  tipo
        $Consecutivo_Actual_Tipo = new Element\Text('Consecutivo_Actual_Tipo');
        $Consecutivo_Actual_Tipo->setAttribute('class', 'form-control');
        $Consecutivo_Actual_Tipo->setLabel("Tipo");
        $Consecutivo_Actual_Tipo->setAttribute('placeholder', '00');
        $Consecutivo_Actual_Tipo->setAttribute('readonly', 'readonly');
        $Consecutivo_Actual_Tipo->setAttribute('required', 'required');
        $this->add($Consecutivo_Actual_Tipo);

         //Agregar consecutivo actual correlativo
        $Consecutivo_Actual_Correlativo = new Element\Text('Consecutivo_Actual_Correlativo');
        $Consecutivo_Actual_Correlativo->setAttribute('class', 'form-control');
        $Consecutivo_Actual_Correlativo->setLabel("Correlativo");
        $Consecutivo_Actual_Correlativo->setAttribute('placeholder', '00000000');
        $Consecutivo_Actual_Correlativo->setAttribute('readonly', 'readonly');
        $Consecutivo_Actual_Correlativo->setAttribute('required', 'required');
        $this->add($Consecutivo_Actual_Correlativo);


        //Agregar entrada Autorización de la SAR
        $Autorizacion_Sar = new Element\Text('Autorizacion_Sar');
        $Autorizacion_Sar->setAttribute('class','form-control');
        $Autorizacion_Sar->setAttribute('required','required');
        $Autorizacion_Sar->setLabel('Código Autorización SAR');
        $this->add($Autorizacion_Sar);

         //Agregar ojeto de selección Sucursales
        $Sucursal = new Element\Text('Sucursal');
        $Sucursal->setAttribute('name', 'Sucursal');
        $Sucursal->setAttribute('class', 'form-control');
        $Sucursal->setAttribute('required', 'required');
        $Sucursal->setAttribute('id', 'Sucursal');
        $Sucursal->setLabel('Sucursal');
        $this->add($Sucursal);
         

        //Agregar entrada Usuario que registra la boleta generada
        $Usuario = new Element\Text('Usuario');
        $Usuario->setAttribute('class','form-control');
        $Usuario->setAttribute('required','required');
        $Usuario->setLabel('Usuario');
        $Usuario->setAttribute('readonly','readonly');
        $this->add($Usuario);

        //Agregar entrada codigo de proveedor
        $Cod_Proveedor = new Element\Hidden('Cod_Proveedor');
        $Cod_Proveedor->setAttribute('class','form-control');
        $Cod_Proveedor->setAttribute('required','required');
        $Cod_Proveedor->setLabel('Cod_Proveedor');
        $this->add($Cod_Proveedor);

        //Agregar entrada Nombre de proveedor
        $Nombre_Proveedor = new Element\Text('Nombre_Proveedor');
        $Nombre_Proveedor->setAttribute('class','form-control');
        $Nombre_Proveedor->setAttribute('required','required');
        $Nombre_Proveedor->setLabel('Proveedor');
        $this->add($Nombre_Proveedor);

        //Agregar entrada Dirección de proveedor
        $Direccion = new Element\Text('Direccion');
        $Direccion->setAttribute('class','form-control');
        $Direccion->setAttribute('required','required');
        $Direccion->setLabel('Dirección');
        $this->add($Direccion);

        //Agregar entrada RTN/DNI  proveedor
        $RTN_Proveedor = new Element\Text('RTN_Proveedor');
        $RTN_Proveedor->setAttribute('class','form-control');
        $RTN_Proveedor->setAttribute('required','required');
        $RTN_Proveedor->setLabel('RTN/DNI');
        $this->add($RTN_Proveedor);

        //Agregar entrada RTN/DNI  proveedor
        $Telefono = new Element\Text('Telefono');
        $Telefono->setAttribute('class','form-control');
        $Telefono->setAttribute('required','required');
        $Telefono->setLabel('Teléfono');
        $this->add($Telefono);

     
     /*   $Cod_Detalle_Compra = new Element\Text('Cod_Detalle_Compra');
        $Cod_Detalle_Compra->setAttribute('type','hidden');
        $this->add($Cod_Detalle_Compra);
    
        $Cod_Producto = new Element\Text('Cod_Producto');
        $Cod_Producto->setAttribute('class', 'form-control codigo');
        $Cod_Producto->setAttribute('id','Cod_Producto');
        $this->add($Cod_Producto);
     
        $Nombre_Producto = new Element\Text('Nombre_Producto');
        $Nombre_Producto->setAttribute('class', 'form-control codigo');
        $Nombre_Producto->setAttribute('id','Nombre_Producto');
        $this->add($Nombre_Producto);
        
        
        //Agregar entada  fecha de emisión
        $Cantidad = new Element\Text('Cantidad');
        $Cantidad ->setAttribute('class', 'form-control autofocus cant');
        $Cantidad->setAttribute('id','Cantidad');
        $Cantidad->setAttribute('maxlength','3');
        $Cantidad->setAttribute('onkeypress','return int(event)');
        $this->add($Cantidad);*/
        
        //Agregar botón de agregar productos a la tabla
        $Agregar = new Element\Button('agregar');
        $Agregar->setLabel("Agregar  productos a la lista");
        $Agregar->setAttribute('type','button');
        $Agregar->setAttribute('id','agregar');
        $Agregar->setAttribute('class', 'btn btn-success btn-block blo');
        $Agregar->setAttribute('data-toggle', 'modal');
        $Agregar->setAttribute('data-target', '#myModal');
        $this->add($Agregar);

        //Agregar botón submit
        $enviar = new Element\Button('enviar');
        $enviar->setLabel("Enviar");
        $enviar->setAttribute('type','submit');
        $enviar->setAttribute('id','enviar');
        $enviar->setAttribute('class', 'btn btn-primary btn-block');
        $this->add($enviar);
        
        //Agregar botón submit
        $submit = new Element\Button('submit');
        $submit->setLabel("Guardar");
        $submit->setAttribute('type','button');
        $submit->setAttribute('id','submit');
        $submit->setAttribute('class', 'btn btn-primary btn-block');
        $submit->setAttribute('disabled','disabled');
        $this->add($submit);
    }

     
}