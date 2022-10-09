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
     public function getProductoExistencia($Cod_Producto)
     {
                $Cod_Producto = $Cod_Producto;
                $rowset2 = $this->tableGateway->getSql()->select();
                $rowset2->where(['Cod_Producto'=>$Cod_Producto]);
                $resultSet = $this->tableGateway->selectWith($rowset2);
                return $resultSet; 
     }
     public function getProductoSelect($Sucursal){

                $Sucursal=$Sucursal;
                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Producto','Nombre_Producto','Descripcion'));
                $rowset->where(['Sucursal'=>$Sucursal, 'Cantidad > = 1 ']);
                $rowset->order('Nombre_Producto Asc');
                $resultSet = $this->tableGateway->selectWith($rowset); 
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Producto] = $row->Nombre_Producto .' '. $row->Descripcion;
                }
                   return $data;
               
     }   
    public function saveProducto(Producto $producto)
     {
            $data = [
                'Cod_Producto' => $producto->Cod_Producto,
                'Nombre_Producto'  => $producto->Nombre_Producto,
                'Descripcion'  => $producto->Descripcion,
                'Precio'  => $producto->Precio,
                'Sucursal'   => $producto->Sucursal,
                'Cantidad'  => $producto->Cantidad,
             
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
                    'Precio'   => $producto->Precio,
                    'Sucursal'   => $producto->Sucursal,
                    'Cantidad'  => $producto->Cantidad,
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
    public function ComprobarExistencia($Cod_Producto, $Cantidad)
    {  
        $Cod_Producto = $Cod_Producto;
        $Cantidad = $Cantidad;

        for($count = 0; $count < count($Cod_Producto); $count++){

            $data = array(); 
            $Codigo =  ['Cod_Producto'=>$Cod_Producto[$count]];
            
            $exis = $this->tableGateway->getSql()->select();
            $exis->columns(array('Cantidad'));
            $exis->where(['Cod_Producto'=>$Codigo]);
            $result = $this->tableGateway->selectWith($exis);

            foreach ($result as $n) {
                 $existencia = $n->Cantidad;
            }
                  if ($existencia >= $Cantidad[$count]){
                          
                   $data =[];
                  
                  }else{
                     
                   $data = [];  
                 }
           
         }
        
        return $data;
     }


    public function UpdateExistenciaProducto($Cod_Producto, $Cantidad)
    {  
        $Cod_Producto = $Cod_Producto;
        $Cantidad = $Cantidad;

        for($count = 0; $count < count($Cod_Producto); $count++){

            $data = array(); 
            $Codigo =  ['Cod_Producto'=>$Cod_Producto[$count]];
            
            $exis = $this->tableGateway->getSql()->select();
            $exis->columns(array('Cantidad'));
            $exis->where(['Cod_Producto'=>$Codigo]);
            $result = $this->tableGateway->selectWith($exis);

            foreach ($result as $n) {
                $existencia = $n->Cantidad;
            }
            if ($existencia >= $Cantidad[$count]){

                $data = ['Cantidad' => $existencia - $Cantidad[$count]]; 
            }else{
                $data = ['Cantidad' => $existencia - 0];    
            }
           
            
            $this->tableGateway->update($data, ['Cod_Producto' => $Codigo]);
         }
        
        return $data;
     }
}