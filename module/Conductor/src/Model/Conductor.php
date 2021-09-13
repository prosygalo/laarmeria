<?php
namespace Conductor\Model;

class Conductor  
{ 
    public $Cod_Conductor;
    public $Nombres_Conductor;
    public $Apellidos_Conductor;
    public $Licencia_Conducir;
    public $Estado;
    public $Fecha_Ingreso;
    public $Fecha_Actualizacion;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Conductor = !empty($data['Cod_Conductor']) ? $data['Cod_Conductor'] : null;
        $this->Nombres_Conductor = !empty($data['Nombres_Conductor']) ? $data['Nombres_Conductor'] : null;
        $this->Apellidos_Conductor = !empty($data['Apellidos_Conductor']) ? $data['Apellidos_Conductor'] : null;
        $this->Licencia_Conducir = !empty($data['Licencia_Conducir']) ? $data['Licencia_Conducir'] : null;
        $this->Estado = !empty($data['Estado']) ? $data['Estado'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Fecha_Actualizacion = !empty($data['Fecha_Actualizacion']) ? $data['Fecha_Actualizacion'] : null;

    }
   

    public function getArrayCopy()
    {
        return [
            'Cod_Conductor' => $this->Cod_Conductor,
            'Nombres_Conductor' => $this->Nombres_Conductor,
            'Apellidos_Conductor' => $this->Apellidos_Conductor,
            'Licencia_Conducir'=>$this->Licencia_Conducir,
            'Estado'=>$this->Estado,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
            'Fecha_Actualizacion'=>$this->Fecha_Actualizacion,
        ];
    }
    
}