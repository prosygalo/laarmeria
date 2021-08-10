<?php
namespace Departamento\Controller;

use Departamento\Form\DepartamentoForm;
use Departamento\Model\Departamento;
use Departamento\Model\DepartamentoTable;
use Sucursal\Model\SucursalTable;
use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;


/**
 * This controller is responsible for 
 */
class DepartamentoController extends AbstractActionController
{
 // Add this property:
    private $container;
    //private $DepartamentoTable;
    private $table;
    private $SucursalTable; 
    private $dbAdapter;

    // Add this constructor:
    public function __construct(ContainerInterface $container, DepartamentoTable  $table, SucursalTable $SucursalTable, $dbAdapter)
    {
            $this->container = $container;
            //$this->DepartamentoTable = $DepartamentoTable;
            $this->SucursalTable = $SucursalTable;
            $this->table = $table;
            $this->dbAdapter=$dbAdapter;
    }

    public function indexAction()
     {
            return new ViewModel([
                'depto' => $this->table->fetchAll(),
            ]);

     }

      public function addAction()
    { 
        $form = new DepartamentoForm(); // mostrar formulario
        $form->get('submit')->setValue('Guardar');
        $rowset = $this->SucursalTable->getSucursalSelect(); //llenar select sucursal
        $form->get('Sucursal')->setValueOptions($rowset);
       
        $request = $this->getRequest();
        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $form->setInputFilter(new \Departamento\Form\Filter\DepartamentoFilter($this->dbAdapter));// filtrados y validaciones
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

         $departamento = new Departamento();
         $departamento->exchangeArray($form->getData());  // validacion de codigo único
         $Cod_Departamento = [
                'Cod_Departamento' => $departamento->Cod_Departamento,
         ];
              
         $existe = $this->table->getDepto($Cod_Departamento); 
        
         if ($existe){
           //$flashMessenger =$this->flashMessenger()->addErrorMessage('El Código de sucursal ya esta registrado, intente nuevamente');
            return ['form' => $form];
         }else{
             //$flashMessenger = $this->flashMessenger()->clearCurrentMessages();// limpiar mensages flash
                  $this->table->saveDepto($departamento);
            return $this->redirect()->toRoute('departamento/listo'); 
        }
    }

      public function editAction()
     {
        $Cod_Departamento = $this->params()->fromRoute('Cod_Departamento');

        if (!$Cod_Departamento) {
            return $this->redirect()->toRoute('departamento/add');
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $departamento = $this->table->getDepto($Cod_Departamento);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('departamento');
        }

        $form = new DepartamentoForm();
        $form->bind($departamento);
        $rowset = $this->SucursalTable->getSucursalSelect(); //llenar select sucursal
        $form->get('Sucursal')->setValueOptions($rowset);
        $form->get('submit')->setAttribute('value', 'Actualizar');

        $request = $this->getRequest();
        $viewData = ['Cod_Departamento' => $Cod_Departamento, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter(new \Departamento\Form\Filter\DepartamentoEditFilter($this->dbAdapter));// filtrados y validaciones
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->UpdateDepto($departamento);

        // Redirect to album list
        return $this->redirect()->toRoute('departamento');
    }
        

    public function deleteAction()
    {
            $Cod_Departamento = $this->params()->fromRoute('Cod_Departamento');
            
            if (!$Cod_Departamento) {
                return $this->redirect()->toRoute('departamento');
            }

            $request = $this->getRequest();
            if ($request->isPost()) {
                $del = $request->getPost('del', 'No');

                if ($del == 'Yes') {
                    $Cod_Departamento=$request->getPost('Cod_Departamento');
                    $this->table->deleteDepto($Cod_Departamento);
                }

                // Redirect to list 
                return $this->redirect()->toRoute('departamento');
            }
             return [
            'Cod_Departamento'    => $Cod_Departamento,
            'dep' => $this->table->getDepto($Cod_Departamento),
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