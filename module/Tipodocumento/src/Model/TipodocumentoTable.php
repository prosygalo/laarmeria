<?php

namespace Tipodocumento\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;


class TipodocumentoTable
{
    private $TipodocumentoTableGateway;

    public function __construct(TableGatewayInterface $TipodocumentoTableGateway)
     {
               $this->tableGateway = $TipodocumentoTableGateway;
     }

     public function fetchAll()
     {
               return $this->tableGateway->select();
     }

    public function getTipoDocumento($Cod_Documento)
     {
                $Cod_Documento = $Cod_Documento;
                $rowset = $this->tableGateway ->select(['Cod_Documento' => $Cod_Documento]);
                $row = $rowset->current();
                if (! $row) {
                   return false;
                }
                return $row;
     } 
     public function getTipoDocumentoSelect(){

                $rowset = $this->tableGateway ->getSql()->select();
                $rowset->columns(array('Cod_Documento','Nombre_Documento'));
                $rowset->order('Nombre_Documento Asc');
                $resultSet = $this->tableGateway->selectWith($rowset); 
                $data= array();
                foreach($resultSet as $row){
                   $data[$row->Cod_Documento] = $row->Nombre_Documento;
                }
                   return $data;
               
     }   
    public function inserTipoDocumento(Tipodocumento $tipodocumento)
     {
            $data = [
                'Nombre_Documento'  => $tipodocumento->Nombre_Documento,
            ];
           
           $Cod_Documento = (int) $tipodocumento->Cod_Documento;
            
           if ($Cod_Documento == null) {
               $this->tableGateway ->insert($data);
               return;
            }
             

     }
     public function updateTipoDocumento(Tipodocumento $tipodocumento)
    {
                $data = [
                    'Nombre_Documento' => $tipodocumento->Nombre_Documento,
                ];

                $Cod_Documento = $tipodocumento->Cod_Documento;


                try {
                    
                    $this->getTipoDocumento($Cod_Documento);
                } catch (RuntimeException $e) {
                     return false;
                }

                $this->tableGateway->update($data, ['Cod_Documento' => $Cod_Documento]);
                return;
    }


}