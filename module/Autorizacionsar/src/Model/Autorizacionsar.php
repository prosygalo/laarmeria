<?php
namespace Autorizacionsar\Model;

class Autorizacionsar 
{ 
    public $Cod_Autorizacion;
    public $Cai;
    public $Consecutivo_Inicial_Establ;
    public $Consecutivo_Inicial_Punto;
    public $Consecutivo_Inicial_Tipo;
    public $Consecutivo_Inicial_Correlativo;
    public $Consecutivo_Final_Establ;
    public $Consecutivo_Final_Punto;
    public $Consecutivo_Final_Tipo;
    public $Consecutivo_Final_Correlativo;
    public $Consecutivo_Actual_Establ;
    public $Consecutivo_Actual_Punto;
    public $Consecutivo_Actual_Tipo;
    public $Consecutivo_Actual_Correlativo;
    public $Sucursal;
    public $Fecha_Limite;
    public $Fecha_Ingreso;


    public function exchangeArray(array $data)
    {   
        $this->Cod_Autorizacion = !empty($data['Cod_Autorizacion']) ? $data['Cod_Autorizacion'] : null;
        $this->Cai = !empty($data['Cai']) ? $data['Cai'] : null;
        $this->Consecutivo_Inicial_Establ = !empty($data['Consecutivo_Inicial_Establ']) ? $data['Consecutivo_Inicial_Establ'] : null;
        $this->Consecutivo_Inicial_Punto = !empty($data['Consecutivo_Inicial_Punto']) ? $data['Consecutivo_Inicial_Punto'] : null;
        $this->Consecutivo_Inicial_Tipo = !empty($data['Consecutivo_Inicial_Tipo']) ? $data['Consecutivo_Inicial_Tipo'] : null;
        $this->Consecutivo_Inicial_Correlativo = !empty($data['Consecutivo_Inicial_Correlativo']) ? $data['Consecutivo_Inicial_Correlativo'] : null;
        $this->Consecutivo_Final_Establ = !empty($data['Consecutivo_Final_Establ']) ? $data['Consecutivo_Final_Establ'] : null;  
        $this->Consecutivo_Final_Punto = !empty($data['Consecutivo_Final_Punto']) ? $data['Consecutivo_Final_Punto'] : null;  
        $this->Consecutivo_Final_Tipo = !empty($data['Consecutivo_Final_Tipo']) ? $data['Consecutivo_Final_Tipo'] : null;  
        $this->Consecutivo_Final_Correlativo = !empty($data['Consecutivo_Final_Correlativo']) ? $data['Consecutivo_Final_Correlativo'] : null;  
        $this->Consecutivo_Actual_Establ = !empty($data['Consecutivo_Actual_Establ']) ? $data['Consecutivo_Actual_Establ'] : null;
         $this->Consecutivo_Actual_Punto = !empty($data['Consecutivo_Actual_Punto']) ? $data['Consecutivo_Actual_Punto'] : null;
          $this->Consecutivo_Actual_Tipo = !empty($data['Consecutivo_Actual_Tipo']) ? $data['Consecutivo_Actual_Tipo'] : null;
           $this->Consecutivo_Actual_Correlativo = !empty($data['Consecutivo_Actual_Correlativo']) ? $data['Consecutivo_Actual_Correlativo'] : null;  
        $this->Sucursal = !empty($data['Sucursal']) ? $data['Sucursal'] : null;
        $this->Fecha_Limite = !empty($data['Fecha_Limite']) ? $data['Fecha_Limite'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;

    }

    public function getArrayCopy()
    {
        return [
            'Cod_Autorizacion' => $this->Cod_Autorizacion,
            'Cai' => $this->Cai,
            'Consecutivo_Inicial_Establ'=>$this->Consecutivo_Inicial_Establ,
            'Consecutivo_Inicial_Punto'=>$this->Consecutivo_Inicial_Punto,
            'Consecutivo_Inicial_Tipo'=>$this->Consecutivo_Inicial_Tipo,
            'Consecutivo_Inicial_Correlativo'=>$this->Consecutivo_Inicial_Correlativo,
            'Consecutivo_Final_Establ'=>$this->Consecutivo_Final_Establ,
            'Consecutivo_Final_Punto'=>$this->Consecutivo_Final_Punto,
            'Consecutivo_Final_Tipo'=>$this->Consecutivo_Final_Tipo,
            'Consecutivo_Final_Correlativo'=>$this->Consecutivo_Final_Correlativo,
            'Consecutivo_Actual_Establ'=>$this->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'=>$this->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'=>$this->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'=>$this->Consecutivo_Actual_Correlativo,
            'Sucursal' => $this->Sucursal,
            'Fecha_Limite'=>$this->Fecha_Limite,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
        ];
    }
    
}

