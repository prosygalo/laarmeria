<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Constanciaretencion\Controller;

use Constanciaretencion\Form\ConstanciaretencionForm;
use Constanciaretencion\Model\Constanciaretencion;
use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Constanciaretencion\Model\ConstanciaretencionTable;
use Sucursal\Model\SucursalTable;
use Autorizacionsar\Model\AutorizacionsarTable;
use Proveedor\Model\ProveedorTable;
use Usuario\Model\UsuarioTable; 
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * Este  controlador es encargado  de acciones del módulo constancias de retención :listar, agregar , ver y convertir en las constancias en formato PDF.
 */

class ConstanciaretencionController extends AbstractActionController
{
    // Add this property:
    private $container;
    private $ConstanciaretencionTable;
    private $SucursalTable; 
    private $AutorizacionsarTable;
    private $ProveedorTable;
    private $UsuarioTable;
    private $dbAdapter;

    // Add this constructor:
    public function __construct(ContainerInterface $container, ConstanciaretencionTable  $ConstanciaretencionTable , SucursalTable  $SucursalTable , AutorizacionsarTable  $AutorizacionsarTable , ProveedorTable  $ProveedorTable , UsuarioTable $UsuarioTable ,  $dbAdapter)
    {
            $this->container = $container;
            $this->ConstanciaretencionTable = $ConstanciaretencionTable;
            $this->SucursalTable = $SucursalTable;
            $this->AutorizacionsarTable = $AutorizacionsarTable;
            $this->ProveedorTable = $ProveedorTable;
            $this->UsuarioTable = $UsuarioTable;
            $this->dbAdapter= $dbAdapter;
              
    }

    public function indexAction()
    {
         return new ViewModel([
                'constancias' => $this->ConstanciaretencionTable->fetchAll(),
            ]);
    }
    
