<?php
namespace Notadebito\Form;

use Zend\Form\Element;
use Zend\Form\Form;


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
        $Cod_Nota = new Element\Hidden('Cod_Nota');
        $this->add($Cod_Nota);

        //Agregar entada  fecha de emisión
        $Fecha_Emision = new Element\Text('Fecha_Emision');
        $Fecha_Emision->setLabel('Fecha Emisión');
        $Fecha_Emision->setAttribute('class', 'form-control');
        $Fecha_Emision->setAttribute('readonly', 'readonly');
        //$Fecha_Emision->setAttribute('required', 'required');
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
        //$Autorizacion_Sar->setAttribute('required','required');
        $Autorizacion_Sar->setLabel('Autorización SAR');
        $this->add($Autorizacion_Sar);

         //Agregar ojeto de selección Sucursales
        $Sucursal = new Element\Text('Sucursal');
        $Sucursal->setAttribute('name', 'Sucursal');
        $Sucursal->setAttribute('class', 'form-control');
        //$Sucursal->setAttribute('required', 'required');
        $Sucursal->setAttribute('id', 'Sucursal');
        $Sucursal->setLabel('Sucursal');
        $this->add($Sucursal);

         //Agregar entrada codigo de proveedor
        $Cliente = new Element\Select('Cliente');
        $Cliente->setAttribute('class','form-control');
        //$Cliente->setAttribute('required','required');
        $Cliente->setEmptyOption('Seleccione');
        $Cliente->setDisableInArrayValidator(true);
        $Cliente->setAttribute('id','Cliente');
        $Cliente->setLabel('Cliente');
        $this->add($Cliente);

         //Agregar entrada RTN/DNI  
        $RTN_DNI = new Element\Select('RTN_DNI');
        $RTN_DNI->setAttribute('class','form-control');
        $RTN_DNI->setEmptyOption('Seleccione');
        $RTN_DNI->setAttribute('id','RTN_DNI');
        //$RTN_DNI->setAttribute('required','required');
        $RTN_DNI->setLabel('RTN/DNI');
        $this->add($RTN_DNI);

        //-----Datos
        $Nombres_Cliente = new Element\Text('Nombres_Cliente');
        $Nombres_Cliente->setAttribute('class','form-control');
        $Nombres_Cliente->setAttribute('id','Nombres_Cliente');
        $Nombres_Cliente->setLabel('Cliente');
        $this->add($Nombres_Cliente);


        //Agregar entrada 
        $No_Correlativo = new Element\Text('No_Correlativo');
        $No_Correlativo->setAttribute('class','form-control');
        //$No_Correlativo->setAttribute('required','required');
        $No_Correlativo->setAttribute('maxlength','19');
        $No_Correlativo->setAttribute('onkeypress','return fac(event,this);');
        $No_Correlativo->setLabel('No. de Correlativo');
        $this->add($No_Correlativo);

        
        
         //Agregar entrada 
        $Cai_Comprobante = new Element\Text('Cai_Comprobante');
        $Cai_Comprobante->setAttribute('class','form-control');
        $Cai_Comprobante->setAttribute('id','Cai_Comprobante');
        $Cai_Comprobante->setAttribute('maxlength','37');
        $Cai_Comprobante->setAttribute('onkeypress','return ca(event,this)');
        //$Cai_Comprobante->setAttribute('required','required');
        $Cai_Comprobante->setLabel('C.A.I');
        $this->add($Cai_Comprobante);

         //Agregar entada  fecha de emisión
        $Fecha_Emision_Comprobante = new Element\Text('Fecha_Emision_Comprobante');
        $Fecha_Emision_Comprobante->setAttribute('id','Fecha_Emision_Comprobante');
        $Fecha_Emision_Comprobante->setLabel('Fecha Emisión del Comprobante');
        $Fecha_Emision_Comprobante->setAttribute('class', 'form-control');
        //$Fecha_Emision_Comprobante->setAttribute('required', 'required');
        $this->add($Fecha_Emision_Comprobante);


        //Agregar entrada Motivo 
        $Motivo = new Element\Text('Motivo');
        $Motivo->setAttribute('class','form-control');
        $Motivo->setAttribute('maxlength','100');
       // $Motivo->setAttribute('required','required');
        $Motivo->setLabel('Motivo');
        $this->add($Motivo);


        //Agregar entrada Usuario que registra la boleta generada
        $Usuario = new Element\Text('Usuario');
        $Usuario->setAttribute('class','form-control');
        //$Usuario->setAttribute('required','required');
        $Usuario->setLabel('Usuario');
        $Usuario->setAttribute('readonly','readonly');
        $this->add($Usuario);

        //Agregar objeto de selección productos
        $productos = new Element\Select('productos');
        $productos->setAttribute('id', 'pro_id');
        $productos->setAttribute('data-width', '100%');
        $productos->setAttribute('data-live-search', 'true');
        $productos->setAttribute('class', 'form-control custom-select selectpicker  pro_id'); 
        $this->add($productos);

        
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
        $TotalView->setAttribute('onFocus','this.blur()');
        $this->add($TotalView);

        //Agregar campo total del detalle y reporte
        $IsvView = new Element\Text('IsvView');
        $IsvView->setAttribute('class', 'form-control text-right');
        $IsvView->setLabel('15% I.S.V.');
        $IsvView->setAttribute('id','IsvView');
        $IsvView->setAttribute('onFocus','this.blur()');
        $this->add($IsvView);

        //Agregar campo total del detalle y reporte
        $GravadoView = new Element\Text('GravadoView');
        $GravadoView->setAttribute('class', 'form-control text-right');
        $GravadoView->setLabel('Importe Gravado');
        $GravadoView->setAttribute('id','GravadoView');
        $GravadoView->setAttribute('onFocus','this.blur()');
        $this->add($GravadoView);

        //Agregar campo total del detalle y reporte
        $ExentoView = new Element\Text('ExentoView');
        $ExentoView->setAttribute('class', 'form-control text-right');
        $ExentoView->setLabel('Importe Exento');
        $ExentoView->setAttribute('id','ExentoView');
        $ExentoView->setAttribute('onFocus','this.blur()');
        $this->add($ExentoView);

        //Agregar campo total del detalle y reporte
        $ExoneradoView = new Element\Text('ExoneradoView');
        $ExoneradoView->setAttribute('class', 'form-control text-right');
        $ExoneradoView->setLabel('Importe Exonerado ');
        $ExoneradoView->setAttribute('id','ExoneradoView');
        $ExoneradoView->setAttribute('onFocus','this.blur()');
        $this->add($ExoneradoView);

        
        //Agregar campo total
        $Total = new Element\Hidden('Total');
        $Total->setAttribute('id','total');
        $this->add($Total);

        //Agregar campo 
        $Isv = new Element\Hidden('Isv');
        $Isv->setAttribute('id','isv');
        $this->add($Isv);

        //Agregar campo 
        $Exonerado = new Element\Hidden('Exonerado');
        $Exonerado->setAttribute('id','exonerado');
        $this->add($Exonerado);

        //Agregar campo 
        $Exento = new Element\Hidden('Exento');
        $Exento->setAttribute('id','exento');
        $this->add($Exento);

        //Agregar campo 
        $Gravado = new Element\Hidden('Gravado');
        $Gravado->setAttribute('id','gravado');
        $this->add($Gravado);
       
       
        $RTN_View = new Element\Text('RTN_View');
        $RTN_View->setAttribute('class','form-control text-center');
        $RTN_View->setAttribute('id','RTN_Proveedor');
        $RTN_View->setLabel('RTN');
        $this->add($RTN_View);


        //Agregar botón de agregar productos a la tabla
        $Agregar = new Element\Button('Agregar');
        $Agregar->setLabel("Agregar artículo");
        $Agregar->setAttribute('type','button');
        $Agregar->setAttribute('id','agregar');
        $Agregar->setAttribute('class', 'btn btn-success btn-block blo');
        $Agregar->setAttribute('data-toggle', 'modal');
        $Agregar->setAttribute('data-target', '#myModal');
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