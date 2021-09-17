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


    public function detallecompra($Cod_Boleta_Compra)
     {      
       /* SELECT *
        FROM detalle
        inner join boletas_compra
        ON detalle_compra.Boleta_Compra = boletas_compra.Cod_Boleta_Compra
        where Boleta_Compra = '29';*/
                
                $sqlSelect = $this->DetallecompraTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Producto','Descripcion','Cantidad','Precio'));
                $sqlSelect->where(['Cod_Boleta_Compra' => $Cod_Boleta_Compra]);
                $resultSet = $this->DetallecompraTableGateway->selectWith($sqlSelect);
                return $resultSet;
                
     }  

    public function insertDetalle($Cod_Producto, $Descripcion, $Cantidad, $Precio,  $lastId)
    {  
        $Cod_Producto = $Cod_Producto;
        $Descripcion = $Descripcion;
        $Cantidad = $Cantidad;
        $Precio = $Precio;
        $lastId = $lastId;

        for($count = 0; $count < count($Cod_Producto); $count++){
            $data = array();           
             $data=[
                'Cod_Producto' =>$Cod_Producto[$count],
                'Descripcion' =>$Descripcion[$count],
                'Cantidad' =>$Cantidad[$count],
                'Precio' =>$Precio[$count],
                'Boleta'   =>$lastId,
            ];
          
          $this->DetallecompraTableGateway->insert($data);
        }
        return $data;
    }
}
