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
use Conductor\Controller\ConductorController;
use Departamento\Controller\DepartamentoController;
use Producto\Controller\ProductoController;
use Sucursal\Controller\SucursalController;
use Unidadtransporte\Controller\UnidadtransporteController;
use Usuario\Controller\AuthController;
use Usuario\Controller\UsuarioController;


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
                    $acl->addRole(new Role('Invitado'))
                    /**El usuario miembro hereda controles de acceso de invitado*/
                    ->addRole(new Role('Miembro'), 'Invitado')
                    /**El usuario especial hereda controles de acceso de miembro*/
                    ->addRole(new Role('Especial'), 'Miembro')
                    /**El administrador no hereda controles de acceso pues tiene acceso a todo*/
                    ->addRole(new Role('Admin'));
                    /*
                     *-modulo application,controlador index 
                     *-modulo autorizacionsar,controlador autorizacionsar 
                     *-modulo boletasremision ,controlador boletasremision  
                     *-modulo conductor ,controlador conductor  
                     *-modulo departamento ,controlador departamento 
                     *-modulo sucursal ,controlador  sucursal 
                     *-modulo producto ,controlador producto 
                     *-modulo unidadtransporte ,controlador unidadtransporte
                     *-modulo usuario ,controlador usuario 
                     *-modulo usuario,controlador auth 
                     *Creando privilegios
                     *-permitir a invitado acceder a la pagina de inicio y auth ecepto cierre de sesión
                     *-permitit a miembro acceder a la pagina de inicio, auth y boletas de remision ecepto el index
                     *-permitir a miembro especial acceder a inicio, boletasremision, conductor, departamento,  producto, sucursal, unidadtransporte, auth
                     *-permitir a usuario admin el acceso a todos los recursos
                     */
                     return $acl->addResource(new Resource('application:index'))
                    ->addResource(new Resource('autorizacionsar:autorizacionsar'))
                    ->addResource(new Resource('boletasremision:boletasremision'))
                    ->addResource(new Resource('conductor:conductor'))
                    ->addResource(new Resource('departamento:departamento'))
                    ->addResource(new Resource('producto:producto'))
                    ->addResource(new Resource('sucursal:sucursal'))
                    ->addResource(new Resource('unidadtransporte:unidadtransporte'))
                    ->addResource(new Resource('usuario:usuario'))
                    ->addResource(new Resource('usuario:auth'))
                    ->allow('Invitado','application:index')
                    ->allow('Invitado','usuario:auth',['login'])
                    ->allow('Invitado','usuario:usuario',['registroadminuser'])
                    ->allow('Invitado','boletasremision:boletasremision',['pdf','reporte'])
                    ->allow('Miembro','usuario:auth')
                    ->allow('Miembro','usuario:usuario',['perfil'])
                    ->allow('Miembro','boletasremision:boletasremision',['add','pre','vencimientofecha','expirocorrelativo','errorautorizacion','detalle','pdf','reporte','listo','error'])
                    ->allow('Especial','boletasremision:boletasremision',['index'])
                    ->allow('Especial','autorizacionsar:autorizacionsar',['index','add','listo','error'])
                    ->allow('Especial','conductor:conductor',['index','add','edit','listo','error'])
                    ->allow('Especial','departamento:departamento',['index','add','edit','listo','error'])
                    ->allow('Especial','producto:producto',['index','add','edit','listo','error'])
                    ->allow('Especial','sucursal:sucursal',['index','add','edit','listo','error'])
                    ->allow('Especial','unidadtransporte:unidadtransporte',['index','add','edit','listo','error'])
                    ->allow('Admin');
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
           return   'Invitado';
       }
       
    }
}