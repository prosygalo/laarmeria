<?php
namespace Boletacompra\Model;

class Boletacompra 
{ 
    public $Cod_Boleta;
    public $Fecha_Emision;
    public $Consecutivo_Actual_Establ;
    public $Consecutivo_Actual_Punto;
    public $Consecutivo_Actual_Tipo;
    public $Consecutivo_Actual_Correlativo;
    public $Autorizacion_Sar;
    public $Sucursal;
    public $Fecha_Ingreso;
    public $Usuario;
    //detalle
    public $Cod_Detalle;
    public $Cantidad;
    public $Nombre_Producto;
    //sucursal
    public $Nombre_Sucursal;
    public $Direccion;
    public $Correo;
    public $Telefono;
    public $RTN;


    public function exchangeArray(array $data)
    {   
        $this->Cod_Boleta = !empty($data['Cod_Boleta']) ? $data['Cod_Boleta'] : null;
        $this->Fecha_Emision = !empty($data['Fecha_Emision']) ? $data['Fecha_Emision'] : null;
        $this->Consecutivo_Actual_Establ = !empty($data['Consecutivo_Actual_Establ']) ? $data['Consecutivo_Actual_Establ'] : null;
        $this->Consecutivo_Actual_Punto = !empty($data['Consecutivo_Actual_Punto']) ? $data['Consecutivo_Actual_Punto'] : null;
        $this->Consecutivo_Actual_Tipo = !empty($data['Consecutivo_Actual_Tipo']) ? $data['Consecutivo_Actual_Tipo'] : null;
        $this->Consecutivo_Actual_Correlativo = !empty($data['Consecutivo_Actual_Correlativo']) ? $data['Consecutivo_Actual_Correlativo'] : null;
        $this->Autorizacion_Sar = !empty($data['Autorizacion_Sar']) ? $data['Autorizacion_Sar'] : null;
        $this->Sucursal = !empty($data['Sucursal']) ? $data['Sucursal'] : null;
        $this->Fecha_Ingreso = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Usuario = !empty($data['Usuario']) ? $data['Usuario'] : null;
        //Propiedad de la tabla producto
        $this->Cod_Detalle = !empty($data['Cod_Detalle']) ? $data['Cod_Detalle'] : null;
        $this->Cod_Producto = !empty($data['Cod_Producto']) ? $data['Cod_Producto'] : null;
        $this->Cantidad= !empty($data['Cantidad']) ? $data['Cantidad'] : null;
        $this->Nombre_Producto= !empty($data['Nombre_Producto']) ? $data['Nombre_Producto'] : null;
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
            'Cod_Boleta' => $this->Cod_Boleta,
            'Fecha_Emision' =>$this->Fecha_Emision,
            'Consecutivo_Actual_Establ'  => $this->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $this->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $this->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $this->Consecutivo_Actual_Correlativo,
            'Autorizacion_Sar' => $this->Autorizacion_Sar,
            'Sucursal' => $this->Sucursal,
            'Fecha_Ingreso'  => $this->Fecha_Ingreso,
            'Usuario'  => $this->Usuario,
            'Cod_Detalle' => $this->Cod_Detalle,
            'Cod_Producto' => $this->Cod_Producto,
            'Cantidad'  => $this->Cantidad,
            
          
        ];
    }
    
}