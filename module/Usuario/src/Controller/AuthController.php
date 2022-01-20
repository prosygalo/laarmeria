<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Usuario\Controller;

use Usuario\Form\LoginForm;
use Usuario\Model\Entidad;
use Usuario\Form\Filter\LoginFormFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\I18n\Validator as I18nValidator; 


/**
 * Este controlador es responsable de permitir que el usuario inicie y cierre la sesión..
 */
class AuthController extends AbstractActionController
{ 
   
    protected $authService;

    /**
     * Inyectaremos authService via factory
     */
   public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Autenticación del usuarios con las credenciales dadas.
     */
     public function loginAction()
    {
        if ($this->authService->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }
        $form = new LoginForm();
        $form->get('submit')->setValue('Inicie sesión');
        $request = $this->getRequest();
        //Verifica si la usuario ha enviado el formulario.
        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $Validation = new LoginFormFilter();
        $form->setInputFilter($Validation->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $Correo =  $this->request->getPost("Correo");
        $Clave  =  $this->request->getPost("Clave");
                      
        //Establecemos como datos a autenticar los que nos llegan del formulario
        $this->authService->getAdapter()->setIdentity($Correo);
        $this->authService->getAdapter()->setCredential($Clave);

        //Le decimos al servicio de autenticación que lleve a cabo la identificacion  
        $result = $this->authService->authenticate();

         switch ($result->getCode()) {
            case Result::FAILURE_IDENTITY_NOT_FOUND:
            /** Si el resultado tiene credenciales no existentes **/
               return ['form' => $form];
            break;

            case Result::FAILURE_CREDENTIAL_INVALID:
            /** Si el resultado del login es falso, es decir no son correctas las credenciales **/
                 return ['form' => $form];
            break;

            case Result::SUCCESS:
             /**Si el resultado del login es verdadero, es decir son correctas las credenciales**/
             if($result->isvalid())
               {
                $resultRow = $this->authService->getAdapter()->getResultRowObject();
                $this->authService->getStorage()->write(
                    array(
                        'Cod_Usuario'   => $resultRow->Cod_Usuario,
                        'Usuario'       => $resultRow->Usuario,
                        'Rol'           => $resultRow->Rol,
                        'Sucursal'      => $resultRow->Sucursal,
                        'Departamento'  => $resultRow->Departamento,
                        'Correo'        => $Correo,
                        'Estado'        => $resultRow->Estado,
                        'ip_address'    => $this->getRequest()->getServer('REMOTE_ADDR'),
                        'user_agent'    => $request->getServer('HTTP_USER_AGENT'),
                         )
                    );
                
                return $this->redirect()->toRoute('home');
            }else{

               return ['form' => $form];
              }
            break;

            default:
            /**  si el resultado es diferente a los anteriores **/
                return $this->redirect()->toRoute('login'); 
            break;
        }
      
        
    }
    

    /**
     * La acción "cerrar sesión" realiza la operación de cierre de sesión
     */
   public function logoutAction()
    {
       
        $this->authService->getStorage()->clear(); 
        return $this->redirect()->toRoute('home');
    }
     
     public function denegadoAction()
    {   
      //redirecciona a la vista  de error
        return new ViewModel([
                'Message' => 'Lo sentimos, no tiene permisos de acceso',
        ]);
    }
    

}
