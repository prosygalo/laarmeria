<?php
namespace Cliente\Model;

class Cliente  
{ 
    public $Cod_Cliente;
    public $Nombres_Cliente;
    public $Apellidos_Cliente;
    public $Rtn_Dni;
    public $Fecha_Ingreso;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Cliente = !empty($data['Cod_Cliente']) ? $data['Cod_Cliente'] : null;
        $this->Nombres_Cliente = !empty($data['Nombres_Cliente']) ? $data['Nombres_Cliente'] : null;
        $this->Apellidos_Cliente = !empty($data['Apellidos_Cliente']) ? $data['Apellidos_Cliente'] : null;
        $this->Rtn_Dni= !empty($data['Rtn_Dni']) ? $data['Rtn_Dni'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;

    }
   

    public function getArrayCopy()
    {
        return [
            'Cod_Cliente' => $this->Cod_Cliente,
            'Nombres_Cliente' => $this->Nombres_Cliente,
            'Apellidos_Cliente' => $this->Apellidos_Cliente,
            'Rtn_Dni'=>$this->Rtn_Dni,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
        ];
    }
    
}