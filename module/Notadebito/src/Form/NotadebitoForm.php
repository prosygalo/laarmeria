<?php
namespace Notadebito\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Date;

class NotadebitoForm extends Form
{
 /**Este form  proporciona un conjunto de elementos especializados para realizar tareas de  recolección de  datos necesarios  para la emision de las boletas. Estos incluyen varios elementos de entrada HTML5 con validadores del lado del servidor.
*
*/
    public function __construct($name = null)
    {
        // Ignorar el nombre que provee el constructor
        parent::__construct('notadebito');
        //Listado de elementos agregados al formulario

        //Agregar entrada  Código de boleta
        $Cod_Nota = new Element\Text('Cod_Nota');
        $Cod_Nota->setAttribute('type','hidden');
        $this->add($Cod_Nota);

        //Agregar entada  fecha de emisión
        $Fecha_Emision = new Element\Text('Fecha_Emision');
        $Fecha_Emision->setAttribute('type','text');
        $Fecha_Emision->setLabel('Fecha Emisión');
        $Fecha_Emision->setAttribute('class', 'form-control');
        $Fecha_Emision->setAttribute('readonly', 'readonly');
        $Fecha_Emision->setAttribute('required', 'required');
        $this->add($Fecha_Emision);

         //Agregar entada  fecha de emisión
        $Fecha_Emision_Comprobante = new Element\Text('Fecha_Emision_Comprobante');
        $Fecha_Emision_Comprobante->setAttribute('type','text');
        $Fecha_Emision_Comprobante->setAttribute('id','Fecha_Emision_Comprobante');
        $Fecha_Emision_Comprobante->setLabel('Fecha Emisión del Comprobante');
        $Fecha_Emision_Comprobante->setAttribute('class', 'form-control');
        $Fecha_Emision_Comprobante->setAttribute('required', 'required');
        $this->add($Fecha_Emision_Comprobante);

        //Agregar entrada 
        $Cai_Comprobante = new Element\Text('Cai_Comprobante');
        $Cai_Comprobante->setAttribute('class','form-control text-center');
        $Cai_Comprobante->setAttribute('id','Cai_Comprobante');
        $Cai_Comprobante->setAttribute('required','required');
        $Cai_Comprobante->setLabel('C.A.I');
        $this->add($Cai_Comprobante);

        //Agregar entrada 
        $No_Correlativo = new Element\Text('No_Correlativo');
        $No_Correlativo->setAttribute('class','form-control text-center');
        $No_Correlativo->setAttribute('required','required');
        $No_Correlativo->setAttribute('maxlength','19');
        $No_Correlativo->setLabel('No. de Correlativo');
        $this->add($No_Correlativo);


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
        $Autorizacion_Sar->setLabel('Autorización SAR');
        $this->add($Autorizacion_Sar);

         //Agregar ojeto de selección Sucursales
        $Sucursal = new Element\Text('Sucursal');
        $Sucursal->setAttribute('name', 'Sucursal');
        $Sucursal->setAttribute('class', 'form-control');
        $Sucursal->setAttribute('required', 'required');
        $Sucursal->setAttribute('id', 'Sucursal');
        $Sucursal->setLabel('Sucursal');
        $this->add($Sucursal);

        //Agregar entrada Motivo 
        $Motivo = new Element\Text('Motivo');
        $Motivo->setAttribute('class','form-control');
        $Motivo->setAttribute('required','required');
        $Motivo->setLabel('Motivo');
        $this->add($Motivo);
        
        //Agregar objeto de selección productos
        $productos = new Element\Select('productos');
        $productos->setAttribute('id', 'pro_id');
        $productos->setAttribute('style', 'cursor:pointer');
        $productos->setAttribute('data-width', '100%');
        $productos->setAttribute('data-live-search', 'true');
        $productos->setAttribute('class', 'form-control selectpicker  pro_id'); 
        $this->add($productos);

        //Agregar entrada Usuario que registra la boleta generada
        $Usuario = new Element\Text('Usuario');
        $Usuario->setAttribute('class','form-control');
        $Usuario->setAttribute('required','required');
        $Usuario->setLabel('Usuario');
        $Usuario->setAttribute('readonly','readonly');
        $this->add($Usuario);

         //Agregar campo total
        $Cantidad_Letras= new Element\Text('Cantidad_Letras');
        $Cantidad_Letras->setAttribute('class', 'form-control');
        $Cantidad_Letras->setAttribute('readonly','readonly');
        $Cantidad_Letras->setAttribute('onFocus','this.blur()');
        $this->add($Cantidad_Letras);

        //Agregar campo total del detalle y reporte
        $TotalView = new Element\Text('TotalView');
        $TotalView->setAttribute('class', 'form-control text-right');
        $TotalView->setLabel('Total');
        $TotalView->setAttribute('id','TotalView');
        $TotalView->setAttribute('readonly','readonly');
        $TotalView->setAttribute('onFocus','this.blur()');
        $this->add($TotalView);

        //Agregar campo total del detalle y reporte
        $IsvView = new Element\Text('IsvView');
        $IsvView->setAttribute('class', 'form-control text-right');
        $IsvView->setLabel('15% I.S.V.');
        $IsvView->setAttribute('id','IsvView');
        $IsvView->setAttribute('readonly','readonly');
        $IsvView->setAttribute('onFocus','this.blur()');
        $this->add($IsvView);

        //Agregar campo total del detalle y reporte
        $GravadoView = new Element\Text('GravadoView');
        $GravadoView->setAttribute('class', 'form-control text-right');
        $GravadoView->setLabel('Importe Gravado');
        $GravadoView->setAttribute('id','GravadoView');
        $GravadoView->setAttribute('readonly','readonly');
        $GravadoView->setAttribute('onFocus','this.blur()');
        $this->add($GravadoView);

        //Agregar campo total del detalle y reporte
        $ExentoView = new Element\Text('ExentoView');
        $ExentoView->setAttribute('class', 'form-control text-right');
        $ExentoView->setLabel('Importe Exento');
        $ExentoView->setAttribute('id','ExentoView');
        $ExentoView->setAttribute('readonly','readonly');
        $ExentoView->setAttribute('onFocus','this.blur()');
        $this->add($ExentoView);

        //Agregar campo total del detalle y reporte
        $ExoneradoView = new Element\Text('ExoneradoView');
        $ExoneradoView->setAttribute('class', 'form-control text-right');
        $ExoneradoView->setLabel('Importe Exonerado ');
        $ExoneradoView->setAttribute('id','ExoneradoView');
        $ExoneradoView->setAttribute('readonly','readonly');
        $ExoneradoView->setAttribute('onFocus','this.blur()');
        $this->add($ExoneradoView);

        
        //Agregar campo total
        $Total = new Element\hidden('Total');
        $Total->setAttribute('id','total');
        $Total->setAttribute('readonly','readonly');
        $Total->setAttribute('onFocus','this.blur()');
        $this->add($Total);

        //Agregar campo 
        $Isv = new Element\hidden('Isv');
        $Isv->setAttribute('class', 'form-control text-right');
        $Isv->setLabel('Isvl');
        $Isv->setAttribute('id','isv');
        $Isv->setAttribute('readonly','readonly');
        $Isv->setAttribute('onFocus','this.blur()');
        $this->add($Isv);

        //Agregar campo 
        $Exonerado = new Element\hidden('Exonerado');
        $Exonerado->setAttribute('class', 'form-control text-right');
        $Exonerado->setLabel('Isvl');
        $Exonerado->setAttribute('id','exonerado');
        $Exonerado->setAttribute('readonly','readonly');
        $Exonerado->setAttribute('onFocus','this.blur()');
        $this->add($Exonerado);

        //Agregar campo 
        $Exento = new Element\hidden('Exento');
        $Exento->setAttribute('class', 'form-control text-right');
        $Exento->setLabel('Exento');
        $Exento->setAttribute('id','exento');
        $Exento->setAttribute('readonly','readonly');
        $Exento->setAttribute('onFocus','this.blur()');
        $this->add($Exento);

        //Agregar campo 
        $Gravado = new Element\hidden('Gravado');
        $Gravado->setAttribute('class', 'form-control text-right');
        $Gravado->setLabel('Gravado');
        $Gravado->setAttribute('id','gravado');
        $Gravado->setAttribute('readonly','readonly');
        $Gravado->setAttribute('onFocus','this.blur()');
        $this->add($Gravado);
       
        //Agregar entrada codigo de proveedor
        $Cliente = new Element\Select('Cliente');
        $Cliente->setAttribute('class','form-control');
        $Cliente->setAttribute('required','required');
        $Cliente->setEmptyOption('Seleccione');
        $Cliente->setDisableInArrayValidator(true);
        $Cliente->setAttribute('id','Cliente');
        $Cliente->setLabel('Cliente');
        $this->add($Cliente);

        //-----Datos de Proveedor
        $Nombres_Cliente = new Element\Text('Nombres_Cliente');
        $Nombres_Cliente->setAttribute('class','form-control');
        $Nombres_Cliente->setAttribute('required','required');
        $Nombres_Cliente->setAttribute('id','Nombres_Cliente');
        $Nombres_Cliente->setLabel('Cliente');
        $this->add($Nombres_Cliente);


        //Agregar entrada RTN/DNI  proveedor
        $RTN_DNI = new Element\Select('RTN_DNI');
        $RTN_DNI->setAttribute('class','form-control');
        $RTN_DNI->setEmptyOption('Seleccione');
        $RTN_DNI->setAttribute('id','RTN_DNI');
        $RTN_DNI->setAttribute('required','required');
        $RTN_DNI->setLabel('RTN/DNI');
        $this->add($RTN_DNI);

        $RTN_View = new Element\Text('RTN_View');
        $RTN_View->setAttribute('class','form-control text-center');
        $RTN_View->setAttribute('id','RTN_Proveedor');
        $RTN_View->setAttribute('required','required');
        $RTN_View->setLabel('RTN');
        $this->add($RTN_View);


        $Agregar = new Element\Button('Agregar');
        $Agregar->setLabel("Agregar");
        $Agregar->setAttribute('type','button');
        $Agregar->setAttribute('id','blo');
        $Agregar->setAttribute('onclick','agregarProducto()');
        $Agregar->setAttribute('class', 'btn btn-success btn-block blo');
        $this->add($Agregar);


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
        $submit->setAttribute('disabled','disabled');
        $this->add($submit);
    }

     
}