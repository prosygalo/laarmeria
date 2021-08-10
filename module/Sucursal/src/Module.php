<?php
namespace Sucursal;

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
                Model\SucursalTable::class => function($container) {
                    $SucursalTableGateway = $container->get(Model\SucursalTableGateway::class);
                    return new Model\SucursalTable($SucursalTableGateway);
                },
                Model\SucursalTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Sucursal());
                    return new TableGateway('sucursales', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\SucursalController::class => function($container){
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\SucursalController (
                        $container->get(Model\SucursalTable::class),
                        $dbAdapter
                    );
                },
            ],
        ];
    }
}