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
                $rowset->columns(array('RTN_DNI'));
                $resultSet = $this->tableGateway->selectWith($rowset); 

                $data= array();
                foreach($resultSet as $row){
                   $data[$row->RTN_DNI] = $row->RTN_DNI;
                }
                   return $data;             
     }
      public function getClienteNota($Cod_Cliente){

                $Cod_Cliente = $Cod_Cliente;
                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Cliente','Nombres_Cliente','Apellidos_Cliente','RTN_DNI'));
                $rowset->where(['Cod_Cliente'=>$Cod_Cliente]);
                $resultSet = $this->tableGateway->selectWith($rowset); 
                return $resultSet; 
               
     }
     public function getClienteNombre($RTN_DNI){

                $RTN_DNI = $RTN_DNI;
                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Cliente','Nombres_Cliente','Apellidos_Cliente'));
                $rowset->where(['RTN_DNI'=>$RTN_DNI]);
                $resultSet = $this->tableGateway->selectWith($rowset); 
                return $resultSet; 
               
     }
    public function insertCliente(Cliente $cliente)
     {
            $data = [
                'Nombres_Cliente'  => $cliente->Nombres_Cliente,
                'Apellidos_Cliente' =>$cliente->Apellidos_Cliente,
                'RTN_DNI'  => $cliente->RTN_DNI,
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
                'RTN_DNI'  => $cliente->RTN_DNI,

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