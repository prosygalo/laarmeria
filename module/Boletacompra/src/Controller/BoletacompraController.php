<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Boletacompra\Controller;

use Boletacompra\Form\BoletacompraForm;
use Boletacompra\Model\Boletacompra;
use Boletacompra\Model\BoletacompraTable;
use Boletacompra\Model\DetallecompraTable;
use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Sucursal\Model\SucursalTable;
use Producto\Model\ProductoTable;
use Autorizacionsar\Model\AutorizacionsarTable;
use Usuario\Model\UsuarioTable;
use Proveedor\Model\ProveedorTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use Luecano\NumeroALetras\NumeroALetras;
/**
 * Este clase controlador es responsable de las acciones en el módulo boletas de compra, listar , agregar nueva boleta, ver la boleta que se emitió y convertir las boleta en formato PDF
 */

class BoletacompraController extends AbstractActionController
{
    // Add this property:
    private $container;
    private $BoletacompraTable;
    private $Detalle_CompraTable; 
    private $SucursalTable;
    private $ProductoTable; 
    private $AutorizacionsarTable;
    private $ProveedorTable;
    private $dbAdapter;

    // Add this constructor:
    public function __construct(ContainerInterface $container, BoletacompraTable  $BoletacompraTable, DetallecompraTable $DetallecompraTable, SucursalTable $SucursalTable, ProductoTable $ProductoTable, AutorizacionsarTable $AutorizacionsarTable, UsuarioTable $UsuarioTable,ProveedorTable $ProveedorTable, $dbAdapter)
    {
            $this->container = $container;
            $this->BoletacompraTable = $BoletacompraTable;
            $this->DetallecompraTable = $DetallecompraTable;
            $this->SucursalTable = $SucursalTable;
            $this->ProductoTable = $ProductoTable;
            $this->AutorizacionsarTable = $AutorizacionsarTable;
            $this->UsuarioTable = $UsuarioTable;
            $this->ProveedorTable = $ProveedorTable;
            $this->dbAdapter= $dbAdapter;
              
    }

    public function indexAction()
    {
         return new ViewModel([
                'Boleta' => $this->BoletacompraTable->fetchAll(),
            ]);
    }

     public function addAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Sucursal = $this->params()->fromRoute('Sucursal');        
        $fecha = date('Y-m-d');
        //-------Consecutivo autorizacion sar----
        $UltimaAutorizacion = $this->AutorizacionsarTable->getUltimaAutorizacionBoletaCompra($Sucursal);
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

