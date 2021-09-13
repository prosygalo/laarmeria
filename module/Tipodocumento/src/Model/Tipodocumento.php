<?php
namespace Tipodocumento\Model;

class Tipodocumento 
{ 
    public $Cod_Documento;
    public $Nombre_Documento;
    public $Fecha_Ingreso;
    public $Fecha_Actualizacion;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Documento = !empty($data['Cod_Documento']) ? $data['Cod_Documento'] : null;
        $this->Nombre_Documento = !empty($data['Nombre_Documento']) ? $data['Nombre_Documento'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Fecha_Actualizacion = !empty($data['Fecha_Actualizacion']) ? $data['Fecha_Actualizacion'] : null;

    }
   
    public function getArrayCopy()
    {
        return [
            'Cod_Documento' => $this->Cod_Documento,
            'Nombre_Documento' => $this->Nombre_Documento,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
            'Fecha_Actualizacion'=>$this->Fecha_Actualizacion,
        ];
    }
    
}