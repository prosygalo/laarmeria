<?php
namespace Departamento\Model;


class Departamento  
{ 
    public $Cod_Departamento;
    public $Nombre_Depto;
    public $Sucursal;
    public $Fecha_Ingreso;
    public $Fecha_Actualizacion;
    public $Cod_Sucursal;
    public $Nombre_Sucursal;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Departamento = !empty($data['Cod_Departamento']) ? $data['Cod_Departamento'] : null;
        $this->Nombre_Depto = !empty($data['Nombre_Depto']) ? $data['Nombre_Depto'] : null;
        $this->Sucursal = !empty($data['Sucursal']) ? $data['Sucursal'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Fecha_Actualizacion = !empty($data['Fecha_Actualizacion']) ? $data['Fecha_Actualizacion'] : null;
        $this->Cod_Sucursal = !empty($data['Cdo_Sucursal']) ? $data['Cod_Sucursal'] : null;
        $this->Nombre_Sucursal = !empty($data['Nombre_Sucursal']) ? $data['Nombre_Sucursal'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'Cod_Departamento' => $this->Cod_Departamento,
            'Nombre_Depto' => $this->Nombre_Depto,
            'Sucursal' => $this->Sucursal,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
            'Fecha_actualizacion'=>$this->Fecha_Actualizacion,
        ];
    }
    
}