     public function addAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Sucursal = $this->params()->fromRoute('Sucursal');  
        $fecha= date('Y-m-d'); 
        //-------Consecutivo autorizacion sar----
        $UltimaAutorizacion = $this->AutorizacionsarTable->getUltimaAutorizacionConstanciaretencion($Sucursal);
        if(is_null($UltimaAutorizacion)){
            return $this->redirect()->toRoute('constanciaretencion/errorautorizacion'); 
         }
            foreach ($UltimaAutorizacion  as $a):
                $Cod_Autorizacion = $a->Cod_Autorizacion;
                $Consecutivo_Inicial_Establ = $a->Consecutivo_Inicial_Establ;
                $Consecutivo_Inicial_Punto = $a->Consecutivo_Inicial_Punto;
                $Consecutivo_Inicial_Tipo = $a->Consecutivo_Inicial_Tipo;
                $Consecutivo_Inicial_Correlativo = $a->Consecutivo_Inicial_Correlativo;
                $Consecutivo_Final_Correlativo = $a->Consecutivo_Final_Correlativo;
                $Consecutivo_Actual_Establ = $a->Consecutivo_Actual_Establ;
                $Consecutivo_Actual_Punto = $a->Consecutivo_Actual_Punto;
                $Consecutivo_Actual_Tipo = $a->Consecutivo_Actual_Tipo;
                $Consecutivo_Actual_Correlativo = $a->Consecutivo_Actual_Correlativo;
                $Fecha_Limite = $a->Fecha_Limite;
              endforeach;           
                    if(is_null($Cod_Autorizacion)){
                            return $this->redirect()->toRoute('constanciaretencion/errorautorizacion');                           
                    }elseif($fecha > $Fecha_Limite){
                            return $this->redirect()->toRoute('constanciaretencion/vencimientofecha');
                    }elseif($Cod_Autorizacion != NULL && $Consecutivo_Actual_Correlativo >= $Consecutivo_Final_Correlativo){
                            return $this->redirect()->toRoute('constanciaretencion/expirocorrelativo');                            
                    }elseif($Cod_Autorizacion != NULL && $Consecutivo_Actual_Correlativo == NULL){                           
                            $form = new ConstanciaretencionForm();
                            $form->get('submit')->setValue('Guardar');
                            $form->get('Fecha_Emision')->setValue($fecha);
                            $form->get('Consecutivo_Actual_Establ')->setValue($Consecutivo_Inicial_Establ);
                            $form->get('Consecutivo_Actual_Punto')->setValue($Consecutivo_Inicial_Punto); 
                            $form->get('Consecutivo_Actual_Tipo')->setValue($Consecutivo_Inicial_Tipo); 
                            $form->get('Consecutivo_Actual_Correlativo')->setValue($Consecutivo_Inicial_Correlativo);
                            $form->get('Autorizacion_Sar')->setValue($Cod_Autorizacion);                                   
                   }elseif($Cod_Autorizacion != NULL && $Consecutivo_Actual_Correlativo <= $Consecutivo_Final_Correlativo &&  $Fecha_Limite >=  $fecha) {

                            $form = new ConstanciaretencionForm();
                            $form->get('submit')->setValue('Guardar');
                            $form->get('Fecha_Emision')->setValue($fecha);
                            $form->get('Autorizacion_Sar')->setValue($Cod_Autorizacion);
                            $form->get('Consecutivo_Actual_Establ')->setValue($Consecutivo_Actual_Establ);
                            $form->get('Consecutivo_Actual_Punto')->setValue($Consecutivo_Actual_Punto); 
                            $form->get('Consecutivo_Actual_Tipo')->setValue($Consecutivo_Actual_Tipo);
                            $nuevocorrelativo = $Consecutivo_Actual_Correlativo+1;                
                            if(($Consecutivo_Actual_Correlativo >= 1) && ($Consecutivo_Actual_Correlativo < 9)){
                              $a='0000000'.$nuevocorrelativo;
                              $form->get('Consecutivo_Actual_Correlativo')->setValue($a);
                            }elseif(($Consecutivo_Actual_Correlativo >= 9) && ($Consecutivo_Actual_Correlativo < 99)){
                               $b='000000'.$nuevocorrelativo;
                               $form->get('Consecutivo_Actual_Correlativo')->setValue($b);
                            }elseif(($Consecutivo_Actual_Correlativo >= 99) && ($Consecutivo_Actual_Correlativo < 999)){
                               $c='00000'.$nuevocorrelativo;
                               $form->get('Consecutivo_Actual_Correlativo')->setValue($c);
                            }elseif(($Consecutivo_Actual_Correlativo >= 999) && ($Consecutivo_Actual_Correlativo < 9999 )){
                              $d='0000'.$nuevocorrelativo;
                              $form->get('Consecutivo_Actual_Correlativo')->setValue($d);
                            }elseif(($Consecutivo_Actual_Correlativo >= 9999) && ($Consecutivo_Actual_Correlativo < 99999)){
                               $e='000'.$nuevocorrelativo;
                               $form->get('Consecutivo_Actual_Correlativo')->setValue($e);
                            }elseif(($Consecutivo_Actual_Correlativo >= 99999) && ($Consecutivo_Actual_Correlativo < 999999 )){
                               $f='00'.$nuevocorrelativo;
                               $form->get('Consecutivo_Actual_Correlativo')->setValue($f);
                            }elseif(($Consecutivo_Actual_Correlativo >= 999999) && ($Consecutivo_Actual_Correlativo < 9999999)){ 
                               $g='0'.$nuevocorrelativo;
                               $form->get('Consecutivo_Actual_Correlativo')->setValue($g);
                            }else{
                               $form->get('Consecutivo_Actual_Correlativo')->setValue($nuevocorrelativo);
                            }                            
                  }else{
                            return $this->redirect()->toRoute('home');
                  } 

            $form->get('Sucursal')->setValue($Sucursal); 
            
            $rowset2 = $this->ProveedorTable->getProveedorSelectRTN(); //llenar select sucursal  remiten
            $form->get('RTN_Proveedor')->setValueOptions($rowset2); 
               

            //-------Solicitud-------------------------
            $request = $this->getRequest();
            if (! $request->isPost()) {
                 return ['form' => $form];

            }          
            $form->setInputFilter(new  \Constanciaretencion\Form\Filter\ConstanciaretencionFilter ($this->dbAdapter));//Filtrado y vlidacion  de los  datos
            $form->setData($request->getPost());
                
            if (! $form->isValid()){
                return ['form' => $form];
            }
            //--------Tomar datos del formulario-y los guardamos en la base de datos, para ello realizamos tres procesos.
            $constanciaretencion = new Constanciaretencion();
            $constanciaretencion->exchangeArray($form->getData());     
                
