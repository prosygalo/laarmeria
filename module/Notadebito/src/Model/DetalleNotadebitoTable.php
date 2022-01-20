<?php

namespace Notadebito\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class DetalleNotadebitoTable
{
    private $DetalleNotadebitoTableGateway;

     public function __construct(TableGatewayInterface $DetalleNotadebitoTableGateway)
     {
               
            $this->DetalleNotadebitoTableGateway = $DetalleNotadebitoTableGateway;
     }

    public function getDetalleNota($Cod_Nota)
     {      
        $Cod_Nota = $Cod_Nota;
        $sqlSelect = $this->DetalleNotadebitoTableGateway->getSql()->select();
        $sqlSelect->columns(array('Cod_Detalle','Nota_Debito','Cod_Producto','Cantidad'));
        //$sqlSelect->join('productos', 'productos.Cod_Producto = detalle_nota_debito.Cod_Producto', array('Cod_Producto','Nombre_Producto','Descripcion','Precio','Tipo_Importe'), 'left');
        $sqlSelect->where(['Nota_Debito' => $Cod_Nota]);
        $resultSet = $this->DetalleNotadebitoTableGateway->selectWith($sqlSelect);
        return $resultSet;        
    }  
    public function insertDetalleNotadebito($Cod_Producto, $Cantidad, $lastId)
    {  
        $Cod_Producto = $Cod_Producto;
        $Cantidad = $Cantidad;
        $lastId = $lastId;

        for($count = 0; $count < count($Cod_Producto); $count++){
            $data = array();           
             $data = [
                'Cod_Producto' =>$Cod_Producto[$count],
                'Cantidad' =>$Cantidad[$count],
                'Nota_debito' =>$lastId,
            ];
          
          $this->DetalleNotadebitoTableGateway->insert($data);
        }
        return $data;
    }
}
