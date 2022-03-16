<?php
namespace Producto\Model;

class Producto   
{ 
    public $Cod_Producto;
    public $Nombre_Producto;
    public $Descripcion;
    public $Precio;
    public $Cantidad;
    public $Sucursal;
    public $Fecha_Ingreso;
   
   
    public function exchangeArray(array $data)
    {   
    
        $this->Cod_Producto = !empty($data['Cod_Producto']) ? $data['Cod_Producto'] : null;
        $this->Nombre_Producto = !empty($data['Nombre_Producto']) ? $data['Nombre_Producto'] : null;
        $this->Descripcion = !empty($data['Descripcion']) ? $data['Descripcion'] : null;
        $this->Precio = !empty($data['Precio']) ? $data['Precio'] : null;
        $this->Cantidad = !empty($data['Cantidad']) ? $data['Cantidad'] : null;
        $this->Sucursal= !empty($data['Sucursal']) ? $data['Sucursal'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'Cod_Producto' => $this->Cod_Producto,
            'Nombre_Producto' => $this->Nombre_Producto,
            'Descripcion'  => $this->Descripcion,
            'Precio'  => $this->Precio,
            'Cantidad'  => $this->Cantidad,
            'Sucursal'  => $this->Sucursal,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
        ];
    }
    
}

