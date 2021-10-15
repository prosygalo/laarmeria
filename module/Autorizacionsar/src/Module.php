<?php
/*
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Autorizacionsar;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Sucursal\Model\SucursalTable;
use Tipodocumento\Model\TipodocumentoTable;


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
                Model\AutorizacionsarTable::class => function($container) {
                    $AutorizacionsartableGateway = $container->get(Model\TableGateway::class);
                    return new Model\AutorizacionsarTable($AutorizacionsartableGateway);
                },
                Model\TableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Autorizacionsar());
                    return new TableGateway('autorizaciones_sar', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AutorizacionsarController::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\AutorizacionsarController (
                        $container,
                        $container->get(Model\AutorizacionsarTable::class),
                        $container->get(SucursalTable::class),
                        $container->get(TipodocumentoTable::class),
                        $dbAdapter
                    );
                },
            ],
        ];
    }
}