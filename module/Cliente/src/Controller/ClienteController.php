<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Cliente\Controller;

use Cliente\Form\ClienteForm;
use Cliente\Model\Cliente;
use Cliente\Model\ClienteTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * Este controlador es el encargado de las acciones en módulo clientes: Listar, Agregar y editarlos registros de los clientes.
 */
class ClienteController extends AbstractActionController
{
 // Add this property:
    private $dbAdapter;
    private $table;

    // Add this constructor:
    public function __construct(ClienteTable $table, $dbAdapter)
     {
            $this->table = $table;
            $this->dbAdapter = $dbAdapter;
          
     }

    public function indexAction()
     {
            return new ViewModel([
                'cliente' => $this->table->fetchAll(),
            ]);
     }

      public function addAction()
    {
        $form = new ClienteForm();
        $form->get('submit')->setValue('Guardar');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $form->setInputFilter(new  \Cliente\Form\Filter\ClienteFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        $cliente = new Cliente();
        $cliente->exchangeArray($form->getData());
        $this->table->insertCliente($cliente);
        return $this->redirect()->toRoute('cliente/listo');
    }
   
    public function editAction()
    {
        $Cod_Cliente = $this->params()->fromRoute('Cod_Cliente');

        if (!$Cod_Cliente) {
            return $this->redirect()->toRoute('cliente/add');
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $cliente = $this->table->getCliente($Cod_Cliente);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('cliente');
        }

        $form = new ClienteForm();
        $form->bind($cliente);
        $form->get('submit')->setAttribute('value', 'Actualizar');

        $request = $this->getRequest();
        $viewData = ['Cod_Cliente' => $Cod_Cliente, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter(new  \Cliente\Form\Filter\ClienteEditFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->updateCliente($cliente);

        // Redirect to album list
        return $this->redirect()->toRoute('cliente');

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