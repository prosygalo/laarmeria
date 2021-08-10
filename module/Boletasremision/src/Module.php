<?php
namespace Boletasremision;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Sucursal\Model\SucursalTable;
use Conductor\Model\ConductorTable;
use Unidadtransporte\Model\UnidadtransporteTable;
use Producto\Model\ProductoTable;
use Autorizacionsar\Model\AutorizacionsarTable;
use Usuario\Model\UsuarioTable;


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
                Model\BoletasremisionTable::class => function ($container) {
                    $BoletasremisionTableGateway = $container->get(Model\BoletasremisionTableGateway::class);
                    return new Model\BoletasremisionTable($BoletasremisionTableGateway);
                },
                Model\BoletasremisionTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Boletasremision());
                    return new TableGateway('boletas_guia_remision', $dbAdapter, null, $resultSetPrototype);
                },
                Model\DetalleTable::class => function ($container) {
                    $DetalleTableGateway = $container->get(Model\DetalleTableGateway::class);
                    return new Model\DetalleTable($DetalleTableGateway);
                },
                Model\DetalleTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Boletasremision());
                    return new TableGateway('detalle', $dbAdapter, null, $resultSetPrototype);
                },
            ],
         ];
    }
   public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\BoletasremisionController::class => function($container){
                  $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\BoletasremisionController(
                       $container,
                       $container->get(Model\BoletasremisionTable::class),
                       $container->get(Model\DetalleTable::class),
                       $container->get(SucursalTable::class),
                       $container->get(ConductorTable::class),
                       $container->get(UnidadtransporteTable::class),
                       $container->get(ProductoTable::class),
                       $container->get(AutorizacionsarTable::class),
                       $container->get(UsuarioTable::class),
                       $dbAdapter
                       
                    );
                },
            ],
        ];
    }
}