                    if(empty($Cod_Autorizacion)){
                            return $this->redirect()->toRoute('boletacompra/errorautorizacion'); 

                    }elseif($fecha > $Fecha_Limite){

                            return $this->redirect()->toRoute('boletacompra/vencimientofecha');

                    }elseif((!empty($Cod_Autorizacion)) && $Consecutivo_Actual_Correlativo >= $Consecutivo_Final_Correlativo){
                            return $this->redirect()->toRoute('boletacompra/expirocorrelativo');                            
                    }elseif((!empty($Cod_Autorizacion)) && $Consecutivo_Actual_Correlativo == NULL){                           
                            $form = new BoletacompraForm();
                            $form->get('submit')->setValue('Guardar');
                            $form->get('Fecha_Emision')->setValue($fecha);
                            $form->get('Consecutivo_Actual_Establ')->setValue($Consecutivo_Inicial_Establ);
                            $form->get('Consecutivo_Actual_Punto')->setValue($Consecutivo_Inicial_Punto); 
                            $form->get('Consecutivo_Actual_Tipo')->setValue($Consecutivo_Inicial_Tipo); 
                            $form->get('Consecutivo_Actual_Correlativo')->setValue($Consecutivo_Inicial_Correlativo);
                            $form->get('Autorizacion_Sar')->setValue($Cod_Autorizacion);                                   
                   }elseif((!empty($Cod_Autorizacion)) && $Consecutivo_Actual_Correlativo <= $Consecutivo_Final_Correlativo &&  $Fecha_Limite >=  $fecha) {

                            $form = new BoletacompraForm();
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
            $form->get('Sucursal')->setValue($Sucursal);
            //llenado de  Proveedores
            $rowset = $this->ProveedorTable->getProveedorSelectRTN(); //llenar select sucursal  remiten
            $form->get('RTN_Proveedor')->setValueOptions($rowset);  
           
            //-------Solicitud-------------------------
            $request = $this->getRequest();
            if (! $request->isPost()) {
                 return ['form' => $form];

            }          
            //Validacion del formulario
            $form->setInputFilter(new  \Boletacompra\Form\Filter\BoletacompraFilter($this->dbAdapter));//Filtrado y vlidacion  de los  datos
            $form->setData($request->getPost());
                
            if (! $form->isValid()){
                return ['form' => $form];
                  
            }
            //--------Tomar datos del formulario-y los guardamos en la base de datos, para ello realizamos tres procesos.
            $boletacompra = new Boletacompra();
            $boletacompra->exchangeArray($form->getData());
            $Producto = $this->request->getPost("Producto");
            $Descripcion = $this->request->getPost("Descripcion");
            $Cantidad = $this->request->getPost("Cantidad");
            $Precio = $this->request->getPost("Precio");

             //Si se recibieron Codigo de producto duplicado, se retornará el formulario sin el listado de producto
            $unique = array_unique($Producto);
            $duplicado = array_diff_assoc($Producto, $unique);
             
            if ($duplicado != null){
                 return ['form' => $form];
             }
             //Si se recibe un codigo de producto con '0' cantidad , se retornará el formulario sin el listado de producto
             if (in_array("0", $Cantidad)){
                return ['form' => $form];
             }
             // Si se recibe un codigo de producto con null cantidad , se retornará el formulario sin el listado de producto
             if (in_array(null, $Cantidad)){
                return ['form' => $form];
             }
             //Si se recibe un codigo de producto con '0' cantidad , se retornará el formulario sin el listado de producto
             if (in_array("0", $Precio)){
                return ['form' => $form];
             }
             // Si se recibe un codigo de producto con null cantidad , se retornará el formulario sin el listado de producto
             if (in_array(null, $Precio)){
                return ['form' => $form];
             }
            
               
            // Almacenar los datos en la tabla boleta de remision  
               $lastId = $this->BoletacompraTable->insertBoleta($boletacompra);
               
            //Actualice el numero de consecutivo de la boleta de la guia de remision en la tabla autorizaciones SAR 
                $Cod_Autorizacion = $this->request->getPost("Autorizacion_Sar");
                $Consecutivo_Actual_Establ = $this->request->getPost("Consecutivo_Actual_Establ");
                $Consecutivo_Actual_Punto = $this->request->getPost("Consecutivo_Actual_Punto");
                $Consecutivo_Actual_Tipo = $this->request->getPost("Consecutivo_Actual_Tipo");
                $Consecutivo_Actual_Correlativo = $this->request->getPost("Consecutivo_Actual_Correlativo");
                   
               $this->AutorizacionsarTable->UpdateConsecutivoActual($Cod_Autorizacion, $Consecutivo_Actual_Establ, $Consecutivo_Actual_Punto, $Consecutivo_Actual_Tipo, $Consecutivo_Actual_Correlativo);                   
                 
            //Cada producto debe de registrarse con el codigo de boleta  y almacenarse en el detalle
               $this->DetallecompraTable->insertDetalle($Producto, $Descripcion, $Cantidad, $Precio, $lastId);// Enviar Datos a la tabla detalle a la BD                        
         //retornar a la pagina de detalle de la boleta   
          return $this->redirect()->toRoute('boletacompra/detalle',['Cod_Boleta_Compra'=>$lastId]);
    }
    public function  detalleAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Boleta_Compra = $this->params()->fromRoute('Cod_Boleta_Compra');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Boleta_Compra === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código de boleta recibido
        try {
            $boleta_compra = $this->BoletacompraTable->getBoleta($Cod_Boleta_Compra);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }

        //crear instancia de formulario
        $form = new BoletacompraForm();
        $form->bind($boleta_compra);
        
        $Sucursal = [ 'Sucursal'=>$boleta_compra->Sucursal];
        $Suc = $this->SucursalTable->getSucursalMembrete($Sucursal);

        //Autorizacion datos 
        $Autorizacion_Sar = [ 'Autorizacion_Sar'=>$boleta_compra->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);

        foreach ($boleta_compra as $s):
            $total= $boleta_compra->Total;
        endforeach;
        $Tot = 'L.'.number_format($total, 2, ".", ",");
        $form->get('TotalView')->setValue($Tot);

         $formatter = new NumeroALetras();
        $Letras = $formatter->toWords($total,2).'  LEMPIRAS';
        $form->get('cantidad_letras')->setValue($Letras);
        
        //Usuario
        $Cod_Usuario = [ 'Usuario'=>$boleta_compra->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);

        //Usuario
        $Proveedor = [ 'Proveedor'=>$boleta_compra->Proveedor];
        $Pro = $this->ProveedorTable->getProveedorBoletaCompra($Proveedor); 
        foreach ($Pro  as $s):
            $RTN_View = $s->RTN_Proveedor;
            $Nombre_Proveedor = $s->Nombre_Proveedor;
            $Direccion_Proveedor= $s->Direccion_Proveedor;
            $Telefono_Proveedor= $s->Telefono_Proveedor;
        endforeach;
        $form->get('RTN_View')->setValue($RTN_View); 
        $form->get('Nombre_Proveedor')->setValue($Nombre_Proveedor);
        $form->get('Direccion_Proveedor')->setValue($Direccion_Proveedor);
        $form->get('Telefono_Proveedor')->setValue($Telefono_Proveedor);

