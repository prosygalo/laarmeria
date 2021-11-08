<?php

namespace Constanciaretencion\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class ConstanciaretencionTable
{
      private $ConstanciaretencionTableGateway;

     public function __construct(TableGatewayInterface $ConstanciaretencionTableGateway)
     {
               
            $this->ConstanciaretencionTableGateway = $ConstanciaretencionTableGateway;
     }

     public function fetchAll()
     {
                $sqlSelect = $this->ConstanciaretencionTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Constancia','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Sucursal','Tipo_Retencion','Proveedor','Base_Gravable_Impuesto','Importe_Retencion','Documento_Retencion','No_Correlativo','RTN_Proveedor','Cai_Documento','Descripcion_Tributo_Retenido','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = constancias_de_retencion.Sucursal', array('Nombre_Sucursal'), 'left');
                $resultSet = $this->ConstanciaretencionTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }
     
     public function constancia($Cod_Constancia)
     {
                $Cod_Constancia = $Cod_Constancia;
                $sqlSelect = $this->ConstanciaretencionTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Constancia','Fecha_Emision','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Tipo_Retencion','Proveedor','Base_Gravable_Impuesto','Importe_Retencion','Documento_Retencion','No_Correlativo','RTN_Proveedor','Cai_Documento','Descripcion_Tributo_Retenido','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = constancias_de_retencion.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->where(['Cod_Constancia' => $Cod_Constancia]);
                $resultSet = $this->ConstanciaretencionTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }  
     public function getConstancia($Cod_Constancia)
     {
                $Cod_Constancia = $Cod_Constancia;
                $rowset = $this->ConstanciaretencionTableGateway->select(['Cod_Constancia' => $Cod_Constancia]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
    public function insertConstancia(Constanciaretencion $constanciaretencion)
     {
            $data = [
            'Fecha_Emision' =>$constanciaretencion->Fecha_Emision,
            'Consecutivo_Actual_Establ'  => $constanciaretencion->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $constanciaretencion->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $constanciaretencion->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $constanciaretencion->Consecutivo_Actual_Correlativo,
            'Tipo_Retencion'  =>$constanciaretencion->Tipo_Retencion,
            'Proveedor' =>$constanciaretencion->Proveedor,
            'Base_Gravable_Impuesto' => $constanciaretencion->Base_Gravable_Impuesto,
            'Importe_Retencion'  =>$constanciaretencion->Importe_Retencion,
            'Documento_Retencion'  => $constanciaretencion->Documento_Retencion,
            'No_Correlativo' => $constanciaretencion->No_Correlativo,
            'Autorizacion_Sar' => $constanciaretencion->Autorizacion_Sar,
            'Sucursal' => $constanciaretencion->Sucursal,
            'RTN_Proveedor' => $constanciaretencion->RTN_Proveedor,
            'Cai_Documento' => $constanciaretencion->Cai_Documento,
            'Descripcion_Tributo_Retenido' => $constanciaretencion->Descripcion_Tributo_Retenido,
            'Usuario'=> $constanciaretencion->Usuario,
            ];
           
            $Cod_Constancia = $constanciaretencion->Cod_Constancia;

           if ($Cod_Constancia == null) {
               $this->ConstanciaretencionTableGateway->insert($data);
             return  $this->ConstanciaretencionTableGateway->lastInsertValue;   
           } 

     }
 }