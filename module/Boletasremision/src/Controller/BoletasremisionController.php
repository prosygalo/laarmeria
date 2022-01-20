<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Boletasremision\Controller;

use Boletasremision\Form\BoletasremisionForm;
use Boletasremision\Model\Boletasremision;
use Boletasremision\Model\BoletasremisionTable;
use Boletasremision\Model\DetalleTable;
use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Sucursal\Model\SucursalTable;
use Conductor\Model\ConductorTable;
use Unidadtransporte\Model\UnidadtransporteTable;
use Producto\Model\ProductoTable;
use Autorizacionsar\Model\Autorizacionsar;
use Autorizacionsar\Model\AutorizacionsarTable;
use Usuario\Model\UsuarioTable;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * Esta Clase Controlador es encargado de las acciones en módulo boletas guía de remisión: Listar, Agregar , ver la boleta emitida y convertir la boleta en formato PDF. 
 */

class BoletasremisionController extends AbstractActionController
{
    // Add this property:
    private $container;
    private $BoletasremisionTable;
    private $DetalleTable; 
    private $SucursalTable; 
    private $ConductorTable; 
    private $UnidadtransporteTable; 
    private $ProductoTable; 
    private $AutorizacionsarTable;
    private $dbAdapter;

    // Add this constructor:
    public function __construct(ContainerInterface $container, BoletasremisionTable  $BoletasremisionTable, DetalleTable $DetalleTable, SucursalTable $SucursalTable, ConductorTable $ConductorTable, UnidadtransporteTable $UnidadtransporteTable, ProductoTable $ProductoTable, AutorizacionsarTable $AutorizacionsarTable, UsuarioTable $UsuarioTable, $dbAdapter)
    {
            $this->container = $container;
            $this->BoletasremisionTable = $BoletasremisionTable;
            $this->DetalleTable = $DetalleTable;
            $this->SucursalTable = $SucursalTable;
            $this->ConductorTable = $ConductorTable;
            $this->UnidadtransporteTable = $UnidadtransporteTable;
            $this->ProductoTable = $ProductoTable;
            $this->AutorizacionsarTable = $AutorizacionsarTable;
            $this->UsuarioTable = $UsuarioTable;
            $this->dbAdapter= $dbAdapter;
              
    }

    public function indexAction()
    {
         return new ViewModel([
                'Boletas' => $this->BoletasremisionTable->fetchAll(),
            ]);
    }
    
