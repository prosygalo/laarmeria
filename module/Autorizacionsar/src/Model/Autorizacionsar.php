<?php
namespace Autorizacionsar\Model;

class Autorizacionsar 
{ 
    public $Cod_Autorizacion;
    public $Tipo_de_Documento;
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
    public $Nombre_Sucursal;
    public $Fecha_Limite;
    public $Fecha_Ingreso;


    public function exchangeArray(array $data)
    {   
        $this->Cod_Autorizacion = !empty($data['Cod_Autorizacion']) ? $data['Cod_Autorizacion'] : null;
        $this->Tipo_de_Documento = !empty($data['Tipo_de_Documento']) ? $data['Tipo_de_Documento'] : null;
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
        $this->Nombre_Sucursal = !empty($data['Nombre_Sucursal']) ? $data['Nombre_Sucursal'] : null;
        $this->Fecha_Limite = !empty($data['Fecha_Limite']) ? $data['Fecha_Limite'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        //documento fiscales


    }
    
}

