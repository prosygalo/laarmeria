<?php
namespace Usuario\Controller;

use Usuario\Form\RegistroForm;
use Usuario\Form\RestablecerForm;
use Usuario\Model\Entidad;
use Usuario\Form\Filter\RegistroFormFilter;
use Usuario\Form\Filter\RestablecerFormFilter;
use Usuario\Form\Filter\EditarRegistroFilter;
use Usuario\Model\UsuarioTable;
use Sucursal\Model\SucursalTable;
use Departamento\Model\DepartamentoTable;
use Conductor\Model\ConductorTable;
use Zend\I18n\Validator as I18nValidator;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 * Este es el controlador responsable de  crear, listar, actualizar contraseña , rol y estado de los usuarios.
 */

class UsuarioController extends AbstractActionController
{
 // agregar propiedad:
    protected $UsuarioTable;
    protected $SucursalTable;
    protected $DepartamentoTable;
    protected $dbAdapter;

    // agregar constructor:
    public function __construct(UsuarioTable $UsuarioTable,SucursalTable $SucursalTable,DepartamentoTable $DepartamentoTable, $dbAdapter)
     {
            $this->UsuarioTable = $UsuarioTable;
            $this->dbAdapter = $dbAdapter;
            $this->SucursalTable= $SucursalTable;
            $this->DepartamentoTable = $DepartamentoTable;
     }

    /**
     * Este método muestra el listado de usuarios
     */
    public function indexAction()
     {
            return new ViewModel([
                'usuario' => $this->UsuarioTable->fetchAll(),
            ]);
     }

    /**
     * Este método muestra formulario para  agregar usuario admin
     */
     public function registroadminuserAction()
     {
        $user = $this->UsuarioTable->fetchAll();
        
        $form = new RegistroForm();
        $form->get('submit')->setValue('Crear usuario administrador');
        
        //Comprueba la existencia de usuarios en la base de datos
        
        //Datos estáticos
        $form->get('Cod_Empleado')->setValue('ADMIN1');
        $form->get('Departamento')->setValueOptions(['D23'=>'Tecnología']);
        $form->get('Sucursal')->setValueOptions(['Sucursal1'=>'Sucursal1']);
        $form->get('Correo')->setValue('admin@example.com');
        $form->get('ClaveView')->setValue('Secur1ty');
        $form->get('Usuario')->setValue('Admin');
        $form->get('Rol')->setValueOptions(['Admin'=>'Admin']);
        $form->get('Estado')->setValueOptions(['Activo'=>'Activo']);

        //Encriptación de contraseña
        $bcrypt = new Bcrypt();
        $Clavesegura = $bcrypt->create('Secur1ty');

        $request = $this->getRequest();
        if (! $request->isPost()) {
            return ['form' => $form];
        }
          
        //Enviar al tablegateway
        $data = [
            'Cod_Empleado'=>'ADMIN1',
            'Departamento'=>'D23',
            'Sucursal'=>'Sucursal1',
            'Correo'=>'admin@example.com',
            'Usuario'=>'Admin',
            'Clave'=>$Clavesegura,
            'Rol'=>'Admin',
            'Estado'=>'Activo',
        ];
        $this->UsuarioTable->insertUserAdmin($data);
        //Redireccionar al listado de usuarios
        return $this->redirect()->toRoute('login');
          
    } 


    /**
     * Este método muestra formulario para  agregar un nuevo usuario
     */
     public function registroAction()
     {
        
        $form = new RegistroForm();
        $form->get('submit')->setValue('Crear');
        $rowset = $this->SucursalTable->getSucursalListado(); //llenar select sucursal
        $form->get('Sucursal')->setValueOptions($rowset);
        $rowset2 = $this->DepartamentoTable->getDepartamentoListado(); //llenar select sucursal
        $form->get('Departamento')->setValueOptions($rowset2);

        //Verifica si la usuario ha enviado el formulario.
        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $form->setInputFilter(new \Usuario\Form\Filter\RegistroFormFilter($this->dbAdapter));
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $usuario = new Entidad();
        $usuario->exchangeArray($form->getData());
        //No permitir usuarios con el mismo correo electrónico
        $Correo = $this->request->getPost("Correo");
        $Correoexiste =$this->UsuarioTable->getUsuarioExistente($Correo); 
        if ($Correoexiste){
            return ['form' => $form];

        }
        //Encriptación de contraseña
        $Clave= $this->request->getPost("Clave");
        $bcrypt = new Bcrypt();
        $Clavesegura = $bcrypt->create($Clave);
        //data enviada desde el formulario
        $data = [
            'Cod_Empleado'=>$usuario->Cod_Empleado,
            'Sucursal'=>$usuario->Sucursal,
            'Departamento'=>$usuario->Departamento,
            'Correo'=>$usuario->Correo,
            'Usuario'=>$usuario->Usuario,
            'Clave'=>$Clavesegura,
            'Rol'=>$usuario->Rol,
            'Estado'=>$usuario->Estado,
        ];
        //Enviar al tablegateway
        $this->UsuarioTable->insertUsuario($data);
        //Redireccionar al listado de usuarios
        return $this->redirect()->toRoute('usuario');        
     }

