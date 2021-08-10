<?php
namespace Usuario\Controller\Factory;

use Interop\Container\ContainerInterface;
use Usuario\Controller\UsuarioController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Usuario\Model\UsuarioTable;
use Zend\Db\Adapter\AdapterInterface;


// Factory class
class UsuarioControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $UsuarioTable = $container->get(UsuarioTable::class);
        $dbAdapter = $container->get(AdapterInterface::class);
        $controller = new UsuarioController($UsuarioTable, $dbAdapter);
         
        return $controller;
    }
}