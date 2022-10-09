<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Notadebito\Controller;

use Notadebito\Form\NotadebitoForm;
use Notadebito\Model\Notadebito;
use Notadebito\Model\NotadebitoTable;
use Notadebito\Model\DetalleNotadebitoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Sucursal\Model\SucursalTable;
use Producto\Model\ProductoTable;
use Autorizacionsar\Model\AutorizacionsarTable;
use Usuario\Model\UsuarioTable;
use Cliente\Model\ClienteTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use Luecano\NumeroALetras\NumeroALetras;
/**
 * Este controlador es el encargado de las acciones en el módulo Nota de débitos: Listar, agregar, ver y convertir una nota de debito en formato PDF.
 */

class NotadebitoController extends AbstractActionController
{
    // Add this property:
    private $container;
    private $NotadebitoTable;
    private $DetalleNotadebitoTable; 
    private $SucursalTable;
    private $ProductoTable; 
    private $AutorizacionsarTable;
    private $ClienteTable;
    private $dbAdapter;

    // Add this constructor:
    public function __construct(ContainerInterface $container, NotadebitoTable  $NotadebitoTable, DetalleNotadebitoTable $DetalleNotadebitoTable, SucursalTable $SucursalTable, ProductoTable $ProductoTable, AutorizacionsarTable $AutorizacionsarTable, UsuarioTable $UsuarioTable, ClienteTable $ClienteTable, $dbAdapter)
    {
            $this->container = $container;
            $this->NotadebitoTable = $NotadebitoTable;
            $this->DetalleNotadebitoTable = $DetalleNotadebitoTable;
            $this->SucursalTable = $SucursalTable;
            $this->ProductoTable = $ProductoTable;
            $this->AutorizacionsarTable = $AutorizacionsarTable;
            $this->UsuarioTable = $UsuarioTable;
            $this->ClienteTable = $ClienteTable;
            $this->dbAdapter= $dbAdapter;
              
    }

    public function indexAction()
    {
         return new ViewModel([
                'Nota' => $this->NotadebitoTable->fetchAll(),
            ]);
    }

