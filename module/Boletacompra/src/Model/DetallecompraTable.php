<?php

namespace Boletacompra\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class DetallecompraTable
{
    private $DetallecompraTableGateway;

     public function __construct(TableGatewayInterface $DetallecompraTableGateway)
     {
               
            $this->DetallecompraTableGateway = $DetallecompraTableGateway;
     }


    public function getDetalle($Cod_Boleta_Compra)
     {      
        $Cod_Boleta_Compra = $Cod_Boleta_Compra;
        $sqlSelect = $this->DetallecompraTableGateway->getSql()->select();
        $sqlSelect->columns(array('Cod_Detalle','Boleta_Compra','Producto','Descripcion','Precio','Cantidad'));
        $sqlSelect->where(['Boleta_Compra' => $Cod_Boleta_Compra]);
        $resultSet = $this->DetallecompraTableGateway->selectWith($sqlSelect);
        return $resultSet;
                
     }  
   
    public function insertDetalle($Producto, $Descripcion, $Cantidad, $Precio,  $lastId)
    {  
        $Producto = $Producto;
        $Descripcion = $Descripcion;
        $Cantidad = $Cantidad;
        $Precio = $Precio;
        $lastId = $lastId;

        for($count = 0; $count < count($Producto); $count++){
            $data = array();           
             $data=[
                'Producto' =>$Producto[$count],
                'Boleta_Compra' =>$lastId,
                'Descripcion' =>$Descripcion[$count],
                'Cantidad' =>$Cantidad[$count],
                'Precio' =>$Precio[$count],
            ];
          
          $this->DetallecompraTableGateway->insert($data);
        }
        return $data;
    }
}
