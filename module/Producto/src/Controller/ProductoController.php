<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Producto\Controller;

use Producto\Form\ProductoForm;
use Producto\Model\Producto;
use Producto\Model\ProductoTable;
use Sucursal\Model\SucursalTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Este controlador es el responsable de las acciones en el módulo producto: Listar, agregar y editar registros. */


class ProductoController extends AbstractActionController
{
 // Add this property:
    private $table;
    private $dbAdapter;
    private $SucursalTable; 

    // Add this constructor:
    public function __construct(ProductoTable $table, SucursalTable $SucursalTable, $dbAdapter)
     {
            $this->table = $table;
            $this->dbAdapter= $dbAdapter;
            $this->SucursalTable = $SucursalTable;


     }

    public function indexAction()
     {
            return new ViewModel([
                'product' => $this->table->fetchAll(),
            ]);
     }
     
     public function addAction()
     {
            $form = new ProductoForm();
            $rowset = $this->SucursalTable->getSucursalListado(); //llenar select sucursal 
            $form->get('Sucursal')->setValueOptions($rowset);
            $form->get('submit')->setValue('Guardar');

            $request = $this->getRequest();

            if (! $request->isPost()) {
                return ['form' => $form];
            }

            $form->setInputFilter(new  \Producto\Form\Filter\ProductoFilter($this->dbAdapter));
            $form->setData($request->getPost());

            if (! $form->isValid()) {
                return ['form' => $form];
            }
            $producto = new Producto();
            $producto->exchangeArray($form->getData());
            $this->table->saveProducto($producto);
            //view helper
            return $this->redirect()->toRoute('productos/listo');
            
    }
   
    public function editAction()
    {
        $Cod_Producto = $this->params()->fromRoute('Cod_Producto');

        if (!$Cod_Producto) {
            return $this->redirect()->toRoute('productos/add');
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $producto = $this->table->getproducto($Cod_Producto);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('productos');
        }

        $form = new ProductoForm();
        $rowset = $this->SucursalTable->getSucursalListado(); //llenar select sucursal 
        $form->get('Sucursal')->setValueOptions($rowset);
        $form->bind($producto);
        $form->get('submit')->setAttribute('value', 'Actualizar');

        $request = $this->getRequest();
        $viewData = ['Cod_Producto' => $Cod_Producto, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter(new  \Producto\Form\Filter\ProductoEditFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->UpdateProducto($producto);

        // Redirect to album list
        return $this->redirect()->toRoute('productos');
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