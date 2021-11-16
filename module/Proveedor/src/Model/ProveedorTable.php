<?php

namespace Proveedor\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class ProveedorTable
{
     private $ProveedortableGateway;

     public function __construct(TableGatewayInterface $ProveedortableGateway)
     {
               
                $this->tableGateway = $ProveedortableGateway;
     }

     public function fetchAll()
     {

        return $this->tableGateway->select();
              
     }

    public function getProveedor($Cod_Proveedor)
     {
                $Cod_Proveedor = $Cod_Proveedor;
                $rowset = $this->tableGateway->select(['Cod_Proveedor' => $Cod_Proveedor]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
      public function getProveedorBoletaCompra($Cod_Proveedor)
     {
                $Cod_Proveedor = $Cod_Proveedor;
                $rowset=$this->tableGateway->getSql()->select();
                $rowset->columns(['Cod_Proveedor','Direccion_Proveedor','Nombre_Proveedor','Telefono_Proveedor','RTN_Proveedor']);
                $rowset->where(['Cod_Proveedor' => $Cod_Proveedor]);
                $resultSet=$this->tableGateway->selectWith($rowset);
                return $resultSet;
     }
      public function getProveedorConstancia($Cod_Proveedor)
     {
                $Cod_Proveedor = $Cod_Proveedor;
                $rowset=$this->tableGateway->getSql()->select();
                $rowset->columns(['Cod_Proveedor','Direccion_Proveedor','Nombre_Proveedor','RTN_Proveedor']);
                $rowset->where(['Cod_Proveedor' => $Cod_Proveedor]);
                $resultSet=$this->tableGateway->selectWith($rowset);
                return $resultSet;
     }
     
      public function getProveedorSelectRTN(){

                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('RTN_Proveedor'));
                $rowset->order('RTN_Proveedor Asc');
                $resultSet = $this->tableGateway->selectWith($rowset); 

                $data= array();
                foreach($resultSet as $row){
                   $data[$row->RTN_Proveedor] = $row->RTN_Proveedor;
                }
                   return $data;            
     }
    
     public function getProveedorSelectNombre($RTN_Proveedor){

                $RTN_Proveedor = $RTN_Proveedor;
                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Proveedor','Nombre_Proveedor','RTN_Proveedor','Direccion_Proveedor','Telefono_Proveedor'));
                $rowset->where(['RTN_Proveedor'=>$RTN_Proveedor]);
                $resultSet = $this->tableGateway->selectWith($rowset); 
                return $resultSet; 
               
     }

     public function getProveedorSelect(){

                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Proveedor','Nombre_Proveedor'));
                $resultSet = $this->tableGateway->selectWith($rowset); 
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Proveedor] = $row->Nombre_Proveedor;
                }
                return $data; 
               
     }
     public function getProveedorSelectDireccion($RTN_Proveedor){

                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Direccion_Proveedor'));
                $rowset->order('Direccion_Proveedor Asc');
                $resultSet = $this->tableGateway->selectWith($rowset); 

                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Direccion_Proveedor] = $row->Direccion_Proveedor;
                }
                   return $data;            
     }
    
    public function insertProveedor(Proveedor $proveedor)
     {
            $data = [
                'Nombre_Proveedor'  =>$proveedor->Nombre_Proveedor,
                'Direccion_Proveedor' =>$proveedor->Direccion_Proveedor,
                'Telefono_Proveedor'  =>$proveedor->Telefono_Proveedor,
                'RTN_Proveedor'  => $proveedor->RTN_Proveedor,
            ];
           
            $Cod_Proveedor = $proveedor->Cod_Proveedor;
            
           if ($Cod_Proveedor == null) {
               $this->tableGateway->insert($data);
               return;
        
            }

     }
     public function updateproveedor(Proveedor $proveedor)
    {          
             $data = [
                'Nombre_Proveedor'  =>$proveedor->Nombre_Proveedor,
                'Direccion_Proveedor' =>$proveedor->Direccion_Proveedor,
                'Telefono_Proveedor'  =>$proveedor->Telefono_Proveedor,
                'RTN_Proveedor'  => $proveedor->RTN_Proveedor,
            ];

                $Cod_Proveedor = $proveedor->Cod_Proveedor;

                try {
                    
                    $this->getProveedor($Cod_Proveedor);
                } catch (RuntimeException $e) {
                    
                     return false;
                }

                $this->tableGateway->update($data, ['Cod_Proveedor' => $Cod_Proveedor]);
                return ;
    }
}