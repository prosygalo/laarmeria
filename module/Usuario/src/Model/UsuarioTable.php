<?php

namespace Usuario\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;


class UsuarioTable
{
    private $UsuarioTableGateway;

    public function __construct(TableGatewayInterface $UsuarioTableGateway)
    {
               
        $this->tableGateway = $UsuarioTableGateway;
    }

    public function fetchAll()
    {

        return $this->tableGateway->select();
              
     }

    public function getUsuario($Cod_Usuario)
     {
        $Cod_Usuario = $Cod_Usuario;
        $rowset = $this->tableGateway->select(['Cod_Usuario' => $Cod_Usuario]);
        $row = $rowset->current();
        if (! $row) {
            return false;
        }
            return $row;
     }
     public function getUsuarioBoleta($Cod_Usuario)
     {
        $Cod_Usuario = $Cod_Usuario;
        $rowset = $this->tableGateway->getSql()->select();
        $rowset->columns(['Cod_Usuario','Usuario']);
        $rowset->where(['Cod_Usuario' =>$Cod_Usuario]);
        $resultSet = $this->tableGateway->selectWith($rowset);
        return $resultSet;
     }
     public function getUsuarioExistente($Correo)
     {
        $Correo = $Correo;
        $rowset = $this->tableGateway->select(['Correo' => $Correo]);
        $row = $rowset->current();
        if (! $row) {
            return false;
        }
            return $row;
     }
      public function getClave($Correo)
     {
        $Correo = $Correo;
        $rowset = $this->tableGateway->select(['Correo' => $Correo]);
        $row = $rowset->current();
        if (! $row) {
            return false;
        }
            return $row;
     }
     
     
     public function insertUserAdmin(array $data)
     {
       
        $this->tableGateway->insert($data);
            return;
     }
     public function insertUsuario(array $data)
     {

        $this->tableGateway->insert($data);
            return;
     }
     
     public function updateUsuario(array  $data, $Cod_Usuario)
    {          
        $Cod_Usuario = $Cod_Usuario;      
        $this->tableGateway->update($data, ['Cod_Usuario' => $Cod_Usuario]);
            return;
    }
    
    public function updateClave(array $data, $Cod_Usuario)
    {  
                      
        $Cod_Usuario = $Cod_Usuario;      
        $this->tableGateway->update($data, ['Cod_Usuario' => $Cod_Usuario]);
            return;

    }
    public function getPerfil($Cod_Usuario)
    {          
        $Cod_Usuario = $Cod_Usuario;
        $rowset=$this->tableGateway->getSql()->select();
        $rowset->columns(['Cod_Usuario','Cod_Empleado','Usuario','Correo','Estado','Rol','Fecha_Ingreso']);
        $rowset->where(['Cod_Usuario' =>$Cod_Usuario]);
        $resultSet=$this->tableGateway->selectWith($rowset);
            return $resultSet;
               
    }

}