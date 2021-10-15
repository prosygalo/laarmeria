<?php
namespace Boletasremision\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Date;

class BoletasremisionForm extends Form
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
        $Cod_Boleta = new Element\Text('Cod_Boleta');
        $Cod_Boleta->setAttribute('type','hidden');
        $this->add($Cod_Boleta);

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

        //Agregar entrada motivo de traslado
        $Motivo_Traslado = new Element\Select('Motivo_Traslado');
        $Motivo_Traslado->setAttribute('class','form-control');
        $Motivo_Traslado->setEmptyOption('Seleccione');
        $Motivo_Traslado->setAttribute('required','required');
        $Motivo_Traslado->setLabel('Motivo traslado');
        $Motivo_Traslado->setValueOptions([
            'Venta'=>'Venta',
            'Consignación'=>'Consignación',
            'Exportación'=>'Exportación',
            'Importación'=>'Importación',
            'Compra'=>'Compra',
            'Devolución'=>'Devolución',
            'Exhibición o Demostración'=>'Exhibición o Demostración',
            'Traslado de bienes para reparación'=>'Traslado de bienes para reparación',
            'Traslado entre establecimento'=>'Traslado entre establecimiento',
            'Traslado de bienes de trasformación'=>'Traslado de bienes de trasformación',
            'Traslado por venta emisor móvil'=>'Traslado por venta emisor móvil',
            'participación en ferias'=>'participación en ferias',
        ]);   
         $this->add($Motivo_Traslado);


        //Agregar entrada número de transferencia
        $Num_Transferencia = new Element\Text('Num_Transferencia');
        $Num_Transferencia->setAttribute('class','form-control');
        $Num_Transferencia->setLabel('Número transferencia');
        $Num_Transferencia->setAttribute('onkeypress','return int(event)');
        $Num_Transferencia->setAttribute('maxlength','10');
        $Num_Transferencia->setAttribute('required','required');
        $this->add($Num_Transferencia);

        //Agregar ojeto de selección Sucursales
        $Sucursal_Remitente = new Element\Text('Sucursal_Remitente');
        $Sucursal_Remitente->setAttribute('name', 'Sucursal_Remitente');
        $Sucursal_Remitente->setAttribute('class', 'form-control');
        $Sucursal_Remitente->setAttribute('required', 'required');
        $Sucursal_Remitente->setAttribute('id', 'Sucursal_Remitente');
        $Sucursal_Remitente->setLabel('Remitente');
        $this->add($Sucursal_Remitente);


        //Agregar ojeto de selección Sucursales
        $Sucursal_Destino = new Element\Select('Sucursal_Destino');
        $Sucursal_Destino->setAttribute('name', 'Sucursal_Destino');
        $Sucursal_Destino->setEmptyOption('Seleccione');
        $Sucursal_Destino->setAttribute('class', 'form-control');
        $Sucursal_Destino->setAttribute('required', 'required');
        $Sucursal_Destino->setAttribute('id', 'Sucursal_Destino');
        $Sucursal_Destino->setLabel('Destinatario');
        $this->add($Sucursal_Destino);
        
        //Agregar entrada punto de partida
        $Punto_Partida = new Element\Text('Punto_Partida');
        $Punto_Partida->setAttribute('class','form-control');
        $Punto_Partida->setAttribute('required','required');
        $Punto_Partida->setLabel('Punto partida');
        $this->add($Punto_Partida);

       //Agregar entrada Punto de destino
        $Punto_Destino = new Element\Select('Punto_Destino');
        $Punto_Destino->setAttribute('class','form-control');
        $Punto_Destino->setAttribute('required','required');
        $Punto_Destino->setLabel('Punto destino');
        $Punto_Destino->setEmptyOption('Seleccione');
        $this->add($Punto_Destino);

        //Agregar entrada fecha inicial de traslado
        $Fecha_Inicio_Traslado = new Element\Text('Fecha_Inicio_Traslado');
        $Fecha_Inicio_Traslado->setLabel('Fecha inicio de traslado');
        $Fecha_Inicio_Traslado->setAttribute('class','form-control');
        $Fecha_Inicio_Traslado->setAttribute('required','required');
        $Fecha_Inicio_Traslado->setAttribute('id','Fecha_Inicio_Traslado');
        $this->add($Fecha_Inicio_Traslado);

        //Agregar entrada fecha final de traslado
        $Fecha_Final_Traslado = new Element\Text('Fecha_Final_Traslado');
        $Fecha_Final_Traslado->setLabel('Fecha final de traslado');
        $Fecha_Final_Traslado->setAttribute('class','form-control');
        $Fecha_Final_Traslado->setAttribute('required','required');
        $Fecha_Final_Traslado->setAttribute('id','Fecha_Final_Traslado');
        $this->add($Fecha_Final_Traslado);


        //Agregar entrada Autorización de la SAR
        $Autorizacion_Sar = new Element\Text('Autorizacion_Sar');
        $Autorizacion_Sar->setAttribute('class','form-control');
        $Autorizacion_Sar->setAttribute('required','required');
        $Autorizacion_Sar->setLabel('Código Autorización SAR');
        $this->add($Autorizacion_Sar);
         

        //Agregar entrada Usuario que registra la boleta generada
        $Usuario = new Element\Text('Usuario');
        $Usuario->setAttribute('class','form-control');
        $Usuario->setAttribute('required','required');
        $Usuario->setLabel('Usuario');
        $Usuario->setAttribute('readonly','readonly');
        $this->add($Usuario);
         
        //Agregar objeto de selección productos
        $productos = new Element\Select('productos');
        $productos->setAttribute('id', 'pro_id');
        $productos->setAttribute('data-width', '100%');
        $productos->setAttribute('data-live-search', 'true');
        $productos->setAttribute('class', 'form-control selectpicker  pro_id'); 
        $this->add($productos);
    


        //Agregar objeto de selección Unidades de transporte
        $Unidad_Transporte = new Element\Select('Unidad_Transporte');
        $Unidad_Transporte->setAttribute('name', 'Unidad_Transporte');
        $Unidad_Transporte->setAttribute('class', 'form-control autofocus');
        $Unidad_Transporte->setAttribute('required', 'required');
        $Unidad_Transporte->setAttribute('id', 'Unidad_Transporte');
        $Unidad_Transporte->setLabel('Unidad transporte');
        $Unidad_Transporte->setEmptyOption('Seleccione'); 
        $this->add($Unidad_Transporte);

        //Agregar obeto de selección conductores
        $Conductor = new Element\Select('Conductor');
        $Conductor->setAttribute('name', 'Conductor');
        $Conductor->setAttribute('class', 'form-control'); 
        $Conductor->setAttribute('required', 'required');
        $Conductor->setAttribute('id', 'Conductor');
        $Conductor->setLabel('Conductor');
        $Conductor->setEmptyOption('Seleccione');
        $this->add($Conductor);

        /*Agregar entrada  Código de detalle
        $Cod_Detalle = new Element\Text('Cod_Detalle');
        $Cod_Detalle->setAttribute('type','hidden');
        $this->add($Cod_Detalle);

    
        //Agregar entada
        $Cod_Producto = new Element\Text('Cod_Producto');
        $Cod_Producto->setAttribute('class', 'form-control codigo');
        $Cod_Producto->setAttribute('id','Cod_Producto');
        //$Cod_Producto->setAttribute('readonly', 'readonly');
        $this->add($Cod_Producto);
        
        //Agregar entada  fecha de emisión
        $Cantidad = new Element\Text('Cantidad');
        $Cantidad ->setAttribute('class', 'form-control autofocus cant');
        $Cantidad->setAttribute('id','Cantidad');
        $Cantidad->setAttribute('maxlength','3');
        $Cantidad->setAttribute('onkeypress','return int(event)');
        $this->add($Cantidad);*/


        $Cod_Detalle = new Element\Text('Cod_Detalle');
        $Cod_Detalle->setAttribute('type','hidden');
        $this->add($Cod_Detalle);

        $Cancelar = new Element\Button('Cancelar');
        $Cancelar->setLabel("Cancelar");
        $Cancelar->setAttribute('type','button');
        $Cancelar->setAttribute('onclick','cancelar()');
        $Cancelar->setAttribute('class', 'btn btn-danger btn-block');
        $this->add($Cancelar);
        
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