            $lastId = $this->ConstanciaretencionTable->insertConstancia($constanciaretencion);
                //Actualice el numero de consecutivo de la boleta de la guia de remision en la tabla autorizaciones SAR 
            $Cod_Autorizacion= $this->request->getPost("Autorizacion_Sar");
            $Consecutivo_Actual_Establ= $this->request->getPost("Consecutivo_Actual_Establ");
            $Consecutivo_Actual_Punto= $this->request->getPost("Consecutivo_Actual_Punto");
            $Consecutivo_Actual_Tipo= $this->request->getPost("Consecutivo_Actual_Tipo");
            $Consecutivo_Actual_Correlativo = $this->request->getPost("Consecutivo_Actual_Correlativo");
            $this->AutorizacionsarTable->UpdateConsecutivoActual($Cod_Autorizacion, $Consecutivo_Actual_Establ, $Consecutivo_Actual_Punto, $Consecutivo_Actual_Tipo, $Consecutivo_Actual_Correlativo);
                       
            return $this->redirect()->toRoute('constanciaretencion/detalle',['Cod_Constancia'=> $lastId]);
    }
    
    public function proveedorAction()
    {
        $RTN_Proveedor = $this->params()->fromRoute('RTN_Proveedor');
        
        $rowset3 = $this->ProveedorTable->getProveedorSelectNombre($RTN_Proveedor); //llenar select sucursal  remiten
        return  new JsonModel($rowset3);


    }

    public function  detalleAction()
    {
      //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Constancia = $this->params()->fromRoute('Cod_Constancia');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Constancia === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código recibido
        try {
            $constanciaretencion = $this->ConstanciaretencionTable->getConstancia($Cod_Constancia);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }

        //crear instancia de formulario
        $form = new ConstanciaretencionForm();
        $form->bind($constanciaretencion);

        foreach ($constanciaretencion as $s):
            $Bas= $constanciaretencion->Base_Gravable_Impuesto;
            $Imp= $constanciaretencion->Importe_Retencion;
        endforeach;
        $Base = 'L.'.number_format($Bas, 2, ".", ",");
        $form->get('Base_Gravable_Impuesto')->setValue($Base);
        $Impor = 'L.'.number_format($Imp, 2, ".", ",");
        $form->get('Importe_Retencion')->setValue($Impor);
       

        //Sucursal desde la que se hace la psolicitud de boleta
        $Sucursal = [ 'Sucursal'=>$constanciaretencion->Sucursal];
        $Suc = $this->SucursalTable->getSucursalMembrete($Sucursal);

        //Autorizacion datos 
        $Autorizacion_Sar = ['Autorizacion_Sar'=>$constanciaretencion->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);

        //Usuario
        $Cod_Usuario = ['Usuario'=>$constanciaretencion->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);
        
        $Proveedor = [ 'Proveedor'=>$constanciaretencion->Proveedor];
        $Pro = $this->ProveedorTable->getProveedorConstancia($Proveedor); 
        foreach ($Pro  as $s):
            $RTN_Proveedor = $s->RTN_Proveedor;
            $Nombre_Proveedor = $s->Nombre_Proveedor;
            $Direccion_Proveedor = $s->Direccion_Proveedor;
        endforeach;
        $form->get('Nombre_Proveedor')->setValue($Nombre_Proveedor);
        $form->get('RTN_View')->setValue($RTN_Proveedor); 
        $form->get('Direccion_Proveedor')->setValue($Direccion_Proveedor);
       
       
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $viewData = new ViewModel([
             'Cod_Constancia' => $Cod_Constancia, 'form' => $form,//Bindear formulario y registro de boleta
             'Suc'=>$Suc,
             'Sar'=> $Sar,
             'Cai'=>$Cai,
             'user'=>$user,
             'Codigo'=>$Cod_Constancia,
        ]);
        //Verifica si la usuario ha enviado el formulario, de lo contrario retorna el viewdata
        if (! $request->isPost()){
            return $viewData;
        }
    }


    public function reporteAction()
    {
       //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Constancia = $this->params()->fromRoute('Cod_Constancia');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Constancia === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código recibido
        try {
            $constanciaretencion = $this->ConstanciaretencionTable->getConstancia($Cod_Constancia);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }
        //crear instancia de formulario
        $form = new ConstanciaretencionForm();
        $form->bind($constanciaretencion);

        foreach ($constanciaretencion as $s):
            $Bas= $constanciaretencion->Base_Gravable_Impuesto;
            $Imp= $constanciaretencion->Importe_Retencion;
        endforeach;
        $Base = 'L.'.number_format($Bas, 2, ".", ",");
        $form->get('Base_Gravable_Impuesto')->setValue($Base);
        $Impor = 'L.'.number_format($Imp, 2, ".", ",");
        $form->get('Importe_Retencion')->setValue($Impor);
       
        //Sucursal desde la que se hace la psolicitud de boleta
        $Sucursal = [ 'Sucursal'=>$constanciaretencion->Sucursal];
        $Suc = $this->SucursalTable->getSucursalMembrete($Sucursal);

        //Autorizacion datos 
        $Autorizacion_Sar = [ 'Autorizacion_Sar'=>$constanciaretencion->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);

        //Usuario
        $Cod_Usuario = [ 'Usuario'=>$constanciaretencion->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);

        $Proveedor = [ 'Proveedor'=>$constanciaretencion->Proveedor];
        $Pro = $this->ProveedorTable->getProveedorConstancia($Proveedor); 
        foreach ($Pro  as $s):
            $RTN_Proveedor = $s->RTN_Proveedor;
            $Nombre_Proveedor = $s->Nombre_Proveedor;
            $Direccion_Proveedor = $s->Direccion_Proveedor;
        endforeach;
        $form->get('Nombre_Proveedor')->setValue($Nombre_Proveedor);
        $form->get('RTN_View')->setValue($RTN_Proveedor); 
        $form->get('Direccion_Proveedor')->setValue($Direccion_Proveedor);
       
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $view = new ViewModel([
             'Cod_Constancia' => $Cod_Constancia, 'form' => $form,//Bindear formulario y registro de boleta
             'Suc'=>$Suc,
             'Sar'=> $Sar,
             'Cai'=>$Cai,
             'user'=>$user,
             'Codigo'=>$Cod_Constancia,
        ]);
        $view->setTerminal(true);
        return $view;
    }

    public function pdfAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Constancia = $this->params()->fromRoute('Cod_Constancia');
        //Si el código es incorrecto redirigie a listado de boletas    
        $html = file_get_contents("http://laarmeria/constanciaretencion/reporte/$Cod_Constancia");
         //instantiate and use the dompdf class
        $options = new Options();
        $options->set('isJavascriptEnabled', TRUE);
        $options->set('isPhpEnabled', TRUE);
        $options->set('isRemoteEnabled', TRUE);
        $options->set('isHtml5ParserEnabled', TRUE);
        $dompdf = new Dompdf($options); 
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter', 'portait');
        // Render the HTML as PDF 
        $dompdf->render(); 
        
        // Output the generated PDF to Browser
        $dompdf->stream('constanciaretencion-'.$Cod_Constancia.'-'.date('d-m-y').'.pdf', array("Attachment" => 0));
    
    }
      public function  errorautorizacionAction()
    {   //redirecciona a la vista de error
         return new ViewModel([
                'Message' => 'No puede emitir constancias de retención sin autorización previa, favor autorice sus documentos fiscales',
            ]);
     
    }
    public function  expirocorrelativoAction()
    {
        //redirecciona a la vista  de error
        return new ViewModel([
                'Message' => 'Lo sentimos, el número de correlativo autorizado ha llegado ha su límite, favor autorice impresión de documento fiscal',
            ]);
    }
    public function  vencimientofechaAction()
    {   //redirecciona a la vista de error
         return new ViewModel([
                'Message' => 'La fecha límite de emisión de documento fiscal ha expirado',
            ]);
    }
    public function inactivaAction()
    {
        return new ViewModel([
                'Message'=>'La sucursal a la que se esta asignado, no esta disponible para emitir documentos fiscales'
            ]);
    }

    public function listoAction()
    {
        return new ViewModel([
                'Guardado'=>'Guardado'
            ]);
    }
    public function errorAction()
    {
        return new ViewModel([
                'error'=>'Lo sentimos ha ocurrido un error'
            ]);
    }
}