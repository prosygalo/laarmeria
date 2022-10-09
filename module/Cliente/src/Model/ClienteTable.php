<?php

namespace Cliente\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;


class ClienteTable
{
     private $ClientetableGateway;

     public function __construct(TableGatewayInterface $ClientetableGateway)
     {
               
                $this->tableGateway = $ClientetableGateway;
     }

     public function fetchAll()
     {

        return $this->tableGateway->select();
              
     }

    public function getCliente($Cod_Cliente)
     {
                $Cod_Cliente = $Cod_Cliente;
                $rowset = $this->tableGateway->select(['Cod_Cliente' => $Cod_Cliente]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
    public function getClienteRTNSelect(){

                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Rtn_Dni'));
                $resultSet = $this->tableGateway->selectWith($rowset); 

                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Rtn_Dni] = $row->Rtn_Dni;
                }
                   return $data;             
     }
      public function getClienteNota($Cod_Cliente){

                $Cod_Cliente = $Cod_Cliente;
                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Cliente','Nombres_Cliente','Apellidos_Cliente','Rtn_Dni'));
                $rowset->where(['Cod_Cliente'=>$Cod_Cliente]);
                $resultSet = $this->tableGateway->selectWith($rowset); 
                return $resultSet; 
               
     }
     public function getClienteNombre($Rtn_Dni){

                $Rtn_Dni = $Rtn_Dni;
                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Cliente','Nombres_Cliente','Apellidos_Cliente'));
                $rowset->where(['Rtn_Dni'=>$Rtn_Dni]);
                $resultSet = $this->tableGateway->selectWith($rowset); 
                return $resultSet; 
               
     }
    public function insertCliente(Cliente $cliente)
     {
            $data = [
                'Nombres_Cliente'  => $cliente->Nombres_Cliente,
                'Apellidos_Cliente' =>$cliente->Apellidos_Cliente,
                'Rtn_Dni'  => $cliente->Rtn_Dni,
            ];
           
            $Cod_Cliente = $cliente->Cod_Cliente;

           if ($Cod_Cliente == null) {
               $this->tableGateway->insert($data);
               return;
            }

     }

     public function updateCliente(Cliente $cliente)
    {          

            $data = [
                'Nombres_Cliente'  => $cliente->Nombres_Cliente,
                'Apellidos_Cliente' =>$cliente->Apellidos_Cliente,
                'Rtn_Dni'  => $cliente->Rtn_Dni,

            ];
               $Cod_Cliente = $cliente->Cod_Cliente;

                try {
                    
                    $this->getCliente($Cod_Cliente);
                } catch (RuntimeException $e) {
                    
                     return false;
                }

                $this->tableGateway->update($data, ['Cod_Cliente' => $Cod_Cliente]);
                return ;
    }
}