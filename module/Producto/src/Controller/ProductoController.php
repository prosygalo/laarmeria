<?php
namespace Producto\Controller;

use Producto\Form\ProductoForm;
use Producto\Model\Producto;
use Producto\Model\ProductoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * This controller is responsible for letting 
 */


class ProductoController extends AbstractActionController
{
 // Add this property:
    private $table;
    private $dbAdapter;

    // Add this constructor:
    public function __construct(ProductoTable $table, $dbAdapter)
     {
            $this->table = $table;
            $this->dbAdapter= $dbAdapter;
     }

    public function indexAction()
     {
            return new ViewModel([
                'product' => $this->table->fetchAll(),
            ]);
     }
     
     public function verproductoAction(){
            //Recogemos el valor de la ruta
           $Cod_Producto = $this->params()->fromRoute('Cod_Producto', 0);
            /*
            *Le podemos indicar el tipo de dato que va a ser
            *$id=(int)$this->params()->fromRoute("id",null);
            */
             
            $nombre ='Codigo: '. $Cod_Producto;
            return new ViewModel([
                    'nombre' => $nombre,
                    ]);
     }

     public function addAction()
     {
            $form = new ProductoForm();
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

    public function deleteAction()
    {
            $Cod_Producto = $this->params()->fromRoute('Cod_Producto',null);
            
            if (!$Cod_Producto) {
                return $this->redirect()->toRoute('productos');
            }

            $request = $this->getRequest();
            if ($request->isPost()) {
                $del = $request->getPost('del', 'Cancelar');

                if ($del == 'Borrar') {
                    $Cod_Producto= $request->getPost('Cod_Producto');
                    $this->table->deleteProducto($Cod_Producto);
                }

                // Redirect to list 
                return $this->redirect()->toRoute('productos');
            }
             return [
            'Cod_Producto'    => $Cod_Producto,
            'pro' => $this->table->getproducto($Cod_Producto),
        ];
            
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