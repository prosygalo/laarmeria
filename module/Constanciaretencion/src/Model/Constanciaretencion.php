<?php
namespace Constanciaretencion\Model;

class Constanciaretencion 
{ 
    public $Cod_Constancia;
    public $Fecha_Emision;
    public $Autorizacion_Sar;
    public $Sucursal;
    public $Consecutivo_Actual_Establ;
    public $Consecutivo_Actual_Punto;
    public $Consecutivo_Actual_Tipo;
    public $Consecutivo_Actual_Correlativo;
    public $Tipo_Retencion;
    public $Proveedor;
    public $Base_Gravable_Impuesto;
    public $Importe_Retencion;
    public $Documento_Retencion;
    public $No_Correlativo;
    public $RTN_Proveedor;
    public $Cai_Documento;
    public $Descripcion_Tributo_Retenido;
    public $Usuario;
    public $Fecha_Ingreso;
     //sucursal
    public $Nombre_Sucursal;
    public $Direccion;
    public $Correo;
    public $Telefono;
    public $RTN;


    public function exchangeArray(array $data)
    {   
        $this->Cod_Constancia = !empty($data['Cod_Constancia']) ? $data['Cod_Constancia'] : null;
        $this->Fecha_Emision = !empty($data['Fecha_Emision']) ? $data['Fecha_Emision'] : null;
        $this->Autorizacion_Sar = !empty($data['Autorizacion_Sar']) ? $data['Autorizacion_Sar'] : null;
        $this->Sucursal = !empty($data['Sucursal']) ? $data['Sucursal'] : null;
        $this->Consecutivo_Actual_Establ = !empty($data['Consecutivo_Actual_Establ']) ? $data['Consecutivo_Actual_Establ'] : null;
        $this->Consecutivo_Actual_Punto = !empty($data['Consecutivo_Actual_Punto']) ? $data['Consecutivo_Actual_Punto'] : null;
        $this->Consecutivo_Actual_Tipo = !empty($data['Consecutivo_Actual_Tipo']) ? $data['Consecutivo_Actual_Tipo'] : null;
        $this->Consecutivo_Actual_Correlativo = !empty($data['Consecutivo_Actual_Correlativo']) ? $data['Consecutivo_Actual_Correlativo'] : null;
        $this->Tipo_Retencion = !empty($data['Tipo_Retencion']) ? $data['Tipo_Retencion'] : null;
        $this->Proveedor= !empty($data['Proveedor']) ? $data['Proveedor'] : null;
        $this->Base_Gravable_Impuesto = !empty($data['Base_Gravable_Impuesto']) ? $data['Base_Gravable_Impuesto'] : null;
        $this->Importe_Retencion = !empty($data['Importe_Retencion']) ? $data['Importe_Retencion'] : null;
        $this->Documento_Retencion = !empty($data['Documento_Retencion']) ? $data['Documento_Retencion'] : null;
        $this->No_Correlativo = !empty($data['No_Correlativo']) ? $data['No_Correlativo'] : null;
        $this->RTN_Proveedor= !empty($data['RTN_Proveedor']) ? $data['RTN_Proveedor'] : null;
        $this->Cai_Documento = !empty($data['Cai_Documento']) ? $data['Cai_Documento'] : null;
        $this->Descripcion_Tributo_Retenido = !empty($data['Descripcion_Tributo_Retenido']) ? $data['Descripcion_Tributo_Retenido'] : null;
        $this->Fecha_Ingreso = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Usuario = !empty($data['Usuario']) ? $data['Usuario'] : null;
        //Propiedades de otras tablegateway
        $this->Nombre_Sucursal = !empty($data['Nombre_Sucursal']) ? $data['Nombre_Sucursal'] : null;
        $this->Direccion = !empty($data['Direccion']) ? $data['Direccion'] : null;
        $this->Correo = !empty($data['Correo']) ? $data['Correo'] : null;
        $this->Telefono = !empty($data['Telefono']) ? $data['Telefono'] : null;
        $this->RTN = !empty($data['RTN']) ? $data['RTN'] : null;
        
        
        
    }
    
    public function getArrayCopy()
    {
        return [
            'Cod_Constancia' => $this->Cod_Constancia,
            'Fecha_Emision' =>$this->Fecha_Emision,
            'Autorizacion_Sar' => $this->Autorizacion_Sar,
            'Sucursal' => $this->Sucursal,
            'Consecutivo_Actual_Establ'  => $this->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $this->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo' => $this->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo' => $this->Consecutivo_Actual_Correlativo,
            'Tipo_Retencion'  => $this->Tipo_Retencion,
            'Proveedor' => $this->Proveedor,
            'Base_Gravable_Impuesto' => $this->Base_Gravable_Impuesto,
            'Importe_Retencion'  => $this->Importe_Retencion,
            'Documento_Retencion' => $this->Fecha_Inicio_Traslado,
            'No_Correlativo' => $this->No_Correlativo,
            'RTN_Proveedor' => $this->RTN_Proveedor,
            'Cai_Documento' => $this->Cai_Documento,
            'Descripcion_Tributo_Retenido'  => $this->Descripcion_Tributo_Retenido,
            'Fecha_Ingreso'  => $this->Fecha_Ingreso,
            'Usuario'  => $this->Usuario,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
        ];
    }   
}