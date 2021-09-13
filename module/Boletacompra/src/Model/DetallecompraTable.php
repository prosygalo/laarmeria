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


    public function detallecompra($Cod_Boleta)
     {      
       /* SELECT *
        FROM detalle
        inner join boletas_guia_remision
        ON detalle.Boleta = boletas_guia_remision.Cod_Boleta inner join productos ON productos.Cod_Producto =  detalle.Producto
        where Boleta = '29';*/
                
                $sqlSelect = $this->DetallecompraTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Producto','Cantidad'));
                $sqlSelect->join('productos', 'productos.Cod_Producto = detalle.Cod_Producto', array('Nombre_Producto'), 'left');
                $sqlSelect->where(['Cod_Boleta' => $Cod_Boleta]);
                $resultSet = $this->DetallecompraTableGateway->selectWith($sqlSelect);
                return $resultSet;
                
     }  

    public function insertDetalle($Cod_Producto, $lasId, $Cantidad)
    {  
        $Cod_Producto = $Cod_Producto;
        $lasId = $lasId;
        $Cantidad = $Cantidad; 

        for($count = 0; $count < count($Cod_Producto); $count++){
            $data = array();           
             $data=[
                'Cod_Producto' =>$Cod_Producto[$count],
                'Cod_Boleta'   =>$lasId,
                'Cantidad' =>$Cantidad[$count],
            ];
          
          $this->DetallecompraTableGateway->insert($data);
        }
        return $data;
    }
}