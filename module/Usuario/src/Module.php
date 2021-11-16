<?php
namespace Usuario;

use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Usuario\Model\UsuarioTable;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Application\Controller\IndexController;
use Autorizacionsar\Controller\AutorizacionsarController;
use Boletasremision\Controller\BoletasremisionController;
use Boletacompra\Controller\BoletacompraController;
use Conductor\Controller\ConductorController;
use Departamento\Controller\DepartamentoController;
use Producto\Controller\ProductoController;
use Sucursal\Controller\SucursalController;
use Unidadtransporte\Controller\UnidadtransporteController;
use Proveedor\Controller\ProveedorController;
use constanciaretencion\Controller\ConstanciaretencionController;
use Usuario\Controller\AuthController;
use Usuario\Controller\UsuarioController;
use Notadebito\Controller\NotadebitoController;
use Cliente\Controller\ClienteController;


class Module implements ConfigProviderInterface
{
    public function onBootstrap($e)
    {
     $eventManager = $e->getApplication()->getEventManager();
     $eventManager->attach(MvcEvent::EVENT_DISPATCH,[$this, 'initAcl'],100);
    
    }
    public function initAcl(MvcEvent $e)
    {
       $application = $e->getApplication();
       $services = $application->getServiceManager();
       $acl = $services->get(Acl::class);

       $matches = $e->getRouteMatch();

       $controllerClass = $matches->getParam('controller');
       $controllerArray = explode("\\", $controllerClass);

       $module =  strtolower($controllerArray[0]);
       $controller = strtolower($controllerArray[2]);
       $action = $matches->getParam('action');
       $resourceName = substr($module . ':' . $controller, 0,-10);

       if ( !$acl->isAllowed($this->getRole($services), $resourceName, $action))
       {/**Si el usuario no tiene permiso y esta intentando accede a una pagina sin privilegio, entonces lo redireccionan al  controlador  auth accion  denegado */
        $e->getResponse()->setStatusCode(403);
        $matches->setParam('controller',Controller\AuthController::class);
        $matches->setParam('action','denegado'); 
       }
    }

