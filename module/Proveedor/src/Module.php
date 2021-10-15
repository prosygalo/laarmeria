<?php
namespace Proveedor;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }


   public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ProveedorTable::class => function($container) {
                    $ProveedortableGateway = $container->get(Model\TableGateway::class);
                    return new Model\ProveedorTable($ProveedortableGateway);
                },
                Model\TableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Proveedor());
                    return new TableGateway('proveedores', $dbAdapter, null, $resultSetPrototype);
                },
                
            ],
        ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ProveedorController::class => function($container){
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\ProveedorController(
                        $container->get(Model\ProveedorTable::class),
                        $dbAdapter        
                    );
                },
            ],
        ];
    }
}