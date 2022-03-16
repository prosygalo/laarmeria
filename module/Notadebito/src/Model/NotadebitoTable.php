<?php

namespace Notadebito\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;

class NotadebitoTable
{
     private $NotadebitoTableGateway;

     public function __construct(TableGatewayInterface $NotadebitoTableGateway)
     {
               
            $this->NotadebitoTableGateway = $NotadebitoTableGateway;
     }

     public function fetchAll()
     {

                $sqlSelect = $this->NotadebitoTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Nota','Fecha_Emision','Fecha_Emision_Comprobante','No_Correlativo','Cai_Comprobante','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Motivo','Sucursal','Autorizacion_Sar','Isv','Exonerado','Exento','Gravado','Total','Cliente','Usuario','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = notas_debito.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->join('clientes', 'clientes.Cod_Cliente = notas_debito.Cliente', array('Nombres_Cliente','RTN_DNI'), 'left');
                $resultSet = $this->NotadebitoTableGateway->selectWith($sqlSelect);
                 return $resultSet;
     }
     
     public function Nota($Cod_Nota)
     {
                $sqlSelect = $this->NotadebitoTableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Nota','Fecha_Emision','Fecha_Emision_Comprobante','No_Correlativo','Cai_Comprobante','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Motivo','Sucursal','Autorizacion_Sar','Isv','Exonerado','Exento','Gravado','Total','Cliente','Usuario','Fecha_Ingreso'));
                $sqlSelect->join('sucursales', 'sucursales.Cod_Sucursal = notas_debito.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->join('clientes', 'clientes.Cod_Cliente = notas_debito.Cliente', array('Nombres_Cliente'), 'left');
                $sqlSelect->where(['Cod_Nota' => $Cod_Nota]);
                $resultSet = $this->NotadebitoTableGateway->selectWith($sqlSelect);
                return $resultSet;
     }  

     public function getNota($Cod_Nota)
     {
                $Cod_Nota = $Cod_Nota;
                $rowset = $this->NotadebitoTableGateway->select(['Cod_Nota' => $Cod_Nota]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
     
    public function insertNotaDebito(Notadebito $notadebito)
     {        
            $data = [
            'Fecha_Emision' =>$notadebito->Fecha_Emision,
            'Fecha_Emision_Comprobante' =>$notadebito->Fecha_Emision_Comprobante,
            'Consecutivo_Actual_Establ'  => $notadebito->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $notadebito->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $notadebito->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $notadebito->Consecutivo_Actual_Correlativo,
            'Autorizacion_Sar' => $notadebito->Autorizacion_Sar,
            'Sucursal' => $notadebito->Sucursal,
            'No_Correlativo' => $notadebito->No_Correlativo,
            'Cai_Comprobante' => $notadebito->Cai_Comprobante,
            'Gravado' => $notadebito->Gravado,
            'Exento' => $notadebito->Exento,
            'Exonerado' => $notadebito->Exonerado,
            'Isv' => $notadebito->Isv,
            'Total' => $notadebito->Total,
            'Cliente' => $notadebito->Cliente,
            'Motivo' => $notadebito->Motivo,
            'Usuario'  => $notadebito->Usuario, 
            ];
           
            $Cod_Nota = $notadebito->Cod_Nota;

           if ($Cod_Nota == null) {
               $this->NotadebitoTableGateway->insert($data);
             return  $this->NotadebitoTableGateway->lastInsertValue;   
           } 

     }
 }