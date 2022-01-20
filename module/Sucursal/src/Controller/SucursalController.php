<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Sucursal\Controller;

use Sucursal\Form\SucursalForm;
use Sucursal\Model\Sucursal;
use Sucursal\Model\SucursalTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Este controlador es el encargado de las acciones en el módulo Sucursal: listar, agregar y editar registros.  
 */

class SucursalController extends AbstractActionController
{
 // Add this property:
    private $table;
    private $dbAdapter;

    // Add this constructor:
    public function __construct(SucursalTable $table, $dbAdapter)
     {
            $this->table = $table;
            $this->dbAdapter= $dbAdapter;
     }

    public function indexAction()
     {
            return new ViewModel([
                'sucur' => $this->table->fetchAll(),
            ]);
     }
     
     public function addAction()
     {
            $form = new SucursalForm();
            $form->get('submit')->setValue('Guardar');

            $request = $this->getRequest();

            if (! $request->isPost()) {
                return ['form' => $form];
            }

            $form->setInputFilter(new  \Sucursal\Form\Filter\SucursalFilter($this->dbAdapter));
            $form->setData($request->getPost());

            if (! $form->isValid()) {
                return ['form' => $form];
            }
            $sucursal = new Sucursal();
            $sucursal->exchangeArray($form->getData());
            $this->table->saveSucursal($sucursal);
            //view helper
            return $this->redirect()->toRoute('sucursal/listo');
            
    }
   
    public function editAction()
    {    //recuperar el código enviado 
        $Cod_Sucursal = $this->params()->fromRoute('Cod_Sucursal');
        //Si no hay código se redirecciona 
        if (!$Cod_Sucursal) {
            return $this->redirect()->toRoute('sucursal');
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $sucursal = $this->table->getSucursal($Cod_Sucursal);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('sucursal');
        }
        //crear instancia de formulario sucursal
        $form = new SucursalForm();
        $form->bind($sucursal);
        $form->get('submit')->setAttribute('value', 'Actualizar');
       //verificar si la solicitud es enviada
        $request = $this->getRequest();
        //crear un viewdata
        $viewData = ['Cod_Sucursal' => $Cod_Sucursal, 'form' => $form];
         //redireccionar si la solicitud no es enviada
        if (! $request->isPost()) {
            return $viewData;
        }
         //Validar y filtrar el formulario
        $form->setInputFilter(new  \Sucursal\Form\Filter\SucursalEditFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }
        //Actualizar los datos
        $this->table->updateSucursal($sucursal);

        // Redirect to album list
        return $this->redirect()->toRoute('sucursal');
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