     /**
     * Este método muestra formulario con los datos de un usuario existente, datos que pueden ser editados.
     */
     public function editAction()
    {
        $Cod_Usuario = (int) $this->params()->fromRoute('Cod_Usuario', 0);
       //Redireccionar si no hay un codigo entero
        if (0 === $Cod_Usuario) {
            return $this->redirect()->toRoute('usuario');
        }
        //Redireccionar si el usuario no existe
        try {
            $usuario = $this->UsuarioTable->getUsuario($Cod_Usuario);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('usuario');
        }
        //Instancia del formulario
        $form = new RegistroForm();
        $form->bind($usuario);
        $rowset = $this->SucursalTable->getSucursalListado(); //llenar select sucursal
        $form->get('Sucursal')->setValueOptions($rowset);
        $rowset2 = $this->DepartamentoTable->getDepartamentoListado(); //llenar select sucursal
        $form->get('Departamento')->setValueOptions($rowset2);
        $form->get('submit')->setAttribute('value', 'Actualizar');
       //Verifica si la usuario ha enviado el formulario.
        $request = $this->getRequest();
        $viewData = ['Cod_Usuario' => $Cod_Usuario, 'form' => $form];

       if (! $request->isPost()) {
            return $viewData;
        }

        $Validation = new EditarRegistroFilter();
        $form->setInputFilter($Validation->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        } 
         $data = [
            'Cod_Empleado'=>$usuario->Cod_Empleado,
            'Sucursal'=>$usuario->Sucursal,
            'Departamento'=>$usuario->Departamento,
            'Rol'=>$usuario->Rol,
            'Estado'=>$usuario->Estado,
        ];
        
        // Redireccionar al listado de usuarios
        $result = $this->UsuarioTable->updateUsuario($data, $Cod_Usuario);
        return $this->redirect()->toRoute('usuario');
        //return  new JsonModel($result);

    }


     /**
     * Este método muestra el perfil de un usuario
     */ 
     public function perfilAction()
     {
        $Cod_Usuario = $this->params()->fromRoute('Cod_Usuario');
        //return  new JsonModel($Cod_Usuario);
       if ($Cod_Usuario == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
       return new ViewModel([
                'user' => $this->UsuarioTable->getperfil($Cod_Usuario),
            ]);
     }
     
     /**
     * Este método muestra formulario para actualizar la contraseña usuario existente.
     */
     public function cambiarclaveAction()
     {
      
        $Cod_Usuario = (int)$this->params()->fromRoute('Cod_Usuario', -1);
        
        if ($Cod_Usuario<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }



        return $this->redirect()->toRoute('restablecerclave');
      
    }

    /**
     * Este método muestra formulario para actualizar la contraseña usuario existente.
     */
     public function restablecerclaveAction()
     {
        $Cod_Usuario = $this->params()->fromRoute('Cod_Usuario');
        //return  new JsonModel($Cod_Usuario);
       if ($Cod_Usuario == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new RestablecerForm();
        $form->get('submit')->setValue('Guardar');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $Validation = new RestablecerFormFilter();
        $form->setInputFilter($Validation->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        $usuario = new Entidad();
        $usuario->exchangeArray($form->getData());
        $Clave= $this->request->getPost("Clave");
        $bcrypt = new Bcrypt();
        $Clavesegura = $bcrypt->create($Clave);

        $data=['Clave'=>$Clavesegura];
        
        $this->UsuarioTable->updateClave($data, $Cod_Usuario); 
        return $this->redirect()->toRoute('usuario');        
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