<?php
namespace Producto\Model;

class Producto   
{ 
    public $Cod_Producto;
    public $Nombre_Producto;
    public $Descripcion;
    public $Fecha_Ingreso;
    public $Fecha_Actualizacion;

   
    public function exchangeArray(array $data)
    {   
    
        $this->Cod_Producto = !empty($data['Cod_Producto']) ? $data['Cod_Producto'] : null;
        $this->Nombre_Producto = !empty($data['Nombre_Producto']) ? $data['Nombre_Producto'] : null;
        $this->Descripcion = !empty($data['Descripcion']) ? $data['Descripcion'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Fecha_Actualizacion  = !empty($data['Fecha_Actualizacion']) ? $data['Fecha_Actualizacion'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'Cod_Producto' => $this->Cod_Producto,
            'Nombre_Producto' => $this->Nombre_Producto,
            'Descripcion'  => $this->Descripcion,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
            'Fecha_Actualizacion'=>$this->Fecha_Actualizacion,
        ];
    }
    
}