     public function addAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Sucursal = $this->params()->fromRoute('Sucursal');
        $fecha = date('Y-m-d');
        //-------Consecutivo autorizacion sar----
        $UltimaAutorizacion = $this->AutorizacionsarTable->getUltimaAutorizacionNotaDebito($Sucursal);
          if(is_null($UltimaAutorizacion)){
             return $this->redirect()->toRoute('notadebito/errorautorizacion');                           
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
                $Tipo_de_Documento = $a->Tipo_de_Documento;
                $Fecha_Limite = $a->Fecha_Limite;
              endforeach;           
                    if(empty($Cod_Autorizacion)){
                            return $this->redirect()->toRoute('notadebito/errorautorizacion');                           
                    }elseif($fecha > $Fecha_Limite){
                            return $this->redirect()->toRoute('notadebito/vencimientofecha');
                    }elseif((!empty($Cod_Autorizacion)) && $Consecutivo_Actual_Correlativo >= $Consecutivo_Final_Correlativo){
                            return $this->redirect()->toRoute('notadebito/expirocorrelativo');                            
                    }elseif((!empty($Cod_Autorizacion)) && $Consecutivo_Actual_Correlativo == NULL){                           
                            $form = new NotadebitoForm();
                            $form->get('submit')->setValue('Guardar');
                            $form->get('Fecha_Emision')->setValue($fecha);
                            $form->get('Consecutivo_Actual_Establ')->setValue($Consecutivo_Inicial_Establ);
                            $form->get('Consecutivo_Actual_Punto')->setValue($Consecutivo_Inicial_Punto); 
                            $form->get('Consecutivo_Actual_Tipo')->setValue($Consecutivo_Inicial_Tipo); 
                            $form->get('Consecutivo_Actual_Correlativo')->setValue($Consecutivo_Inicial_Correlativo);
                            $form->get('Autorizacion_Sar')->setValue($Cod_Autorizacion);                                   
                   }elseif((!empty($Cod_Autorizacion)) && $Consecutivo_Actual_Correlativo <= $Consecutivo_Final_Correlativo &&  $Fecha_Limite >=  $fecha) {

                            $form = new NotadebitoForm();
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
            $rowset = $this->ClienteTable->getClienteRTNSelect(); //llenar select sucursal  remiten
            $form->get('Rtn_Dni')->setValueOptions($rowset);

            $rowset4 = $this->ProductoTable->getProductoSelect($Sucursal); //llenar select Conductor 
            $productos = $form->get('productos')->setValueOptions($rowset4);             
           
            //-------Solicitud-------------------------
            $request = $this->getRequest();
            if (! $request->isPost()) {
                return ['form' => $form];

            }          

            //Validacion del formulario
            $form->setInputFilter(new  \Notadebito\Form\Filter\NotadebitoFilter($this->dbAdapter));//Filtrado y vlidacion  de los  datos
            $form->setData($request->getPost());
            if (! $form->isValid()){
                 return ['form' => $form];
            }

            //--------Tomar datos del formulario-y los guardamos en la base de datos, para ello realizamos tres procesos.
            $notadebito = new Notadebito();
            $notadebito->exchangeArray($form->getData());
            return  new JsonModel($form->getData());

            $Cod_Producto = $this->request->getPost("Cod_Producto");
            $Descripcion = $this->request->getPost("Descripcion");
            $Cantidad = $this->request->getPost("Cantidad");
            $Precio = $this->request->getPost("Precio");
             
             //Si se recibieron Codigo de producto duplicado, se retornará el formulario sin el listado de producto
            $unique = array_unique($Cod_Producto);
            $duplicado = array_diff_assoc($Cod_Producto, $unique);
             
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
            
            //$existencia = $this->ProductoTable->ComprobarExistencia($Cod_Producto, $Cantidad);

           /// if(){
             
            //Actualización de existencias
                $this->ProductoTable->UpdateExistenciaProducto($Cod_Producto, $Cantidad);
            
            // Almacenar los datos en la tabla boleta de remision  
                $lastId = $this->NotadebitoTable->insertNotaDebito($notadebito);
            
            //Actualice el numero de consecutivo de la boleta de la guia de remision en la tabla autorizaciones SAR 
                $Cod_Autorizacion= $this->request->getPost("Autorizacion_Sar");
                $Consecutivo_Actual_Establ= $this->request->getPost("Consecutivo_Actual_Establ");
                $Consecutivo_Actual_Punto= $this->request->getPost("Consecutivo_Actual_Punto");
                $Consecutivo_Actual_Tipo= $this->request->getPost("Consecutivo_Actual_Tipo");
                $Consecutivo_Actual_Correlativo = $this->request->getPost("Consecutivo_Actual_Correlativo");
                                   
                
            //Almacenar el detalle
                $this->DetalleNotadebitoTable->insertDetalleNotadebito($Cod_Producto, $Descripcion, $Precio, $Cantidad, $lastId);                     
  
            //Actualización de consecutivo en autorizaciones
                $this->AutorizacionsarTable->UpdateConsecutivoActual($Cod_Autorizacion, $Consecutivo_Actual_Establ, $Consecutivo_Actual_Punto, $Consecutivo_Actual_Tipo, $Consecutivo_Actual_Correlativo);   

            return $this->redirect()->toRoute('notadebito/detalle',['Cod_Nota'=>$lastId]);
    /* }else{

             return $this->redirect()->toRoute('home');
        }*/
    }
    public function clienteAction()
    {
        $Rtn_Dni = $this->params()->fromRoute('Rtn_Dni');
        
        $rowset3 = $this->ClienteTable->getClienteNombre($Rtn_Dni); //llenar select sucursal  remiten
        return  new JsonModel($rowset3);

    }
     public function productoAction()
    {
        $Producto = $this->params()->fromRoute('Cod_Producto');
        
        $rowset4 = $this->ProductoTable->getProductoExistencia($Producto); //llenar select sucursal  remiten
        return  new JsonModel($rowset4);

    }
    public function  detalleAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Nota = $this->params()->fromRoute('Cod_Nota');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Nota === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código de boleta recibido
        try {
            $notadebito = $this->NotadebitoTable->getNota($Cod_Nota);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }

        //crear instancia de formulario
        $form = new NotadebitoForm();
        $form->bind($notadebito);
        

        //Autorizacion datos 
        $Autorizacion_Sar = [ 'Autorizacion_Sar'=>$notadebito->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);

        foreach ($notadebito as $s):
            $total = $notadebito->Total;
            $Isv = $notadebito->Isv;
            $Exonerado = $notadebito->Exonerado;
            $Exento = $notadebito->Exento;
            $Gravado = $notadebito->Gravado;
        endforeach;
        $Tot = 'L.'.number_format($total, 2, ".", ",");
        $form->get('TotalView')->setValue($Tot);

        $Is = 'L.'.number_format($Isv, 2, ".", ",");
        $form->get('IsvView')->setValue($Is);

        $Exo = 'L.'.number_format($Exonerado, 2, ".", ",");
        $form->get('ExoneradoView')->setValue($Exo);

        $Exen = 'L.'.number_format($Exento, 2, ".", ",");
        $form->get('ExentoView')->setValue($Exen);

        $Gra = 'L.'.number_format($Gravado, 2, ".", ",");
        $form->get('GravadoView')->setValue($Gra);

        $formatter = new NumeroALetras();
        $Letras = $formatter->toWords($total,2).'  LEMPIRAS';
        $form->get('Cantidad_Letras')->setValue($Letras);
        
        //Usuario
        $Cod_Usuario = [ 'Usuario'=>$notadebito->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);

        //Cliente
        $Cliente = [ 'Cliente'=>$notadebito->Cliente];
        $Cli = $this->ClienteTable->getclienteNota($Cliente); 
        foreach ($Cli  as $s):
            $RTN_DNI = $s->Rtn_Dni;
            $Nombres_Cliente = $s->Nombres_Cliente;
            $Apellidos_Cliente = $s->Apellidos_Cliente;
        endforeach;
        $form->get('RTN_View')->setValue($RTN_DNI); 
        $form->get('Nombres_Cliente')->setValue($Nombres_Cliente." ".$Apellidos_Cliente);
       
        //Detalle de la boleta enviada 
        $Detalle = $this->DetalleNotadebitoTable->getDetalleNota($Cod_Nota);

        
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $viewData = new ViewModel([
             'Cod_Nota'=> $Cod_Nota, 'form' => $form,//Bindear formulario y registro de boleta
             'Sar'=> $Sar,
             'Cai'=>$Cai,
             'user'=>$user,
             'Cod_Nota'=>$Cod_Nota, 
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
        $Cod_Nota = $this->params()->fromRoute('Cod_Nota');
        //Si el código es incorrecto redirigie a listado de boletas
        if ($Cod_Nota === NULL) {
            return $this->redirect()->toRoute('home');
        } 
        //consultar registro del código de boleta recibido
        try {
            $notadebito = $this->NotadebitoTable->getNota($Cod_Nota);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home');
        }

        //crear instancia de formulario
        $form = new NotadebitoForm();
        $form->bind($notadebito);
        

        //Autorizacion datos 
        $Autorizacion_Sar = [ 'Autorizacion_Sar'=>$notadebito->Autorizacion_Sar];
        $Sar = $this->AutorizacionsarTable->getAutorizacionReporte($Autorizacion_Sar);
        $Cai = $this->AutorizacionsarTable->getCai($Autorizacion_Sar);

        foreach ($notadebito as $s):
            $total = $notadebito->Total;
            $Isv = $notadebito->Isv;
            $Exonerado = $notadebito->Exonerado;
            $Exento = $notadebito->Exento;
            $Gravado = $notadebito->Gravado;
        endforeach;
        $Tot = 'L.'.number_format($total, 2, ".", ",");
        $form->get('TotalView')->setValue($Tot);

        $Is = 'L.'.number_format($Isv, 2, ".", ",");
        $form->get('IsvView')->setValue($Is);

        $Exo = 'L.'.number_format($Exonerado, 2, ".", ",");
        $form->get('ExoneradoView')->setValue($Exo);

        $Exen = 'L.'.number_format($Exento, 2, ".", ",");
        $form->get('ExentoView')->setValue($Exen);

        $Gra = 'L.'.number_format($Gravado, 2, ".", ",");
        $form->get('GravadoView')->setValue($Gra);

        $formatter = new NumeroALetras();
        $Letras = $formatter->toWords($total,2).'  LEMPIRAS';
        $form->get('Cantidad_Letras')->setValue($Letras);
        
        //Usuario
        $Cod_Usuario = [ 'Usuario'=>$notadebito->Usuario];
        $user = $this->UsuarioTable->getUsuarioBoleta($Cod_Usuario);

        //Usuario
        $Cliente = [ 'Cliente'=>$notadebito->Cliente];
        $Cli = $this->ClienteTable->getclienteNota($Cliente); 
        foreach ($Cli  as $s):
            $RTN_DNI = $s->Rtn_Dni;
            $Nombres_Cliente = $s->Nombres_Cliente;
            $Apellidos_Cliente = $s->Apellidos_Cliente;
        endforeach;
        $form->get('RTN_View')->setValue($RTN_DNI); 
        $form->get('Nombres_Cliente')->setValue($Nombres_Cliente." ".$Apellidos_Cliente);
       
        //Detalle de la boleta enviada 
        $Detalle = $this->DetalleNotadebitoTable->getDetalleNota($Cod_Nota);
        
        //Verifica si la usuario ha enviado el formulario
        $request = $this->getRequest();
        $viewData = new ViewModel([
             'Cod_Nota'=> $Cod_Nota, 'form' => $form,//Bindear formulario y registro de boleta
             'Sar'=> $Sar,
             'Cai'=>$Cai,
             'user'=>$user,
             'Cod_Nota'=>$Cod_Nota, 
             'Detalle'=> $Detalle//Enviar una variable a la tabla donde se mostrará el producto y la cantidad correspondiente al cada codigo de boleta
               
        ]);
        $viewData->setTerminal(true);
        return $viewData;
    }

     public function pdfAction()
    {
        //Recibir el código de boleta  para mostrar el detalle que corresponde
        $Cod_Nota = $this->params()->fromRoute('Cod_Nota');
        //Si el código es incorrecto redirigie a listado de boletas    
        $html = file_get_contents("http://laarmeria/notadebito/reporte/$Cod_Nota");
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
        $dompdf->stream('notadebito-'.$Cod_Nota.'-'.date('d-m-y').'.pdf', array("Attachment" => 0));
    
    }
      public function  errorautorizacionAction()
    {   //redirecciona a la vista de error
         return new ViewModel([
                'Message' => 'No puede emitir Notas de Débito sin autorización previa, favor autorice sus documentos fiscales',
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
          $total = $this->DetalleNotadebitoTable->getTotal('3011');
        return  new JsonModel($total);
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
