<?php
namespace Conductor;

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
                Model\ConductorTable::class => function($container) {
                    $ConductortableGateway = $container->get(Model\TableGateway::class);
                    return new Model\ConductorTable($ConductortableGateway);
                },
                Model\TableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Conductor());
                    return new TableGateway('conductores', $dbAdapter, null, $resultSetPrototype);
                },
                
            ],
        ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ConductorController::class => function($container){
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\ConductorController(
                        $container->get(Model\ConductorTable::class),
                        $dbAdapter        
                    );
                },
            ],
        ];
    }
}