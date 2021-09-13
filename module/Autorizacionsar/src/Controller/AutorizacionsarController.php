<?php
namespace Autorizacionsar\Controller;

use Autorizacionsar\Form\AutorizacionsarForm;
use Autorizacionsar\Model\Autorizacionsar;
use Autorizacionsar\Model\AutorizacionsarTable;
use Sucursal\Model\SucursalTable;
use Tipodocumento\Model\TipodocumentoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;

/**
 * This controller is responsible for 
 */

class AutorizacionsarController extends AbstractActionController
{
 // Add this property:
    private $container;
    private $table;
    private $SucursalTable; 
    private $TipodocumentoTable;
    private $dbAdapter;
    

    // Add this constructor:
     public function __construct(ContainerInterface $container,AutorizacionsarTable $table, SucursalTable $SucursalTable, TipodocumentoTable $TipodocumentoTable, $dbAdapter)
     {
            $this->container = $container;
            $this->table = $table;
            $this->SucursalTable = $SucursalTable;
            $this->TipodocumentoTable=$TipodocumentoTable;
            $this->dbAdapter = $dbAdapter;
     }
    public function indexAction()
     {
            return new ViewModel([
                'auto' => $this->table->fetchAll(),
            ]);
     }
    public function addAction()
    {
            $form = new AutorizacionsarForm();
            $form->get('submit')->setValue('Guardar');
            $rowset = $this->SucursalTable->getSucursalListado(); //llenar select sucursal 
            $form->get('Sucursal')->setValueOptions($rowset); 
            $rowset2 = $this->TipodocumentoTable->getTipodocumentoSelect(); //llenar select sucursal 
            $form->get('Tipo_de_Documento')->setValueOptions($rowset2); 
        
            $request = $this->getRequest();

            if (! $request->isPost()) {
                return ['form' => $form];
            }

            $form->setInputFilter(new  \Autorizacionsar\Form\Filter\AutorizacionsarFilter($this->dbAdapter));
            $form->setData($request->getPost());

            if (! $form->isValid()) {
                return ['form' => $form];
            }
            $autorizacionsar = new autorizacionsar();
            $autorizacionsar->exchangeArray($form->getData());
            $this->table->insertAuto($autorizacionsar);
            //view helper
            return $this->redirect()->toRoute('autorizacionsar/listo');
            
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