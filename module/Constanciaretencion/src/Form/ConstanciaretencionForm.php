<?php
namespace Constanciaretencion\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Date;

class ConstanciaretencionForm extends Form
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
        $Cod_Constancia = new Element\Text('Cod_Constancia');
        $Cod_Constancia->setAttribute('type','hidden');
        $this->add($Cod_Constancia);


        //Agregar entada  fecha de emisión
        $Fecha_Emision = new Element\Text('Fecha_Emision');
        $Fecha_Emision->setAttribute('type','text');
        $Fecha_Emision->setLabel("Fecha emisión");
        $Fecha_Emision->setAttribute('class', 'form-control autofocus');
        $Fecha_Emision->setAttribute('readonly', 'readonly');
        $Fecha_Emision->setAttribute('required', 'required');
        $this->add($Fecha_Emision);

        //Agregar ojeto de selección Sucursales
        $Sucursal = new Element\Text('Sucursal');
        $Sucursal->setAttribute('name', 'Sucursal');
        $Sucursal->setAttribute('class', 'form-control');
        $Sucursal->setAttribute('required', 'required');
        $Sucursal->setAttribute('id', 'Sucursal');
        $Sucursal->setLabel('Sucursal');
        $this->add($Sucursal);


        //Agregar entrada Autorización de la SAR
        $Autorizacion_Sar = new Element\Text('Autorizacion_Sar');
        $Autorizacion_Sar->setAttribute('class','form-control');
        $Autorizacion_Sar->setAttribute('required','required');
        $Autorizacion_Sar->setLabel('Autorización SAR');
        $this->add($Autorizacion_Sar);
         

        $Tipo_Retencion = new Element\Radio('Tipo_Retencion');
        $Tipo_Retencion->setLabel('Retención');
        $Tipo_Retencion->setAttribute('class','form-check-inline');
        $Tipo_Retencion->setValueOptions([
           '1' =>'1%',
           '2' =>'12.50%',
            ]);
        $this->add($Tipo_Retencion);

        //Agregar entada  
        $Base_Gravable_Impuesto = new Element\Text('Base_Gravable_Impuesto');
        $Base_Gravable_Impuesto->setAttribute('type','text');
        $Base_Gravable_Impuesto->setLabel("Base Gravable del Impuesto");
        $Base_Gravable_Impuesto->setAttribute('class', 'form-control autofocus');
        $Base_Gravable_Impuesto->setAttribute('required', 'required');
        $this->add($Base_Gravable_Impuesto);


        //Agregar entrada  
        $Importe_Retencion = new Element\Text('Importe_Retencion');
        $Importe_Retencion->setAttribute('type','text');
        $Importe_Retencion->setLabel("Importe de Retencion");
        $Importe_Retencion->setAttribute('class', 'form-control autofocus');
        $Importe_Retencion->setAttribute('required', 'required');
        $this->add($Importe_Retencion);

        //Agregar entrada 
        $Documento_Retencion = new Element\Text('Documento_Retencion');
        $Documento_Retencion->setAttribute('type','text');
        $Documento_Retencion->setLabel("Documento sobre el cual se retuvo");
        $Documento_Retencion->setAttribute('class', 'form-control autofocus');
        $Documento_Retencion->setAttribute('required', 'required');
        $this->add($Documento_Retencion);



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


        //Agregar entrada Usuario que registra la boleta generada
        $Proveedor= new Element\Select('Proveedor');
        $Proveedor->setAttribute('class','form-control');
        $Proveedor->setAttribute('required','required');
        $Proveedor->setLabel('Proveedor');
        $Proveedor->setAttribute('readonly','readonly');
        $this->add($Proveedor);

         //Agregar entrada Usuario que registra la boleta generada
        $Direccion_Proveedor= new Element\Select('Direccion_Proveedor');
        $Direccion_Proveedor->setAttribute('class','form-control');
        $Direccion_Proveedor->setAttribute('required','required');
        $Direccion_Proveedor->setLabel('Dirección Proveedor');
        $Direccion_Proveedor->setAttribute('readonly','readonly');
        $this->add($Direccion_Proveedor);
        
        //Agregar entrada 
        $No_Correlativo = new Element\Text('No_Correlativo');
        $No_Correlativo->setAttribute('class','form-control');
        $No_Correlativo->setAttribute('required','required');
        $No_Correlativo->setLabel('No. de Correlativo');
        $this->add($No_Correlativo);

       //Agregar entrada 
        $RTN_Proveedor= new Element\Text('RTN_Proveedor');
        $RTN_Proveedor->setAttribute('class','form-control');
        $RTN_Proveedor->setAttribute('required','required');
        $RTN_Proveedor->setLabel('RTN');
        $this->add($RTN_Proveedor);


       //Agregar entrada 
        $Cai_Documento = new Element\Text('Cai_Documento');
        $Cai_Documento->setAttribute('class','form-control');
        $Cai_Documento->setAttribute('required','required');
        $Cai_Documento->setLabel('C.A.I');
        $this->add($Cai_Documento);

         //Agregar entrada 
        $Descripcion_Tributo_Retenido = new Element\Text('Descripcion_Tributo_Retenido');
        $Descripcion_Tributo_Retenido->setAttribute('class','form-control');
        $Descripcion_Tributo_Retenido->setAttribute('required','required');
        $Descripcion_Tributo_Retenido->setLabel('Descripción del Tributo Retenido');
        $this->add($Descripcion_Tributo_Retenido);


        //Agregar entrada Usuario que registra la boleta generada
        $Usuario = new Element\Text('Usuario');
        $Usuario->setAttribute('class','form-control');
        $Usuario->setAttribute('required','required');
        $Usuario->setLabel('Usuario');
        $Usuario->setAttribute('readonly','readonly');
        $this->add($Usuario);
    

        $Cancelar = new Element\Button('Cancelar');
        $Cancelar->setLabel("Cancelar");
        $Cancelar->setAttribute('type','button');
        $Cancelar->setAttribute('onclick','cancelar()');
        $Cancelar->setAttribute('class', 'btn btn-danger btn-block');
        $this->add($Cancelar);


        //Agregar botón submit
        $submit = new Element\Button('submit');
        $submit->setLabel("Guardar");
        $submit->setAttribute('type','button');
        $submit->setAttribute('id','submit');
        $submit->setAttribute('class', 'btn btn-primary btn-block');
        $this->add($submit);

     }
}