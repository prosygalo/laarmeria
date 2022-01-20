<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Proveedor\Controller;

use Proveedor\Form\ProveedorForm;
use Proveedor\Model\Proveedor;
use Proveedor\Model\ProveedorTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * This controller is responsible for letting the user to log in and log out.
 */
class ProveedorController extends AbstractActionController
{
 // Add this property:
    private $dbAdapter;
    private $table;

    // Add this constructor:
    public function __construct(ProveedorTable $table, $dbAdapter)
     {
            $this->table = $table;
            $this->dbAdapter = $dbAdapter;
          
     }

    public function indexAction()
     {
            return new ViewModel([
                'proveedor' => $this->table->fetchAll(),
            ]);
     }


      public function addAction()
    {
        $form = new ProveedorForm();
        $form->get('submit')->setValue('Guardar');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $form->setInputFilter(new  \Proveedor\Form\Filter\ProveedorFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        $proveedor = new Proveedor();
        $proveedor->exchangeArray($form->getData());
        $this->table->insertProveedor($proveedor);
        return $this->redirect()->toRoute('proveedor/listo');
    }
   
    public function editAction()
    {
        $Cod_Proveedor = $this->params()->fromRoute('Cod_Proveedor');

        if (!$Cod_Proveedor) {
            return $this->redirect()->toRoute('proveedor/add');
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $proveedor = $this->table->getProveedor($Cod_Proveedor);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('proveedor');
        }

        $form = new ProveedorForm();
        $form->bind($proveedor);
        $form->get('submit')->setAttribute('value', 'Actualizar');

        $request = $this->getRequest();
        $viewData = ['Cod_Proveedor' => $Cod_Proveedor, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter(new  \Proveedor\Form\Filter\ProveedorEditFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->updateProveedor($proveedor);

        // Redirect to album list
        return $this->redirect()->toRoute('proveedor');

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