        //Detalle de la boleta enviada 
        $Detalle = $this->DetallecompraTable->getDetalle($Cod_Boleta_Compra);
        
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $viewData = new ViewModel([
             'Cod_Boleta_Compra'=> $Cod_Boleta_Compra, 'form' => $form,//Bindear formulario y registro de boleta
             'Suc'=>$Suc,
             'Sar'=> $Sar,
             'Cai'=>$Cai,
             'user'=>$user,
             'Cod_Boleta_Compra'=>$Cod_Boleta_Compra, 
             'Detalle'=> $Detalle//Enviar una variable a la tabla donde se mostrará el producto y la cantidad correspondiente al cada codigo de boleta
               
        ]);
        //Verifica si la usuario ha enviado el formulario, de lo contrario retorna el viewdata
        if (! $request->isPost()){
            return $viewData;
        } 
                     
    }
    public function reporteAction()
    {  //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Boleta_Compra = $this->params()->fromRoute('Cod_Boleta_Compra');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Boleta_Compra === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código de boleta recibido
        try {
            $boleta_compra = $this->BoletacompraTable->getBoleta($Cod_Boleta_Compra);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }
        //crear instancia de formulario
        $form = new BoletacompraForm();
        $form->bind($boleta_compra);


        foreach ($boleta_compra as $s):
            $total= $boleta_compra->Total;
        endforeach;
        $Tot = 'L.'.number_format($total, 2, ".", ",");
        $form->get('TotalView')->setValue($Tot);
        $form->get('Subtotal')->setValue($Tot);

        $formatter = new NumeroALetras();
        $Letras = $formatter->toWords($total,2).'  LEMPIRAS';
        $form->get('cantidad_letras')->setValue($Letras);
        
        $Sucursal = [ 'Sucursal'=>$boleta_compra->Sucursal];
        $Suc = $this->SucursalTable->getSucursalMembrete($Sucursal);

        //Autorizacion datos 
        $Autorizacion_Sar = [ 'Autorizacion_Sar'=>$boleta_compra->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);
       
        //Usuario
        $Cod_Usuario = [ 'Usuario'=>$boleta_compra->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);

       //Proveedor
        $Proveedor = [ 'Proveedor'=>$boleta_compra->Proveedor];
        $Pro = $this->ProveedorTable->getProveedorBoletaCompra($Proveedor); 
        foreach ($Pro  as $s):
            $RTN_View = $s->RTN_Proveedor;
            $Nombre_Proveedor = $s->Nombre_Proveedor;
            $Direccion_Proveedor= $s->Direccion_Proveedor;
            $Telefono_Proveedor= $s->Telefono_Proveedor;
        endforeach;
        $form->get('RTN_View')->setValue($RTN_View); 
        $form->get('Nombre_Proveedor')->setValue($Nombre_Proveedor);
        $form->get('Direccion_Proveedor')->setValue($Direccion_Proveedor);
        $form->get('Telefono_Proveedor')->setValue($Telefono_Proveedor);


        //Detalle de la boleta enviada 
        $Detalle = $this->DetallecompraTable->getDetalle($Cod_Boleta_Compra);
        
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $view = new ViewModel([
             'Cod_Boleta_Compra'=> $Cod_Boleta_Compra, 'form' => $form,//Bindear formulario y registro de boleta
             'Suc'=>$Suc,
             'Sar'=> $Sar,
             'Cai'=>$Cai,
             'user'=>$user,
             'Cod_Boleta_Compra'=>$Cod_Boleta_Compra, 
             'Detalle'=> $Detalle//Enviar una variable a la tabla donde se mostrará el producto y la cantidad correspondiente al cada codigo de boleta
               
        ]);
        $view->setTerminal(true);
        return $view;
    }
     public function pdfAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Boleta_Compra = $this->params()->fromRoute('Cod_Boleta_Compra');
        //Si el código es incorrecto redirigie a listado de boletas    
        $html = file_get_contents("http://laarmeria/boletacompra/reporte/$Cod_Boleta_Compra");
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
        $dompdf->stream('boletacompra-'.$Cod_Boleta_Compra.'-'.date('d-m-y').'.pdf', array("Attachment" => 0));
    
    }
      public function  errorautorizacionAction()
    {   //redirecciona a la vista de error
         return new ViewModel([
                'Message' => 'No puede emitir boletas de compra sin autorización previa, favor autorice sus documentos fiscales',
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


    // formato Json para pruebas
    public function pruebaAction()
    { 
         $UltimaAutorizacion = $this->AutorizacionsarTable->getUltimaAutorizacionBoletaCompra('CPT');
        return  new JsonModel($UltimaAutorizacion);
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
