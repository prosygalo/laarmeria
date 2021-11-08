<?php
namespace Notadebito;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Sucursal\Model\SucursalTable;
use Producto\Model\ProductoTable;
use Autorizacionsar\Model\AutorizacionsarTable;
use Usuario\Model\UsuarioTable;
use Cliente\Model\ClienteTable;


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
                Model\NotadebitoTable::class => function ($container) {
                    $NotadebitoTableGateway = $container->get(Model\NotadebitoTableGateway::class);
                    return new Model\NotadebitoTable($NotadebitoTableGateway);
                },
                Model\NotadebitoTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Notadebito());
                    return new TableGateway('notas_debito', $dbAdapter, null, $resultSetPrototype);
                },
                Model\DetalleNotadebitoTable::class => function ($container) {
                    $DetalleNotadebitoTableGateway = $container->get(Model\DetalleNotadebitoTableGateway::class);
                    return new Model\DetalleNotadebitoTable($DetalleNotadebitoTableGateway);
                },
                Model\DetalleNotadebitoTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Notadebito());
                    return new TableGateway('detalle_nota_debito', $dbAdapter, null, $resultSetPrototype);
                },
            ],
         ];
    }
   public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\NotadebitoController::class => function($container){
                  $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\NotadebitoController(
                       $container,
                       $container->get(Model\NotadebitoTable::class),
                       $container->get(Model\DetalleNotadebitoTable::class),
                       $container->get(SucursalTable::class),
                       $container->get(ProductoTable::class),
                       $container->get(AutorizacionsarTable::class),
                       $container->get(UsuarioTable::class),
                       $container->get(ClienteTable::class),
                       $dbAdapter
                       
                    );
                },
            ],
        ];
    }
}