     public function addAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Sucursal_Remitente = $this->params()->fromRoute('Sucursal_Remitente');
        $fecha= date('Y-m-d'); 
        //-------Consecutivo autorizacion sar----
        $UltimaAutorizacion = $this->AutorizacionsarTable->getUltimaAutorizacionBoletaRemision($Sucursal_Remitente);
        if(is_null($UltimaAutorizacion)){
            return $this->redirect()->toRoute('boletacompra/errorautorizacion'); 
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
                            return $this->redirect()->toRoute('boletasremision/errorautorizacion');                         
                    }elseif($fecha > $Fecha_Limite){
                            return $this->redirect()->toRoute('boletasremision/vencimientofecha');
                    }elseif($Cod_Autorizacion != NULL && $Consecutivo_Actual_Correlativo >= $Consecutivo_Final_Correlativo){
                            return $this->redirect()->toRoute('boletasremision/expirocorrelativo');                            
                    }elseif($Cod_Autorizacion != NULL && $Consecutivo_Actual_Correlativo == NULL){                           
                            $form = new BoletasremisionForm();
                            $form->get('submit')->setValue('Guardar');
                            $form->get('Fecha_Emision')->setValue($fecha);
                            $form->get('Consecutivo_Actual_Establ')->setValue($Consecutivo_Inicial_Establ);
                            $form->get('Consecutivo_Actual_Punto')->setValue($Consecutivo_Inicial_Punto); 
                            $form->get('Consecutivo_Actual_Tipo')->setValue($Consecutivo_Inicial_Tipo); 
                            $form->get('Consecutivo_Actual_Correlativo')->setValue($Consecutivo_Inicial_Correlativo);
                            $form->get('Autorizacion_Sar')->setValue($Cod_Autorizacion);                                   
                   }elseif($Cod_Autorizacion != NULL && $Consecutivo_Actual_Correlativo <= $Consecutivo_Final_Correlativo &&  $Fecha_Limite >=  $fecha) {

                            $form = new BoletasremisionForm();
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

            //llenado de  Sucursal Remitente
            $rowset = $this->SucursalTable->getSucursalRemitente($Sucursal_Remitente);  
                foreach ($rowset  as $s):
                    $Punto_Partida = $s->Direccion;
                endforeach; 
            $form->get('Sucursal_Remitente')->setValue($Sucursal_Remitente);
            $form->get('Punto_Partida')->setValue($Punto_Partida); 
            //llenado de  Sucursal Remitente
            $rowset = $this->SucursalTable->getSucursalDestino(); //llenar select sucursal  remiten
            $form->get('Sucursal_Destino')->setValueOptions($rowset);   

            $rowset2 = $this->UnidadtransporteTable->getUnidadSelect(); //llenar select unidad 
            $form->get('Unidad_Transporte')->setValueOptions($rowset2); 

            $rowset3 = $this->ConductorTable->getConductorSelect(); //llenar select Conductor 
            $Conductor = $form->get('Conductor')->setValueOptions($rowset3); 

            $rowset4 = $this->ProductoTable->getProductoSelect(); //llenar select Conductor 
            $productos = $form->get('productos')->setValueOptions($rowset4); 

            //-------Solicitud-------------------------
            $request = $this->getRequest();
            if (! $request->isPost()) {
                 return ['form' => $form];

            }          
            //Validacion del formulario
            $form->setInputFilter(new  \Boletasremision\Form\Filter\BoletasremisionFilter($this->dbAdapter));//Filtrado y vlidacion  de los  datos
            $form->setData($request->getPost());
                
            if (! $form->isValid()){
                
                return ['form' => $form];
                  
            }
            //--------Tomar datos del formulario-y los guardamos en la base de datos, para ello realizamos tres procesos.
            $boletasremision = new Boletasremision();
            $boletasremision->exchangeArray($form->getData());
            $Cod_Producto = $this->request->getPost("Cod_Producto");
            $Descripcion = $this->request->getPost("Descripcion");
            $Cantidad = $this->request->getPost("Cantidad");
                            
           
            // Almacenar los datos en la tabla boleta de remision  
             $lastId = $this->BoletasremisionTable->insertBoleta($boletasremision);
                //Actualice el numero de consecutivo de la boleta de la guia de remision en la tabla autorizaciones SAR 
            $Cod_Autorizacion= $this->request->getPost("Autorizacion_Sar");
            $Consecutivo_Actual_Establ= $this->request->getPost("Consecutivo_Actual_Establ");
            $Consecutivo_Actual_Punto= $this->request->getPost("Consecutivo_Actual_Punto");
            $Consecutivo_Actual_Tipo= $this->request->getPost("Consecutivo_Actual_Tipo");
            $Consecutivo_Actual_Correlativo = $this->request->getPost("Consecutivo_Actual_Correlativo");
                   
            $this->AutorizacionsarTable->UpdateConsecutivoActual($Cod_Autorizacion, $Consecutivo_Actual_Establ, $Consecutivo_Actual_Punto, $Consecutivo_Actual_Tipo, $Consecutivo_Actual_Correlativo);                   
                //Cada producto debe de registrarse con el codigo de boleta  y almacenarse en el detalle
            $this->DetalleTable->insertDetalle($Cod_Producto, $Descripcion, $Cantidad, $lastId);// Enviar Datos a la tabla detalle a la BD                        
            return $this->redirect()->toRoute('boletasremision/detalle',['Cod_Boleta'=>$lastId]);

    }
    public function sucdesAction()
    {
        $Sucursal_Destino = $this->params()->fromRoute('Sucursal_Destino');
        
        $rowset3 = $this->SucursalTable->getDireccion($Sucursal_Destino); //llenar select sucursal  remiten
        return  new JsonModel($rowset3);

    }

    public function  detalleAction()
    {
       //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Boleta = $this->params()->fromRoute('Cod_Boleta');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Boleta === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código de boleta recibido
        try {
            $boleta = $this->BoletasremisionTable->getBoleta($Cod_Boleta);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }
        //crear instancia de formulario
        $form = new BoletasremisionForm();
        $form->bind($boleta);
       
        //Sucursal desde la que se hace la psolicitud de boleta
        $Sucursal_Remitente = [ 'Sucursal_Remitente'=>$boleta->Sucursal_Remitente];
        $Suc = $this->SucursalTable->getSucursalMembrete($Sucursal_Remitente);
        $Sucursal_Destino = [ 'Sucursal_Destino'=>$boleta->Sucursal_Destino];
        $SucRem = $this->SucursalTable->getDireccion($Sucursal_Remitente);
        $SucDes = $this->SucursalTable->getDireccion($Sucursal_Destino);
        foreach ($SucRem  as $a):
             $PuntoA = $a->Direccion;
        endforeach;
        $form->get('Punto_Partida')->setValue($PuntoA); 
        foreach ($SucDes  as $a):
             $form->get('Punto_Destino')->setValueOptions([$a->Direccion=>$a->Direccion]);
        endforeach;    

        //Autorizacion datos 
        $Autorizacion_Sar = [ 'Autorizacion_Sar'=>$boleta->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);

        //Usuario
        $Conductor = [ 'Conductor'=>$boleta->Conductor];
        $Lic = $this->ConductorTable->getLicencia($Conductor);
       
        //Usuario
        $Cod_Usuario = [ 'Usuario'=>$boleta->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);
        
        //Detalle de la boleta enviada 
        $Detalle = $this->DetalleTable->detalle($Cod_Boleta);
        
        
         //------llenado de los Listado de selección--------------- 

            $rowset = $this->SucursalTable->getSucursalListado(); //llenar select sucursal 
            $form->get('Sucursal_Destino')->setValueOptions($rowset);

            $rowset2 = $this->UnidadtransporteTable->getUnidadSelect(); //llenar select unidad 
            $form->get('Unidad_Transporte')->setValueOptions($rowset2); 

            $rowset3 = $this->ConductorTable->getConductorSelect(); //llenar select Conductor 
            $Conductor = $form->get('Conductor')->setValueOptions($rowset3); 

            $rowset4 = $this->ProductoTable->getProductoSelect(); //llenar select Conductor 
            $productos = $form->get('productos')->setValueOptions($rowset4);

        
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $viewData = new ViewModel([
             'Cod_Boleta' => $Cod_Boleta, 'form' => $form,//Bindear formulario y registro de boleta
             'Suc'=>$Suc,
             'Sar'=> $Sar,
             'Cai'=>$Cai,
             'Lic'=>$Lic,
             'user'=>$user,
             'Codigo'=>$Cod_Boleta, 
             'Detalle'=> $Detalle//Enviar una variable a la tabla donde se mostrará el producto y la cantidad correspondiente al cada codigo de boleta
               
        ]);
        //Verifica si la usuario ha enviado el formulario, de lo contrario retorna el viewdata
        if (! $request->isPost()){
            return $viewData;
        }
    }

