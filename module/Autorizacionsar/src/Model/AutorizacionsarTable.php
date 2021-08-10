<?php

namespace Autorizacionsar\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Having;
use Zend\Db\TableGateway\TableGatewayInterface;

class AutorizacionsarTable
{
     private $AutorizacionsartableGateway;

     public function __construct(TableGatewayInterface $AutorizacionsartableGateway)
     {
               
                $this->tableGateway = $AutorizacionsartableGateway;
     }

     public function fetchAll()
     {
                $sqlSelect = $this->tableGateway->getSql()->select();
                $sqlSelect->columns(array('Cod_Autorizacion','Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite','Sucursal','Fecha_Ingreso'));
                $sqlSelect->join('Sucursales', 'sucursales.Cod_sucursal = autorizaciones_sar.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->order('Cod_Autorizacion ASC');

                 $resultSet = $this->tableGateway->selectWith($sqlSelect);
                 return $resultSet;
    }
     
    public function getAuto($Cod_Autorizacion)
     {
                $Cod_Autorizacion = $Cod_Autorizacion;
                $rowset = $this->tableGateway->select(['Cod_Autorizacion' => $Cod_Autorizacion]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;


     }
     public function getUltimaAutorizacion($Sucursal)
     {        
        /*SELECT * FROM `autorizaciones_sar` 
          WHERE Sucursal ='M89'
          HAVING max(Cod_Autorizacion);  */
            $Sucursal = $Sucursal;
            $subquery =  $this->tableGateway->getSql()->select();
            $subquery->columns(['Cod_Autorizacion' => new  Expression('MAX(Cod_Autorizacion)')]);
            $subquery->Where(['Sucursal' => $Sucursal]);

                    
            $rowset=$this->tableGateway->getSql()->select();
            $rowset->columns(['Cod_Autorizacion' ,'Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite','Sucursal','Fecha_Ingreso']);
            $rowset->Where(['Sucursal' => $Sucursal]);
            $rowset->Having(['Cod_Autorizacion'=>($subquery)]);
            $resultSet=$this->tableGateway->selectWith($rowset);
            return $resultSet;       
     }
     // he definitely knows how to work with the pipe
    public function insertAuto(Autorizacionsar $autorizacionsar)
     {
            $data = [
            'Cai' => $autorizacionsar->Cai,
            'Consecutivo_Inicial_Establ'=>$autorizacionsar->Consecutivo_Inicial_Establ,
            'Consecutivo_Inicial_Punto'=>$autorizacionsar->Consecutivo_Inicial_Punto,
            'Consecutivo_Inicial_Tipo'=>$autorizacionsar->Consecutivo_Inicial_Tipo,
            'Consecutivo_Inicial_Correlativo'=>$autorizacionsar->Consecutivo_Inicial_Correlativo,
            'Consecutivo_Final_Establ'=>$autorizacionsar->Consecutivo_Final_Establ,
            'Consecutivo_Final_Punto'=>$autorizacionsar->Consecutivo_Final_Punto,
            'Consecutivo_Final_Tipo'=>$autorizacionsar->Consecutivo_Final_Tipo,
            'Consecutivo_Final_Correlativo'=>$autorizacionsar->Consecutivo_Final_Correlativo,
            'Consecutivo_Actual_Establ'=>$autorizacionsar->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'=>$autorizacionsar->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'=>$autorizacionsar->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'=>$autorizacionsar->Consecutivo_Actual_Correlativo,
            'Sucursal' => $autorizacionsar->Sucursal,
            'Fecha_Limite'=>$autorizacionsar->Fecha_Limite,
            ];
           
            $Cod_Autorizacion = (int) $autorizacionsar->Cod_Autorizacion;
            
           if ($Cod_Autorizacion == null) {
               $this->tableGateway->insert($data);
               return;
           } 
     }
     public function UpdateConsecutivoActual($Cod_Autorizacion,$Consecutivo_Actual_Establ,$Consecutivo_Actual_Punto,$Consecutivo_Actual_Tipo,$Consecutivo_Actual_Correlativo)
     {
            $data = [   
            'Consecutivo_Actual_Establ'=>$Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'=>$Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'=>$Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'=>$Consecutivo_Actual_Correlativo,
            ];
            $this->tableGateway->update($data, ['Cod_Autorizacion' => $Cod_Autorizacion]);
            return;

     }
 }