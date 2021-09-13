<?php

namespace Boletasremision\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class DetalleTable
{
    private $DetalleTableGateway;

     public function __construct(TableGatewayInterface $DetalleTableGateway)
     {
               
            $this->DetalleTableGateway = $DetalleTableGateway;
     }


    public function detalle($Cod_Boleta)
     {      
      
        $sqlSelect = $this->DetalleTableGateway->getSql()->select();
        $sqlSelect->columns(array('Cod_Producto','Cantidad'));
        $sqlSelect->join('productos', 'productos.Cod_Producto = detalle.Cod_Producto', array('Nombre_Producto'), 'left');
        $sqlSelect->where(['Cod_Boleta' => $Cod_Boleta]);
        $resultSet = $this->DetalleTableGateway->selectWith($sqlSelect);
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
          
          $this->DetalleTableGateway->insert($data);
        }
        return $data;
    }
}