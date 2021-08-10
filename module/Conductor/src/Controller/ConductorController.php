<?php
namespace Conductor\Controller;

use Conductor\Form\ConductorForm;
use Conductor\Model\Conductor;
use Conductor\Model\ConductorTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * This controller is responsible for letting the user to log in and log out.
 */
class ConductorController extends AbstractActionController
{
 // Add this property:
    private $dbAdapter;
    private $table;

    // Add this constructor:
    public function __construct(ConductorTable $table, $dbAdapter)
     {
            $this->table = $table;
            $this->dbAdapter = $dbAdapter;
          
     }

    public function indexAction()
     {
            return new ViewModel([
                'conductor' => $this->table->fetchAll(),
            ]);
     }

      public function vercodigoAction(){
        //Recogemos el valor de la ruta
        $Cod_Conductor=$this->params()->fromRoute("Cod_Conductor",null);
        /*
        *Le podemos indicar el tipo de dato que va a ser
        *$id=(int)$this->params()->fromRoute("id",null);
        */
         
        $nombre="Producto número: ".$Cod_Conductor;
        return new ViewModel(
                array("nombre"=>$nombre)
                );
    }
      

      public function addAction()
    {
        $form = new ConductorForm();
        $form->get('submit')->setValue('Guardar');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $form->setInputFilter(new  \Conductor\Form\Filter\ConductorFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        $conductor = new Conductor();
        $conductor->exchangeArray($form->getData());
        $this->table->insertConductor($conductor);
        return $this->redirect()->toRoute('conductor/listo');
    }
   
    public function editAction()
    {
        $Cod_Conductor = $this->params()->fromRoute('Cod_Conductor');

        if (!$Cod_Conductor) {
            return $this->redirect()->toRoute('conductor/add');
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $conductor = $this->table->getConductor($Cod_Conductor);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('conductor');
        }

        $form = new ConductorForm();
        $form->bind($conductor);
        $form->get('submit')->setAttribute('value', 'Actualizar');

        $request = $this->getRequest();
        $viewData = ['Cod_Conductor' => $Cod_Conductor, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter(new  \Conductor\Form\Filter\ConductorEditFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->updateConductor($conductor);

        // Redirect to album list
        return $this->redirect()->toRoute('conductor');

    }
        

  /*  public function deleteAction()
    {
            $Cod_Conductor = $this->params()->fromRoute('Cod_Conductor');
            
            if (!$Cod_Conductor) {
                return $this->redirect()->toRoute('conductor');
            }

            $request = $this->getRequest();
            if ($request->isPost()) {
                $del = $request->getPost('del', 'Cancelar');

                if ($del == 'Borrar') {
                    $Cod_Conductor=$request->getPost('Cod_Conductor');
                    $this->table->deleteConductor($Cod_Conductor);
                }

                // Redirect to list 
                return $this->redirect()->toRoute('conductor');
            }
             return [
            'Cod_Conductor'    => $Cod_Conductor,
            'Cond' => $this->table->getConductor($Cod_Conductor),
        ];
            
    }*/
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