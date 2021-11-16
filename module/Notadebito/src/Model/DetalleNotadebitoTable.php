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
        $sqlSelect->columns(array('Cod_Detalle','Nota_Debito','Descripcion','Precio','Tipo_Importe','Cantidad'));
        $sqlSelect->where(['Nota_Debito' => $Cod_Nota]);
        $resultSet = $this->DetalleNotadebitoTableGateway->selectWith($sqlSelect);
        return $resultSet;
                
     }  
    public function insertDetalleNotadebito($Descripcion, $Cantidad, $Precio, $Tipo_Importe, $lastId)
    {  
        $Descripcion = $Descripcion;
        $Cantidad = $Cantidad;
        $Precio = $Precio;
        $Tipo_Importe = $Tipo_Importe;
        $lastId = $lastId;

        for($count = 0; $count < count($Precio); $count++){
            $data = array();           
             $data = [
                'Nota_debito' =>$lastId,
                'Descripcion' =>$Descripcion[$count],
                'Cantidad' =>$Cantidad[$count],
                'Precio' =>$Precio[$count],
                'Tipo_Importe' =>$Tipo_Importe[$count],
            ];
          
          $this->DetalleNotadebitoTableGateway->insert($data);
        }
        return $data;
    }
}
