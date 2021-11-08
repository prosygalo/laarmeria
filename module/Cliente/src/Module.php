<?php
namespace Cliente;

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
                Model\ClienteTable::class => function($container) {
                    $ClientetableGateway = $container->get(Model\TableGateway::class);
                    return new Model\ClienteTable($ClientetableGateway);
                },
                Model\TableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Cliente());
                    return new TableGateway('clientes', $dbAdapter, null, $resultSetPrototype);
                },
                
            ],
        ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ClienteController::class => function($container){
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\ClienteController(
                        $container->get(Model\ClienteTable::class),
                        $dbAdapter        
                    );
                },
            ],
        ];
    }
}