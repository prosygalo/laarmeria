<?php
namespace Boletacompra\Model;

class Boletacompra 
{ 
    public $Cod_Boleta_Compra;
    public $Fecha_Emision;
    public $Consecutivo_Actual_Establ;
    public $Consecutivo_Actual_Punto;
    public $Consecutivo_Actual_Tipo;
    public $Consecutivo_Actual_Correlativo;
    public $Autorizacion_Sar;
    public $Sucursal;
    public $Total;
    //detalle
    public $Cod_Detalle;
    public $Cod_Producto;
    public $Descripcion;
    public $Cantidad;
    public $Precio;
    //sucursal
    public $Nombre_Sucursal;
    public $Direccion;
    public $Correo;
    public $Telefono;
    public $RTN;
    //Proveedor
    public $Proveedor;
    public $Nombre_Proveedor;
    public $Direccion_Proveedor;
    public $RTN_Proveedor;
    public $Telefono_Proveedor;
    //adquiriente exonerado
    public $No_Registro_Sag;
    public $No_Orden_Compra_Exenta;
    public $No_Constancia_Registro_Exonerado;
    public $Usuario;
    public $Fecha_Ingreso;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Boleta_Compra = !empty($data['Cod_Boleta_Compra']) ? $data['Cod_Boleta_Compra'] : null;
        $this->Fecha_Emision = !empty($data['Fecha_Emision']) ? $data['Fecha_Emision'] : null;
        $this->Consecutivo_Actual_Establ = !empty($data['Consecutivo_Actual_Establ']) ? $data['Consecutivo_Actual_Establ'] : null;
        $this->Consecutivo_Actual_Punto = !empty($data['Consecutivo_Actual_Punto']) ? $data['Consecutivo_Actual_Punto'] : null;
        $this->Consecutivo_Actual_Tipo = !empty($data['Consecutivo_Actual_Tipo']) ? $data['Consecutivo_Actual_Tipo'] : null;
        $this->Consecutivo_Actual_Correlativo = !empty($data['Consecutivo_Actual_Correlativo']) ? $data['Consecutivo_Actual_Correlativo'] : null;
        $this->Autorizacion_Sar = !empty($data['Autorizacion_Sar']) ? $data['Autorizacion_Sar'] : null;
        $this->Sucursal = !empty($data['Sucursal']) ? $data['Sucursal'] : null;
        $this->Total = !empty($data['Total']) ? $data['Total'] : null;
        //Propiedad de la tabla producto
        $this->Cod_Detalle = !empty($data['Cod_Detalle']) ? $data['Cod_Detalle'] : null;
        $this->Producto = !empty($data['Producto']) ? $data['Producto'] : null;
        $this->Descripcion = !empty($data['Descripcion']) ? $data['Descripcion'] : null;
        $this->Cantidad= !empty($data['Cantidad']) ? $data['Cantidad'] : null;
        $this->Precio= !empty($data['Precio']) ? $data['Precio'] : null;
        //Propiedades de otras tablegateway
        $this->Nombre_Sucursal = !empty($data['Nombre_Sucursal']) ? $data['Nombre_Sucursal'] : null;
        $this->Direccion = !empty($data['Direccion']) ? $data['Direccion'] : null;
        $this->Correo = !empty($data['Correo']) ? $data['Correo'] : null;
        $this->Telefono = !empty($data['Telefono']) ? $data['Telefono'] : null;
        $this->RTN = !empty($data['RTN']) ? $data['RTN'] : null;
        //Propiedades proveedor
        $this->Proveedor = !empty($data['Proveedor']) ? $data['Proveedor'] : null;
        $this->Nombre_Proveedor = !empty($data['Nombre_Proveedor']) ? $data['Nombre_Proveedor'] : null;
        $this->Direccion_Proveedor = !empty($data['Direccion_Proveedor']) ? $data['Direccion_Proveedor'] : null;
        $this->Telefono_Proveedor = !empty($data['Telefono_Proveedor']) ? $data['Telefono_Proveedor'] : null;
        $this->RTN_Proveedor = !empty($data['RTN_Proveedor']) ? $data['RTN_Proveedor'] : null;
        //Propiedades de otras tablegateway
        $this->No_Registro_Sag = !empty($data['No_Registro_Sag']) ? $data['No_Registro_Sag'] : null;
        $this->No_Orden_Compra_Exenta = !empty($data['No_Orden_Compra_Exenta']) ? $data['No_Orden_Compra_Exenta'] : null;
        $this->No_Constancia_Registro_Exonerado = !empty($data['No_Constancia_Registro_Exonerado']) ? $data['No_Constancia_Registro_Exonerado'] : null;
        $this->Usuario = !empty($data['Usuario']) ? $data['Usuario'] : null;
        $this->Fecha_Ingreso = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;

    }
    
    public function getArrayCopy()
    {
        return [
            'Cod_Boleta_Compra' => $this->Cod_Boleta_Compra,
            'Fecha_Emision' =>$this->Fecha_Emision,
            'Consecutivo_Actual_Establ'  => $this->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $this->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $this->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $this->Consecutivo_Actual_Correlativo,
            'Autorizacion_Sar' => $this->Autorizacion_Sar,
            'Sucursal' => $this->Sucursal,
            'Total' => $this->Total,
            'Cod_Detalle' => $this->Cod_Detalle,
            'Producto' => $this->Producto,
            'Descripcion' => $this->Descripcion,
            'Cantidad'  => $this->Cantidad,
            'Precio'  => $this->Precio,
            'Proveedor' => $this->Proveedor,
            'No_Registro_Sag' => $this->No_Registro_Sag,
            'No_Orden_Compra_Exenta' => $this->No_Orden_Compra_Exenta,
            'No_Constancia_Registro_Exonerado'  => $this->No_Constancia_Registro_Exonerado,
            'Usuario'  => $this->Usuario,
            'Fecha_Ingreso'  => $this->Fecha_Ingreso, 
        ];
    }
    
}
