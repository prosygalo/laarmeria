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
                $sqlSelect->columns(array('Cod_Boleta_Compra','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Sucursal','Autorizacion_Sar','Total','Proveedor','No_Registro_Sag','No_Orden_Compra_Exenta','No_Constancia_Registro_Exonerado','Usuario','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boletas_compra.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->join('proveedores', 'proveedores.Cod_Proveedor = boletas_compra.Proveedor', array('Nombre_Proveedor'), 'left');
                $resultSet = $this->BoletacompraTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }
     
     public function boleta($Cod_Boleta_Compra)
     {

                $sqlSelect = $this->BoletacompraTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Boleta_Compra','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Sucursal','Autorizacion_Sar','Total','No_Registro_Sag','No_Orden_Compra_Exenta','No_Constancia_Registro_Exonerado','Usuario','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boletas_compra.Sucursal', array('Nombre_Sucursal'), 'left');
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
            'Total' => $boletacompra->Total,
            'Proveedor' => $boletacompra->Proveedor,
            'No_Registro_Sag' => $boletacompra->No_Registro_Sag,
            'No_Orden_Compra_Exenta' => $boletacompra->No_Orden_Compra_Exenta,
            'No_Constancia_Registro_Exonerado'  => $boletacompra->No_Constancia_Registro_Exonerado,
            'Usuario'  => $boletacompra->Usuario, 
            'Fecha_Ingreso'  => $boletacompra->Fecha_Ingreso,
            ];
           
            $Cod_Boleta_Compra = $boletacompra->Cod_Boleta_Compra;

           if ($Cod_Boleta_Compra == null) {
               $this->BoletacompraTableGateway->insert($data);
             return  $this->BoletacompraTableGateway->lastInsertValue;   
           } 

     }
 }