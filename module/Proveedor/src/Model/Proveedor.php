<?php
namespace Proveedor\Model;

class Proveedor  
{ 
    public $Cod_Proveedor;
    public $Nombre_Proveedor;
    public $Direccion_Proveedor;
    public $Telefono_Proveedor;
    public $RTN_Proveedor;
    public $Fecha_Ingreso;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Proveedor = !empty($data['Cod_Proveedor']) ? $data['Cod_Proveedor'] : null;
        $this->Nombre_Proveedor = !empty($data['Nombre_Proveedor']) ? $data['Nombre_Proveedor'] : null;
        $this->Direccion_Proveedor = !empty($data['Direccion_Proveedor']) ? $data['Direccion_Proveedor'] : null;
        $this->Telefono_Proveedor = !empty($data['Telefono_Proveedor']) ? $data['Telefono_Proveedor'] : null;
        $this->RTN_Proveedor = !empty($data['RTN_Proveedor']) ? $data['RTN_Proveedor'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
    }
   

    public function getArrayCopy()
    {
        return [
            'Cod_Proveedor' => $this->Cod_Proveedor,
            'Nombre_Proveedor' => $this->Nombre_Proveedor,
            'Direccion_Proveedor' => $this->Direccion_Proveedor,
            'Telefono_Proveedor'=>$this->Telefono_Proveedor,
            'RTN_Proveedor'=>$this->RTN_Proveedor,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
        ];
    }
    
}