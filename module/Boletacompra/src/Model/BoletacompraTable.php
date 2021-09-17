<?php

namespace Boletacompra\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class BoletacompraTable
{
     private $BoletacompraTableGateway;

     public function __construct(TableGatewayInterface $BoletacompraTableGateway)
     {
               
            $this->BoletacompraTableGateway = $BoletacompraTableGateway;
     }

     public function fetchAll()
     {

                $sqlSelect = $this->BoletacompraTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Boleta_Compra','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Motivo_Traslado','Num_Transferencia','Sucursal_Remitente','Sucursal_Destino','Punto_Partida','Punto_Destino','Fecha_Inicio_Traslado','Fecha_Final_Traslado','Total','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boleta_compra.Sucursal', array('Nombre_Sucursal'), 'left');
                $resultSet = $this->BoletacompraTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }
     
     public function boleta($Cod_Boleta_Compra)
     {

                $sqlSelect = $this->BoletacompraTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Boleta_Compra','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Motivo_Traslado','Num_Transferencia','Punto_Partida','Punto_Destino','Fecha_Inicio_Traslado','Fecha_Final_Traslado','Total','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boleta_compra.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->where(['Cod_Boleta_Compra' => $Cod_Boleta_Compra]);
                $resultSet = $this->BoletacompraTableGateway->selectWith($sqlSelect);
                return $resultSet;
     }  
     public function getBoleta($Cod_Boleta_Compra)
     {
                $Cod_Boleta_Compra = $Cod_Boleta_Compra;
                $rowset = $this->BoletacompraTableGateway->select(['Cod_Boleta_Compra' => $Cod_Boleta_Compra]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
     
      public function getUltimaBoleta()
     {
                $rowset = $this->BoletacompraTableGateway->select();
                $rowset->columns(['Cod_Boleta_Compra' => new Expression('MAX(Cod_Boleta_Compra)')]);
                $resultSet = $this->tableGateway->selectWith($rowset);
                $row = $rowset->current();

                if (! $row) {
                    throw new RuntimeException(sprintf(
                               'No existe registro'
                    ));
                }
                return $row;
     }
    public function insertBoleta(Boletacompra $boletacompra)
     {
            $data = [
            'Fecha_Emision' =>$boletacompra->Fecha_Emision,
            'Consecutivo_Actual_Establ'  => $boletacompra->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $boletacompra->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $boletacompra->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $boletacompra->Consecutivo_Actual_Correlativo,
            'Autorizacion_Sar' => $boletacompra->Autorizacion_Sar,
            'Sucursal' => $boletacompra->Sucursal,
            'Total'  => $boletacompra->Total,
            'Usuario'  => $boletacompra->Usuario,
            ];
           
            $Cod_Boleta_Compra = $boletacompra->Cod_Boleta_Compra;

           if ($Cod_Boleta_Compra == null) {
               $this->BoletacompraTableGateway->insert($data);
             return  $this->BoletacompraTableGateway->lastInsertValue;   
           } 

     }
 }