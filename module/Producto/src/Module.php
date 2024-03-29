<?php
namespace Producto;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Sucursal\Model\SucursalTable;

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
                Model\ProductoTable::class => function($container) {
                    $tableGateway = $container->get(Model\TableGateway::class);
                    return new Model\ProductoTable($tableGateway);
                },
                Model\TableGateway::class => function ($container) {
                    $dbAdapter = $container->get('db2');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Producto());
                    return new TableGateway('productos', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ProductoController::class => function($container) {
                     $dbAdapter = $container->get('db2');
                    return new Controller\ProductoController (
                        $container->get(Model\ProductoTable::class),
                        $container->get(SucursalTable::class),
                        $dbAdapter
                    );
                },
            ],
        ];
    }
}