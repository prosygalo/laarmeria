<?php
namespace Unidadtransporte;

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
                Model\UnidadtransporteTable::class => function($container) {
                    $UnidadtransportetableGateway = $container->get(Model\TableGateway::class);
                    return new Model\UnidadtransporteTable($UnidadtransportetableGateway);
                },
                Model\TableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Unidadtransporte());
                    return new TableGateway('unidades_de_transporte', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\UnidadtransporteController::class => function($container){
                    $dbAdapter = $container->get(AdapterInterface::class);
                        return new Controller\UnidadtransporteController (
                           $container->get(Model\UnidadtransporteTable::class),
                           $dbAdapter
                    );
                },
            ],
        ];
    }
}