<?php

namespace Departamento\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;


class DepartamentoTable
{
    private $DepartamentoTableGateway;
    
     public function __construct(TableGatewayInterface $DepartamentoTableGateway)
     {
               
                $this->DepartamentoTableGateway = $DepartamentoTableGateway;
     }     
 
     public function fetchAll()
     {
                
              return $this->DepartamentoTableGateway->select();
              
     }

     public function getDepartamentoListado(){
                $rowset = $this->DepartamentoTableGateway->getSql()->select();
                $rowset->columns(array('Cod_Departamento','Nombre_Depto'));
                $resultSet = $this->DepartamentoTableGateway->selectWith($rowset);
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Departamento] = $row->Nombre_Depto;
                }
                   return $data;
                 
    }
    public function getDepto($Cod_Departamento)
     {
                $Cod_Departamento = $Cod_Departamento;
                $rowset = $this->DepartamentoTableGateway->select(['Cod_Departamento' => $Cod_Departamento]);
                $row = $rowset->current();
                if (! $row) {
                    return false;
                }
                return $row;
     }
    
    public function saveDepto(Departamento $departamento)
     {
            $data = [
                'Cod_Departamento' => $departamento->Cod_Departamento,
                'Nombre_Depto'  => $departamento->Nombre_Depto,
            ];
           
            $Cod_Departamento = $departamento->Cod_Departamento;

            
           if ($Cod_Departamento != null) {
               $this->DepartamentoTableGateway->insert($data);
               return;
        
            }

     }
     public function updateDepto(Departamento $departamento)
    {          $data = [
                'Cod_Departamento' => $departamento->Cod_Departamento,
                'Nombre_Depto'  => $departamento->Nombre_Depto,
                 ];

               $Cod_Departamento = $departamento->Cod_Departamento;


                try {
                    
                    $this->getDepto($Cod_Departamento);
                } catch (RuntimeException $e) {
                    /*throw new RuntimeException(sprintf(
                        'No se puede actualizar departamento con identificador',
                        ));*/
                        return false;
                }

                $this->DepartamentoTableGateway->update($data, ['Cod_Departamento' => $Cod_Departamento]);
                return;
    }     

}