    public function reporteAction()
    {
       //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Boleta = $this->params()->fromRoute('Cod_Boleta');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Boleta === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código de boleta recibido
        try {
            $boleta = $this->BoletasremisionTable->getBoleta($Cod_Boleta);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }
        //crear instancia de formulario
        $form = new BoletasremisionForm();
        $form->bind($boleta);
        
        //Sucursal desde la que se hace la psolicitud de boleta
        $Sucursal_Remitente = [ 'Sucursal_Remitente'=>$boleta->Sucursal_Remitente];
        $Suc = $this->SucursalTable->getSucursalMembrete($Sucursal_Remitente);
        $Sucursal_Destino = [ 'Sucursal_Destino'=>$boleta->Sucursal_Destino];
        $SucRem = $this->SucursalTable->getDireccion($Sucursal_Remitente);
        $SucDes = $this->SucursalTable->getDireccion($Sucursal_Destino);
        foreach ($SucRem  as $a):
             $PuntoA = $a->Direccion;
        endforeach;
        $form->get('Punto_Partida')->setValue($PuntoA); 
        foreach ($SucDes  as $a):
             $form->get('Destino_View')->setValue($a->Direccion);
        endforeach;   
        
        //Autorizacion datos 
        $Autorizacion_Sar = [ 'Autorizacion_Sar'=>$boleta->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);

        //Usuario
        $Conductor = [ 'Conductor'=>$boleta->Conductor];
        $Lic = $this->ConductorTable->getLicencia($Conductor);
       
        //Usuario
        $Cod_Usuario = [ 'Usuario'=>$boleta->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);
        
        //Detalle de la boleta enviada 
        $Detalle = $this->DetalleTable->detalle($Cod_Boleta);
        
         //------llenado de los Listado de selección--------------- 

            $rowset = $this->SucursalTable->getSucursalListado(); //llenar select sucursal 
            $form->get('Sucursal_Destino')->setValueOptions($rowset);

            $rowset2 = $this->UnidadtransporteTable->getUnidadSelect(); //llenar select unidad 
            $form->get('Unidad_Transporte')->setValueOptions($rowset2); 

            $rowset3 = $this->ConductorTable->getConductorSelect(); //llenar select Conductor 
            $Conductor = $form->get('Conductor')->setValueOptions($rowset3); 

            $rowset4 = $this->ProductoTable->getProductoSelect(); //llenar select Conductor 
            $productos = $form->get('productos')->setValueOptions($rowset4);
        
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $view = new ViewModel([
             'Cod_Boleta' => $Cod_Boleta, 'form' => $form,//Bindear formulario y registro de boleta
             'Suc'=> $Suc,
             'Sar'=> $Sar,
             'Lic'=>$Lic,
             'Cai'=>$Cai,
             'user'=>$user,
             'Cod_Boleta'=>$Cod_Boleta, 
             'Detalle'=> $Detalle//Enviar una variable a la tabla donde se mostrará el producto y la cantidad correspondiente al cada codigo de boleta
               
        ]);
        $view->setTerminal(true);
        return $view;
    }

    public function pdfAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Boleta = $this->params()->fromRoute('Cod_Boleta');
        //Si el código es incorrecto redirigie a listado de boletas    
        $html = file_get_contents("http://laarmeria/boletasremision/reporte/$Cod_Boleta");
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
        $dompdf->stream('boletaremision-'.$Cod_Boleta.'-'.date('d-m-y').'.pdf', array("Attachment" => 0));
    
    }
      public function  errorautorizacionAction()
    {   //redirecciona a la vista de error
         return new ViewModel([
                'Message' => 'No puede emitir boletas para guía  de remisión sin autorización previa, favor autorice sus documentos fiscales',
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