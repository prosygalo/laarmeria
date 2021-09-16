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
                $sqlSelect->columns(array('Cod_Producto','Nombre_Producto','Descripcion_Producto','Cantidad','Precio'));
                $sqlSelect->where(['Cod_Boleta_Compra' => $Cod_Boleta_Compra]);
                $resultSet = $this->DetallecompraTableGateway->selectWith($sqlSelect);
                return $resultSet;
                
     }  

    public function insertDetalle($Cod_Producto, $Nombre_Producto, $Descripcion_Producto, $Cantidad, $Precio,  $lasId)
    {  
        $Cod_Producto = $Cod_Producto;
        $Nombre_Producto = $Nombre_Producto;
        $Descripcion_Producto = $Descripcion_Producto;
        $Cantidad = $Cantidad;
        $Precio = $Precio;
        $lasId = $lasId;

        for($count = 0; $count < count($Cod_Producto); $count++){
            $data = array();           
             $data=[
                'Cod_Producto' =>$Cod_Producto[$count],
                'Nombre_Producto' =>$Nombre_Producto[$count],
                'Descripcion_Producto' =>$Descripcion_Producto[$count],
                'Cantidad' =>$Cantidad[$count],
                'Cod_Producto' =>$Cod_Producto[$count],
                'Cod_Boleta'   =>$lasId,
            ];
          
          $this->DetallecompraTableGateway->insert($data);
        }
        return $data;
    }
}
