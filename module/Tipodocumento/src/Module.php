<?php
namespace Tipodocumento;

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
                Model\TipodocumentoTable::class => function($container) {
                    $TipodocumentotableGateway = $container->get(Model\TableGateway::class);
                    return new Model\TipodocumentoTable($TipodocumentotableGateway);
                },
                Model\TableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Tipodocumento());
                    return new TableGateway('tipo_documento_fiscal', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\TipodocumentoController::class => function($container){
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\TipodocumentoController(
                        $container->get(Model\TipodocumentoTable::class),
                        $dbAdapter        
                    );
                },
            ],
        ];
    }
}