    public function getConfig() 
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() 
    {
        return [
           'factories' => [
                Model\UsuarioTable::class => function($container) {
                    $UsuarioTableGateway = $container->get(Model\UsuarioTableGateway::class);
                    return new Model\UsuarioTable($UsuarioTableGateway);
                },
                Model\UsuarioTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Entidad());
                    return new TableGateway('usuarios', $dbAdapter, null, $resultSetPrototype);
                },
              
                Acl::class=> function ($sm){
                    $acl= new Acl();   
                 /**agregar  los roles con la herencia de controles de acceso*/
                    $acl->addRole(new Role('Publico'))
                    /**El usuario miembro hereda controles de acceso de invitado*/
                    ->addRole(new Role('Miembro'), 'Publico')
                    /**El usuario especial hereda controles de acceso de miembro*/
                    ->addRole(new Role('Admin'), 'Miembro')
                    /**El administrador no hereda controles de acceso pues tiene acceso a todo*/
                    ->addRole(new Role('Superadmin'));
                    /*
                     *-modulo application,controlador index 
                     *-modulo autorizacionsar,controlador autorizacionsar 
                     *-modulo boletasremision ,controlador boletasremision
                     *-modulo boletasremision ,controlador boletacompra
                     *-modulo boletasremision ,controlador constanciaretencion
                     *-modulo boletasremision ,controlador tipodocumento
                     *-modulo conductor ,controlador conductor  
                     *-modulo departamento ,controlador departamento 
                     *-modulo sucursal ,controlador  sucursal 
                     *-modulo producto ,controlador producto 
                     *-modulo unidadtransporte ,controlador unidadtransporte
                     *-modulo usuario ,controlador usuario 
                     *-modulo usuario,controlador auth 
                     *Creando privilegios
                     */
                     return $acl->addResource(new Resource('application:index'))
                    ->addResource(new Resource('autorizacionsar:autorizacionsar'))
                    ->addResource(new Resource('boletasremision:boletasremision'))
                    ->addResource(new Resource('boletacompra:boletacompra'))
                    ->addResource(new Resource('tipodocumento:tipodocumento'))
                    ->addResource(new Resource('conductor:conductor'))
                    ->addResource(new Resource('departamento:departamento'))
                    ->addResource(new Resource('producto:producto'))
                    ->addResource(new Resource('proveedor:proveedor'))
                    ->addResource(new Resource('sucursal:sucursal'))
                    ->addResource(new Resource('unidadtransporte:unidadtransporte'))
                    ->addResource(new Resource('constanciaretencion:constanciaretencion'))
                    ->addResource(new Resource('usuario:usuario'))
                    ->addResource(new Resource('usuario:auth'))
                    ->addResource(new Resource('notadebito:notadebito'))
                    ->addResource(new Resource('cliente:cliente'))
                     /**
                      Permitir al público tener acceso a las siguientes acciones
                      */
                    ->allow('Publico','application:index')
                    ->allow('Publico','usuario:auth',['login'])
                    ->allow('Publico','usuario:usuario',['registroadminuser'])
                    ->allow('Publico','boletasremision:boletasremision',['pdf','reporte'])
                    ->allow('Publico','boletacompra:boletacompra',['pdf','reporte'])
                    ->allow('Publico','constanciaretencion:constanciaretencion',['pdf','reporte'])
                    ->allow('Publico','notadebito:notadebito',['pdf','reporte'])
                   
                     /* Permitir a miembros  acceder a inicio, emisión de documento fiscales, vista, reporte del documento emitido,perfil y cierre de sesión.
                     */
                    ->allow('Miembro','usuario:auth')
                    ->allow('Miembro','usuario:usuario',['perfil'])
                    ->allow('Miembro','boletasremision:boletasremision',['add','vencimientofecha','expirocorrelativo','errorautorizacion','detalle','pdf','reporte','listo','error','sucdes'])
                     ->allow('Miembro','constanciaretencion:constanciaretencion',['add','vencimientofecha','expirocorrelativo','errorautorizacion','detalle','pdf','reporte','listo','error'])
                    ->allow('Miembro','boletacompra:boletacompra',['add','pre','vencimientofecha','expirocorrelativo','errorautorizacion','detalle','pdf','reporte','listo','error'])
                    ->allow('Miembro','notadebito:notadebito',['add','vencimientofecha','expirocorrelativo','errorautorizacion','detalle','pdf','reporte','listo','error','sucdes'])
                    /**
                     Permitir a usuario admin el acceso a todos los recursos con exepción el módulo usuarios.
                    */
                    ->allow('Admin','boletasremision:boletasremision',['index'])
                    ->allow('Admin','boletacompra:boletacompra',['index'])
                    ->allow('Admin','constanciaretencion:constanciaretencion',['index'])
                    ->allow('Admin','notadebito:notadebito',['index'])
                    ->allow('Admin','autorizacionsar:autorizacionsar',['index','add','listo','error'])
                    ->allow('Admin','conductor:conductor',['index','add','edit','listo','error'])
                    ->allow('Admin','cliente:cliente',['index','add','edit','listo','error'])
                    ->allow('Admin','departamento:departamento',['index','add','edit','listo','error'])
                    ->allow('Admin','producto:producto',['index','add','edit','listo','error'])
                    ->allow('Admin','proveedor:proveedor',['index','add','edit','listo','error'])
                    ->allow('Admin','sucursal:sucursal',['index','add','edit','listo','error'])
                    ->allow('Admin','unidadtransporte:unidadtransporte',['index','add','edit','listo','error'])
                    /**
                       Permitir a usuario Superadmin el acceso a todos los recursos.
                    */
                    ->allow('Superadmin');
                }
            ],

        ];
    }

    public function getRole($sm)
    {
       $auth = $sm->get(AuthenticationService::class);
       if ($auth->hasIdentity()){   
          return $auth->getIdentity()['Rol'];
       }else{
           return   'Publico';
       }
       
    }
}