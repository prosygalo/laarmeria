<?php
namespace Usuario\Service\Factory;
 
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\AuthenticationService;
use Interop\Container\ContainerInterface;
use Usuario\Storage\AuthStorage;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;


class AuthenticationServiceFactory implements FactoryInterface
{
  /*Tenemos contraseñas hash con password_hash en la base de datos,
   * por lo que necesitamos algo de lógica a nivel de aplicación para comparar las contraseñas hash y simples
   */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $dbAdapter = $container->get(AdapterInterface::class);

        $credentialCallback = function ($passwordInDatabase, $Clave) {
          return password_verify($Clave, $passwordInDatabase);
        };

    /** Crear el adaptor de autenticacion */
    $AuthAdapter = new  CallbackCheckAdapter($dbAdapter,'usuarios', 'Correo', 'Clave', $credentialCallback //ejecutar la funcion para comparar contraseñas
    );
    
    $select = $AuthAdapter->getDbSelect();
    $select->where(['Estado' => 'Activo']);

    // Finalmente se crea el servicio
    $authService = new AuthenticationService($container->get(AuthStorage::class), $AuthAdapter);
    return $authService;
    }
    
}