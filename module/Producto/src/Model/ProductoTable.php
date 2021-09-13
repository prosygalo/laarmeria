<?php

namespace Producto\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;


class ProductoTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
     {
               $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
               return $this->tableGateway->select();
     }

    public function getProducto($Cod_Producto)
     {
                $Cod_Producto = $Cod_Producto;
                $rowset = $this->tableGateway->select(['Cod_Producto' => $Cod_Producto]);
                $row = $rowset->current();
                if (! $row) {
                   return false;
                }
                return $row;
     } 
     public function getProductoSelect(){

                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Producto','Nombre_Producto','Descripcion'));
                $rowset->order('Nombre_Producto Asc');
                $resultSet = $this->tableGateway->selectWith($rowset); 
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Producto] = $row->Nombre_Producto;
                }
                   return $data;
               
     }   
    public function saveProducto(Producto $producto)
     {
            $data = [
                'Cod_Producto' => $producto->Cod_Producto,
                'Nombre_Producto'  => $producto->Nombre_Producto,
                'Descripcion'  => $producto->Descripcion,
            ];
           
            $Cod_Producto = $producto->Cod_Producto;

            
           if ($Cod_Producto != null) {
               $this->tableGateway->insert($data);
               return $this->tableGateway->lastInsertValue;
        
            }

     }
     public function updateProducto(Producto $producto)
    {
                $data = [
                    'Cod_Producto'  => $producto->Cod_Producto,
                    'Nombre_Producto' => $producto->Nombre_Producto,
                    'Descripcion'   => $producto->Descripcion,
                ];

                $Cod_Producto = $producto->Cod_Producto;

                try {
                    
                    $this->getProducto($Cod_Producto);
                } catch (RuntimeException $e) {
                     return false;
                }

                $this->tableGateway->update($data, ['Cod_Producto' => $Cod_Producto]);
                return;
    }


}