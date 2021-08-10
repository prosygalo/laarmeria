<?php

namespace Unidadtransporte\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;


class UnidadtransporteTable
{
      private $UnidadtransportetableGateway;

     public function __construct(TableGatewayInterface $UnidadtransportetableGateway)
     {
               
                $this->tableGateway = $UnidadtransportetableGateway;
     }
     public function fetchAll()
     {
               return $this->tableGateway->select();
     }


    public function getUnidad($Cod_Unidad)
     {
                $Cod_Unidad = $Cod_Unidad;
                $rowset = $this->tableGateway->select(['Cod_Unidad' => $Cod_Unidad]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
     public function getUnidadSelect(){

                $rowset = $this->tableGateway->getSql()->select();
                $rowset->columns(array('Cod_Unidad','Marca_Vehiculo','Modelo_Vehiculo'));
                $rowset->where(['Estado' => 'Disponible']);
                $rowset->order('Marca_Vehiculo Asc');
                $resultSet = $this->tableGateway->selectWith($rowset); 
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Unidad] = $row->Marca_Vehiculo . $row->Modelo_Vehiculo;
                }
                   return $data;  
                 
     }
    public function saveUnidad(Unidadtransporte $unidadtransporte)
     {
            $data = [
                'Cod_Unidad' => $unidadtransporte->Cod_Unidad,
                'Marca_Vehiculo'  => $unidadtransporte->Marca_Vehiculo,
                'Modelo_Vehiculo'  => $unidadtransporte->Modelo_Vehiculo,
                'Placa_Vehiculo'  => $unidadtransporte->Placa_Vehiculo,
                'Estado'  => $unidadtransporte->Estado,
            ];
           
            $Cod_Unidad = $unidadtransporte->Cod_Unidad;

            
           if ($Cod_Unidad != null) {
               $this->tableGateway->insert($data);
               return;
        
            }

     }
     public function updateUnidad(Unidadtransporte $unidadtransporte)
    {          
           $data = [
                'Cod_Unidad' => $unidadtransporte->Cod_Unidad,
                'Marca_Vehiculo'  => $unidadtransporte->Marca_Vehiculo,
                'Modelo_Vehiculo'  => $unidadtransporte->Modelo_Vehiculo,
                'Placa_Vehiculo'  => $unidadtransporte->Placa_Vehiculo,
                'Estado'  => $unidadtransporte->Estado,
            ];

               $Cod_Unidad = $unidadtransporte->Cod_Unidad;


                try {
                    
                    $this->getUnidad($Cod_Unidad);
                } catch (RuntimeException $e) {
                    /*throw new RuntimeException(sprintf(
                        'No se puede actualizar departamento con identificador',
                        ));*/
                        return false;
                }

                $this->tableGateway->update($data, ['Cod_Unidad' => $Cod_Unidad]);
                return;
    }

    
    public function deleteUnidad($Cod_Unidad)
    {
             $this->tableGateway->delete(['Cod_Unidad'=>$Cod_Unidad]);
    }

}