<?php
/*
*
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Constanciaretencion;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Sucursal\Model\SucursalTable;
use Autorizacionsar\Model\AutorizacionsarTable;
use Proveedor\Model\ProveedorTable;
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
                Model\ConstanciaretencionTable::class => function ($container) {
                    $ConstanciaretencionTableGateway = $container->get(Model\ConstanciaretencionTableGateway::class);
                    return new Model\ConstanciaretencionTable($ConstanciaretencionTableGateway);
                },
                Model\ConstanciaretencionTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Constanciaretencion());
                    return new TableGateway('Constancias_de_retencion', $dbAdapter, null, $resultSetPrototype);
                },
            ],
         ];
    }
   public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ConstanciaretencionController::class => function($container){
                  $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\ConstanciaretencionController(
                       $container,
                       $container->get(Model\ConstanciaretencionTable::class),
                       $container->get(SucursalTable::class),
                       $container->get(AutorizacionsarTable::class),
                       $container->get(ProveedorTable::class),
                       $container->get(UsuarioTable::class),
                       $dbAdapter
                    );
                },
            ],
        ];
    }
}