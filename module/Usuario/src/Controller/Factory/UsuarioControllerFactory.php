<?php
namespace Usuario\Controller\Factory;

use Interop\Container\ContainerInterface;
use Usuario\Controller\UsuarioController;
use Departamento\Model\DepartamentoTable;
use Sucursal\Model\SucursalTable;
use Zend\ServiceManager\Factory\FactoryInterface;
use Usuario\Model\UsuarioTable;
use Zend\Db\Adapter\AdapterInterface;


// Factory class
class UsuarioControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $UsuarioTable = $container->get(UsuarioTable::class);
        $SucursalTable =$container->get(SucursalTable::class);
        $DepartamentoTable =$container->get(DepartamentoTable::class);
        $dbAdapter = $container->get(AdapterInterface::class);
        $controller = new UsuarioController($UsuarioTable,$SucursalTable,$DepartamentoTable, $dbAdapter);
         
        return $controller;
    }
}