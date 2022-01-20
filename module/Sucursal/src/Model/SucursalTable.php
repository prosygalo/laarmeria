<?php
namespace Sucursal\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;


class SucursalTable
{
    private $SucursalTableGateway;

    public function __construct(TableGatewayInterface $SucursalTableGateway)
     {
               $this->SucursalTableGateway = $SucursalTableGateway;
     }

     public function fetchAll()
     {
               
               return $this->SucursalTableGateway->select();
     }

    public function getSucursal($Cod_Sucursal)
     {
                $Cod_Sucursal = $Cod_Sucursal;

                $rowset = $this->SucursalTableGateway->select(['Cod_Sucursal' => $Cod_Sucursal]);
                $row = $rowset->current();
                return $row;
     }
     public function getSucursalMembrete($Cod_Sucursal)
     {
                $Cod_Sucursal = $Cod_Sucursal;
                $rowset=$this->SucursalTableGateway->getSql()->select();
                $rowset->columns(['Cod_Sucursal','Direccion','Nombre_Sucursal','Telefono','RTN','Correo']);
                $rowset->where(['Cod_Sucursal' => $Cod_Sucursal]);
                $resultSet=$this->SucursalTableGateway->selectWith($rowset);
                return $resultSet;
     }
    public function getSucursalListado(){
                $rowset = $this->SucursalTableGateway->getSql()->select();
                $rowset->columns(array('Cod_Sucursal','Nombre_Sucursal'));
                $resultSet = $this->SucursalTableGateway->selectWith($rowset);
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Sucursal] = $row->Cod_Sucursal;
                }
                   return $data;
                 
    }
    public function getSucursalRemitente($Cod_Sucursal){
                $Cod_Sucursal = $Cod_Sucursal;
                $rowset = $this->SucursalTableGateway->getSql()->select();
                $rowset->columns(array('Cod_Sucursal','Nombre_Sucursal','Direccion'));
                 $rowset->where(['Cod_Sucursal' => $Cod_Sucursal]);
                $resultSet = $this->SucursalTableGateway->selectWith($rowset);
                return $resultSet;

    }
     public function getDireccion($Cod_Sucursal){
                $Cod_Sucursal = $Cod_Sucursal;
                $rowset = $this->SucursalTableGateway->getSql()->select();
                $rowset->columns(array('Cod_Sucursal','Nombre_Sucursal','Direccion'));
                $rowset->where(['Cod_Sucursal' => $Cod_Sucursal]);
                $resultSet = $this->SucursalTableGateway->selectWith($rowset);
                return $resultSet;
                 
    }
    public function getSucursalEstado($Cod_Sucursal){
                $Cod_Sucursal = $Cod_Sucursal;
                $rowset = $this->SucursalTableGateway->getSql()->select();
                $rowset->columns(array('Estado'));
                $resultSet = $this->SucursalTableGateway->selectWith($rowset);
                return $resultSet;

    }
    public function getSucursalDestino(){

                $rowset = $this->SucursalTableGateway->getSql()->select();
                $rowset->columns(array('Cod_Sucursal','Nombre_Sucursal'));
                $resultSet = $this->SucursalTableGateway->selectWith($rowset);
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Sucursal] = $row->Cod_Sucursal;
                }
                   return $data;
                 
    }
    public function getSucursalDireccionListado(){

                $rowset = $this->SucursalTableGateway->getSql()->select();
                $rowset->columns(array('Cod_Sucursal','Direccion'));
                $resultSet = $this->SucursalTableGateway->selectWith($rowset);
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Direccion] = $row->Direccion;
                }
                   return $data;
                 
    }
    public function saveSucursal(Sucursal $sucursal)
     {
             $data = [
                'Cod_Sucursal' => $sucursal->Cod_Sucursal,
                'Nombre_Sucursal'  => $sucursal->Nombre_Sucursal,
                'RTN'  => $sucursal->RTN,
                'Direccion'  => $sucursal->Direccion,
                'Telefono'  => $sucursal->Telefono,
                'Correo'  => $sucursal->Correo,
                'Estado' =>$sucursal->Estado,
             ];
           
             $Cod_Sucursal = $sucursal->Cod_Sucursal;
              
           if ($Cod_Sucursal != null) {
               $this->SucursalTableGateway->insert($data);
               return;
        
            }
     }
     public function updateSucursal(Sucursal $sucursal)
    {        
            $data = [
                'Cod_Sucursal' => $sucursal->Cod_Sucursal,
                'Nombre_Sucursal'  => $sucursal->Nombre_Sucursal,
                'RTN'  => $sucursal->RTN,
                'Direccion'  => $sucursal->Direccion,
                'Telefono'  => $sucursal->Telefono,
                'Correo'  => $sucursal->Correo,
                'Estado' =>$sucursal->Estado,
               ];

                $Cod_Sucursal = $sucursal->Cod_Sucursal;

                try {
                    
                    $this->getSucursal($Cod_Sucursal);
                } catch (RuntimeException $e) {
                     throw new RuntimeException(sprintf(
                        'No se puede actualizar sucursal'
                         
                    ));
                    return false;
                }

                $this->SucursalTableGateway->update($data, ['Cod_Sucursal' => $Cod_Sucursal]);
                return;
    }


}