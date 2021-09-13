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
                $sqlSelect->columns(array('Cod_Boleta','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Autorizacion_Sar','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boletas_compra.Sucursal', array('Nombre_Sucursal'), 'left');
                $resultSet = $this->BoletacompraTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }
     
     public function boleta($Cod_Boleta)
     {

                $sqlSelect = $this->BoletacompraTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Boleta','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Autorizacion_Sar','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = boletas_compra.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->where(['Cod_Boleta' => $Cod_Boleta]);
                $resultSet = $this->BoletacompraTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }  
     public function getBoleta($Cod_Boleta)
     {
                $Cod_Boleta = $Cod_Boleta;
                $rowset = $this->BoletacompraTableGateway->select(['Cod_Boleta' => $Cod_Boleta]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
     
      public function getUltimaBoleta()
     {
                $rowset = $this->BoletacompraTableGateway->select();
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
    public function insertBoleta(Boletacompra $Boletacompra)
     {
            $data = [
            'Fecha_Emision' =>$Boletacompra->Fecha_Emision,
            'Consecutivo_Actual_Establ'  => $Boletacompra->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $Boletacompra->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $Boletacompra->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $Boletacompra->Consecutivo_Actual_Correlativo,
            'Autorizacion_Sar' => $Boletacompra->Autorizacion_Sar,
            'Sucursal' => $Boletacompra->Sucursal,
            'Usuario'  => $Boletacompra->Usuario,
            ];
           
            $Cod_Boleta = $Boletacompra->Cod_Boleta;

           if ($Cod_Boleta == null) {
               $this->BoletacompraTableGateway->insert($data);
             return  $this->BoletacompraTableGateway->lastInsertValue;   
           } 

     }
 }