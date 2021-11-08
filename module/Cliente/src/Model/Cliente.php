<?php
namespace Cliente\Model;

class Cliente  
{ 
    public $Cod_Cliente;
    public $Nombres_Cliente;
    public $Apellidos_Cliente;
    public $RTN_DNI;
    public $Fecha_Ingreso;
    public $Fecha_Actualizacion;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Cliente = !empty($data['Cod_Cliente']) ? $data['Cod_Cliente'] : null;
        $this->Nombres_Cliente = !empty($data['Nombres_Cliente']) ? $data['Nombres_Cliente'] : null;
        $this->Apellidos_Cliente = !empty($data['Apellidos_Cliente']) ? $data['Apellidos_Cliente'] : null;
        $this->RTN_DNI= !empty($data['RTN_DNI']) ? $data['RTN_DNI'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Fecha_Actualizacion = !empty($data['Fecha_Actualizacion']) ? $data['Fecha_Actualizacion'] : null;

    }
   

    public function getArrayCopy()
    {
        return [
            'Cod_Cliente' => $this->Cod_Cliente,
            'Nombres_Cliente' => $this->Nombres_Cliente,
            'Apellidos_Cliente' => $this->Apellidos_Cliente,
            'RTN_DNI'=>$this->RTN_DNI,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
            'Fecha_Actualizacion'=>$this->Fecha_Actualizacion,
        ];
    }
    
}