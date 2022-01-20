<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Tipodocumento\Controller;

use Tipodocumento\Form\TipodocumentoForm;
use Tipodocumento\Model\Tipodocumento;
use Tipodocumento\Model\TipodocumentoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * Este controlador es el encargado de las acciones en el módulo tipodocumento: listar, agregar y editar registros.
 */
class TipodocumentoController extends AbstractActionController
{
 // Add this property:
    private $dbAdapter;
    private $TipodocumentoTable;

    // Add this constructor:
    public function __construct(TipodocumentoTable $TipodocumentoTable, $dbAdapter)
     {
            $this->TipodocumentoTable = $TipodocumentoTable;
            $this->dbAdapter = $dbAdapter;
          
     }
    public function indexAction()
     {
            return new ViewModel([
                'tipodocumento' => $this->TipodocumentoTable->fetchAll(),
            ]);
     }

      public function addAction()
    {       
            $form = new TipodocumentoForm();
            $form->get('submit')->setValue('Guardar');
            
            $request = $this->getRequest();

            if (! $request->isPost()) {
                return ['form' => $form];
            }

            $form->setInputFilter(new  \Tipodocumento\Form\Filter\TipodocumentoFilter($this->dbAdapter));
            $form->setData($request->getPost());

            if (! $form->isValid()) {
                return ['form' => $form];
            }
            $tipodocumento = new Tipodocumento();
            $tipodocumento->exchangeArray($form->getData());
            $this->TipodocumentoTable->inserTipoDocumento($tipodocumento);
            //view helper
            return $this->redirect()->toRoute('tipodocumento/listo');
       
    }
   
    public function editAction()
    {
        $Cod_Documento = $this->params()->fromRoute('Cod_Documento');

        if (!$Cod_Documento) {
            return $this->redirect()->toRoute('tipodocumento/add');
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $tipodocumento = $this->TipodocumentoTable->getTipoDocumento($Cod_Documento);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('tipodocumento');
        }

        $form = new TipodocumentoForm();
        $form->bind($tipodocumento);
        $form->get('submit')->setAttribute('value', 'Actualizar');

        $request = $this->getRequest();
        $viewData = ['Cod_Documento' => $Cod_Documento, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter(new  \Tipodocumento\Form\Filter\TipodocumentoEditFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->TipodocumentoTable->updateTipodocumento($tipodocumento);

        // Redirect to album list
        return $this->redirect()->toRoute('tipodocumento');

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