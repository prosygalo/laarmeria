<?php
namespace UnidadTransporte\Model;


class UnidadTransporte  
{ 
    public $Cod_Unidad;
    public $Marca_Vehiculo;
    public $Modelo_Vehiculo;
    public $Placa_Vehiculo;
    public $Estado;
    public $Fecha_Ingreso;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Unidad = !empty($data['Cod_Unidad']) ? $data['Cod_Unidad'] : null;
        $this->Placa_Vehiculo = !empty($data['Placa_Vehiculo']) ? $data['Placa_Vehiculo'] : null;
        $this->Marca_Vehiculo = !empty($data['Marca_Vehiculo']) ? $data['Marca_Vehiculo'] : null;
        $this->Modelo_Vehiculo = !empty($data['Modelo_Vehiculo']) ? $data['Modelo_Vehiculo'] : null;
        $this->Estado = !empty($data['Estado']) ? $data['Estado'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'Cod_Unidad' => $this->Cod_Unidad,
            'Marca_Vehiculo' => $this->Marca_Vehiculo,
            'Modelo_Vehiculo' => $this->Modelo_Vehiculo,
            'Placa_Vehiculo' => $this->Placa_Vehiculo,
            'Estado' => $this->Estado,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
        ];
    }
    
}

