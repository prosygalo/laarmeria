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
                $sqlSelect->columns(array('Cod_Autorizacion','Tipo_de_Documento','Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite','Sucursal','Fecha_Ingreso'));
                $sqlSelect->join('Sucursales', 'sucursales.Cod_sucursal = autorizaciones_sar.Sucursal', array('Nombre_Sucursal'), 'left');
                $sqlSelect->join('tipo_documento_fiscal', 'tipo_documento_fiscal.Cod_Documento = autorizaciones_sar.Tipo_de_Documento', array('Nombre_Documento'), 'left');
                $sqlSelect->order('Cod_Autorizacion ASC');

                 $resultSet = $this->tableGateway->selectWith($sqlSelect);
                 return $resultSet;
    }
    
    public function getCai($Cod_Autorizacion)
     {
                $Cod_Autorizacion = $Cod_Autorizacion;
                $sql = $this->tableGateway->getSql()->select();
                $sql->columns(array('Cai'));
                $sql->where(['Cod_Autorizacion' => $Cod_Autorizacion]);
                $resultSet = $this->tableGateway->selectWith($sql);
                 return $resultSet;


     }
     public function getAutorizacionReporte($Cod_Autorizacion)
     {
                $Cod_Autorizacion = $Cod_Autorizacion;
                $sqlSelect = $this->tableGateway->getSql()->select();
                $sqlSelect->columns(array('Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite'));
                $sqlSelect->Where(['Cod_Autorizacion' => $Cod_Autorizacion]);
                 $resultSet = $this->tableGateway->selectWith($sqlSelect);
                return $resultSet;
     }
     public function getUltimaAutorizacionBoletaRemision($Sucursal)
     {        
            $Tipo_de_Documento = '1';
            $Sucursal = $Sucursal;

            $subquery2=$this->tableGateway->getSql()->select();
            $subquery2->columns(['Cod_Autorizacion' => new  Expression('MAX(Cod_Autorizacion)')]);
            $subquery2->Where(['Tipo_de_Documento'=>$Tipo_de_Documento]);
            $subquery2->Having(['Sucursal' => $Sucursal]);
          

            $rowset=$this->tableGateway->getSql()->select();
            $rowset->columns(['Cod_Autorizacion' ,'Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite','Sucursal','Fecha_Ingreso']);
            $rowset->where(['Cod_Autorizacion'=>($subquery2)]);
            $resultSet=$this->tableGateway->selectWith($rowset);
            return $resultSet;

        
    }
     public function getUltimaAutorizacionBoletaCompra($Sucursal)
     {        
            $Tipo_de_Documento = '2';
            $Sucursal = $Sucursal;

            $subquery2=$this->tableGateway->getSql()->select();
            $subquery2->columns(['Cod_Autorizacion' => new  Expression('MAX(Cod_Autorizacion)')]);
            $subquery2->Where(['Tipo_de_Documento'=>$Tipo_de_Documento]);
            $subquery2->Having(['Sucursal'=>$Sucursal]);
          
                    
            $rowset=$this->tableGateway->getSql()->select();
            $rowset->columns(['Cod_Autorizacion' ,'Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite','Sucursal','Fecha_Ingreso']);
            $rowset->where(['Cod_Autorizacion'=>($subquery2)]);
            $resultSet=$this->tableGateway->selectWith($rowset);
            return $resultSet;
       
     }
      public function getUltimaAutorizacionConstanciaRetencion($Sucursal)
     {        
            $Tipo_de_Documento = '3';
            $Sucursal = $Sucursal;

            $subquery=$this->tableGateway->getSql()->select();
            $subquery->columns(['Cod_Autorizacion' => new  Expression('MAX(Cod_Autorizacion)')]);
            $subquery->Where(['Tipo_de_Documento'=>$Tipo_de_Documento]);
            $subquery->Having(['Sucursal'=>$Sucursal]);
          
                    
            $rowset=$this->tableGateway->getSql()->select();
            $rowset->columns(['Cod_Autorizacion' ,'Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite','Sucursal','Fecha_Ingreso']);
            $rowset->where(['Cod_Autorizacion'=>($subquery)]);
            $resultSet=$this->tableGateway->selectWith($rowset);
            return $resultSet;       
     }
     public function getUltimaAutorizacionNotaDebito($Sucursal)
     {      
            $Tipo_de_Documento = '4';
            $Sucursal = $Sucursal;

            $subquery2=$this->tableGateway->getSql()->select();
            $subquery2->columns(['Cod_Autorizacion' => new  Expression('MAX(Cod_Autorizacion)')]);
            $subquery2->Where(['Tipo_de_Documento'=>$Tipo_de_Documento]);
            $subquery2->Having(['Sucursal'=>$Sucursal]);
                    
            $rowset=$this->tableGateway->getSql()->select();
            $rowset->columns(['Cod_Autorizacion' ,'Cai','Consecutivo_Inicial_Establ','Consecutivo_Inicial_Punto','Consecutivo_Inicial_Tipo','Consecutivo_Inicial_Correlativo','Consecutivo_Final_Establ','Consecutivo_Final_Punto','Consecutivo_Final_Tipo','Consecutivo_Final_Correlativo','Consecutivo_Actual_Establ','Consecutivo_Actual_Punto','Consecutivo_Actual_Tipo','Consecutivo_Actual_Correlativo','Fecha_Limite','Sucursal','Fecha_Ingreso']);
            $rowset->where(['Cod_Autorizacion'=>($subquery2)]);
            $resultSet=$this->tableGateway->selectWith($rowset);
            return $resultSet;     
     }

     // he definitely knows how to work with the pipe
    public function insertAuto(Autorizacionsar $autorizacionsar)
     {
            $data = [
            'Tipo_de_Documento' => $autorizacionsar->Tipo_de_Documento,
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