<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Departamento\Controller;

use Departamento\Form\DepartamentoForm;
use Departamento\Model\Departamento;
use Departamento\Model\DepartamentoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;


/**
 * Este controlador es el encargado de las acciones en el módulo Departamento : Listar , Agregar y editarlos registros agregados
 */
class DepartamentoController extends AbstractActionController
{
 // Add this property:
    private $container;
    private $DepartamentoTable;
    private $dbAdapter;

    // Add this constructor:
    public function __construct(ContainerInterface $container, DepartamentoTable  $DepartamentoTable, $dbAdapter)
    {
            $this->container = $container;
            $this->DepartamentoTable = $DepartamentoTable;
            $this->dbAdapter=$dbAdapter;
    }

    public function indexAction()
     {
            return new ViewModel([
                'depto' => $this->DepartamentoTable->fetchAll(),
            ]);

     }

      public function addAction()
    { 
        $form = new DepartamentoForm(); // mostrar formulario
        $form->get('submit')->setValue('Guardar');
       
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
         $departamento->exchangeArray($form->getData());
        
        $this->DepartamentoTable->saveDepto($departamento);
            //view helper
        return $this->redirect()->toRoute('departamento/listo');
         
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
            $departamento = $this->DepartamentoTable->getDepto($Cod_Departamento);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('departamento');
        }

        $form = new DepartamentoForm();
        $form->bind($departamento);
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

        $this->DepartamentoTable->UpdateDepto($departamento);

        // Redirect to album list
        return $this->redirect()->toRoute('departamento');
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