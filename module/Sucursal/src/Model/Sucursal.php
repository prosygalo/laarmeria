<?php
namespace Sucursal\Model;

class Sucursal  
{ 
  
    public $Cod_Sucursal;
    public $Nombre_Sucursal;
    public $RTN;
    public $Direccion;
    public $Telefono;
    public $Correo;
    public $Estado;
    public $Fecha_Ingreso;
    public $Fecha_Actualizacion;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Sucursal = !empty($data['Cod_Sucursal']) ? $data['Cod_Sucursal'] : null;
        $this->Nombre_Sucursal = !empty($data['Nombre_Sucursal']) ? $data['Nombre_Sucursal'] : null;
        $this->RTN = !empty($data['RTN']) ? $data['RTN'] : null;
        $this->Direccion = !empty($data['Direccion']) ? $data['Direccion'] : null;
        $this->Telefono = !empty($data['Telefono']) ? $data['Telefono'] : null;
        $this->Correo = !empty($data['Correo']) ? $data['Correo'] : null;
        $this->Estado = !empty($data['Estado']) ? $data['Estado'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Fecha_Actualizacion  = !empty($data['Fecha_Actualizacion']) ? $data['Fecha_Actualizacion'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'Cod_Sucursal' => $this->Cod_Sucursal,
            'Nombre_Sucursal' => $this->Nombre_Sucursal,
            'RTN'  => $this->RTN,
            'Direccion'  => $this->Direccion,
            'Telefono'  => $this->Telefono,
            'Correo'  => $this->Correo,
            'Estado'=>$this->Estado,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
            'Fecha_Actualizacion'=>$this->Fecha_Actualizacion,
        ];
    }
    
}

