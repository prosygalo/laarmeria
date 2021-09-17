<?php
namespace Boletacompra;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Sucursal\Model\SucursalTable;
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
                Model\BoletacompraTable::class => function ($container) {
                    $BoletacompraTableGateway = $container->get(Model\BoletacompraTableGateway::class);
                    return new Model\BoletacompraTable($BoletacompraTableGateway);
                },
                Model\BoletacompraTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Boletacompra());
                    return new TableGateway('boletas_compra', $dbAdapter, null, $resultSetPrototype);
                },
                Model\DetallecompraTable::class => function ($container) {
                    $DetallecompraTableGateway = $container->get(Model\DetallecompraTableGateway::class);
                    return new Model\DetallecompraTable($DetallecompraTableGateway);
                },
                Model\DetallecompraTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Boletacompra());
                    return new TableGateway('detalle_compra', $dbAdapter, null, $resultSetPrototype);
                },
            ],
         ];
    }
   public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\BoletacompraController::class => function($container){
                  $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\BoletacompraController(
                       $container,
                       $container->get(Model\BoletacompraTable::class),
                       $container->get(Model\DetallecompraTable::class),
                       $container->get(SucursalTable::class),
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