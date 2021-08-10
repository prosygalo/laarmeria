<?php

namespace Boletasremision\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class BoletasremisionTable
{
      private $BoletasremisionTableGateway;

     public function __construct(TableGatewayInterface $BoletasremisionTableGateway)
     {
               
            $this->BoletasremisionTableGateway = $BoletasremisionTableGateway;
     }

     public function fetchAll()
     {

                $sqlSelect = $this->BoletasremisionTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Boleta','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Motivo_Traslado','Num_Transferencia','Punto_Partida','Punto_Destino','Fecha_Inicio_Traslado','Fecha_Final_Traslado','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boletas_guia_remision.Sucursal', array('Nombre_Sucursal'), 'left');
                $resultSet = $this->BoletasremisionTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }
     
     public function boleta($Cod_Boleta)
     {

                $sqlSelect = $this->BoletasremisionTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Boleta','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Motivo_Traslado','Num_Transferencia','Punto_Partida','Punto_Destino','Fecha_Inicio_Traslado','Fecha_Final_Traslado','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boletas_guia_remision.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->where(['Cod_Boleta' => $Cod_Boleta]);
                $resultSet = $this->BoletasremisionTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }  
     public function getBoleta($Cod_Boleta)
     {
                $Cod_Boleta = $Cod_Boleta;
                $rowset = $this->BoletasremisionTableGateway->select(['Cod_Boleta' => $Cod_Boleta]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
     
      public function getUltimaBoleta()
     {
                $rowset = $this->BoletasremisionTableGateway->select();
                $rowset->columns(['Cod_Boleta' => new Expression('MAX(Cod_Boleta)')]);
                $resultSet = $this->tableGateway->selectWith($rowset);
                $row = $rowset->current();

                if (! $row) {
                    throw new RuntimeException(sprintf(
                               'No existe registro'
                    ));
                }
                return $row;
     }
    public function insertBoleta(Boletasremision $boletasremision)
     {
            $data = [
            'Fecha_Emision' =>$boletasremision->Fecha_Emision,
            'Consecutivo_Actual_Establ'  => $boletasremision->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $boletasremision->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $boletasremision->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $boletasremision->Consecutivo_Actual_Correlativo,
            'Motivo_Traslado'  =>$boletasremision->Motivo_Traslado,
            'Num_Transferencia' =>$boletasremision->Num_Transferencia,
            'Punto_Partida' => $boletasremision->Punto_Partida,
            'Punto_Destino'  =>$boletasremision->Punto_Destino,
            'Fecha_Inicio_Traslado'  => $boletasremision->Fecha_Inicio_Traslado,
            'Fecha_Final_Traslado' => $boletasremision->Fecha_Final_Traslado,
            'Autorizacion_Sar' => $boletasremision->Autorizacion_Sar,
            'Sucursal' => $boletasremision->Sucursal,
            'Unidad_Transporte'  => $boletasremision->Unidad_Transporte,
            'Conductor'  => $boletasremision->Conductor,
            'Usuario'  => $boletasremision->Usuario,
            ];
           
            $Cod_Boleta = $boletasremision->Cod_Boleta;

           if ($Cod_Boleta == null) {
               $this->BoletasremisionTableGateway->insert($data);
             return  $this->BoletasremisionTableGateway->lastInsertValue;   
           } 

     }
 }