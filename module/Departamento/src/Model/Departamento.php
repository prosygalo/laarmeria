<?php
namespace Departamento\Model;


class Departamento  
{ 
    public $Cod_Departamento;
    public $Nombre_Depto;
    public $Fecha_Ingreso;
   

    public function exchangeArray(array $data)
    {   
        $this->Cod_Departamento = !empty($data['Cod_Departamento']) ? $data['Cod_Departamento'] : null;
        $this->Nombre_Depto = !empty($data['Nombre_Depto']) ? $data['Nombre_Depto'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'Cod_Departamento' => $this->Cod_Departamento,
            'Nombre_Depto' => $this->Nombre_Depto,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
        ];
    }
    
}

