<?php
namespace Notadebito\Model;

class Notadebito 
{ 
    public $Cod_Nota;
    public $Fecha_Emision;
    public $Fecha_Emision_Comprobante;
    public $Consecutivo_Actual_Establ;
    public $Consecutivo_Actual_Punto;
    public $Consecutivo_Actual_Tipo;
    public $Consecutivo_Actual_Correlativo;
    public $Autorizacion_Sar;
    public $No_Correlativo;
    public $Cai_Comprobante;
    public $Sucursal;
    public $Motivo;
    public $Gravado;
    public $Exento;
    public $Exonerado;
    public $Isv;
    public $Total;
   //Productos
    public $Cod_Producto;
    public $Nombre_Producto;
    public $Descripcion;
    public $Precio;
    //detalle
    public $Cod_Detalle;
    public $Cantidad;
    //sucursal
    public $Nombre_Sucursal;
    //Cliente
    public $Cliente;
    public $RTN_DNI;
    public $Nombres_Cliente;
    //adquiriente exonerado
    public $Usuario;
    public $Fecha_Ingreso;

    public function exchangeArray(array $data)
    {   
        $this->Cod_Nota = !empty($data['Cod_Nota']) ? $data['Cod_Nota'] : null;
        $this->Fecha_Emision = !empty($data['Fecha_Emision']) ? $data['Fecha_Emision'] : null;
        $this->Fecha_Emision_Comprobante = !empty($data['Fecha_Emision_Comprobante']) ? $data['Fecha_Emision_Comprobante'] : null;
        $this->Consecutivo_Actual_Establ = !empty($data['Consecutivo_Actual_Establ']) ? $data['Consecutivo_Actual_Establ'] : null;
        $this->Consecutivo_Actual_Punto = !empty($data['Consecutivo_Actual_Punto']) ? $data['Consecutivo_Actual_Punto'] : null;
        $this->Consecutivo_Actual_Tipo = !empty($data['Consecutivo_Actual_Tipo']) ? $data['Consecutivo_Actual_Tipo'] : null;
        $this->Consecutivo_Actual_Correlativo = !empty($data['Consecutivo_Actual_Correlativo']) ? $data['Consecutivo_Actual_Correlativo'] : null;
        $this->Autorizacion_Sar = !empty($data['Autorizacion_Sar']) ? $data['Autorizacion_Sar'] : null;
        $this->No_Correlativo = !empty($data['No_Correlativo']) ? $data['No_Correlativo'] : null;
        $this->Cai_Comprobante = !empty($data['Cai_Comprobante']) ? $data['Cai_Comprobante'] : null;
        $this->Sucursal = !empty($data['Sucursal']) ? $data['Sucursal'] : null;
        $this->Motivo = !empty($data['Motivo']) ? $data['Motivo'] : null;
        $this->Gravado = !empty($data['Gravado']) ? $data['Gravado'] : null;
        $this->Exento = !empty($data['Exento']) ? $data['Exento'] : null;
        $this->Exonerado = !empty($data['Exonerado']) ? $data['Exonerado'] : null;
        $this->Isv = !empty($data['Isv']) ? $data['Isv'] : null;
        $this->Total = !empty($data['Total']) ? $data['Total'] : null;
        //Productos
        $this->Cod_Producto = !empty($data['Cod_Producto']) ? $data['Cod_Producto'] : null;
        $this->Nombre_Producto = !empty($data['Nombre_Producto']) ? $data['Nombre_Producto'] : null;
        $this->Descripcion = !empty($data['Descripcion']) ? $data['Descripcion'] : null;
        $this->Precio = !empty($data['Precio']) ? $data['Precio'] : null;
        //Propiedad de la tabla producto
        $this->Cod_Detalle = !empty($data['Cod_Detalle']) ? $data['Cod_Detalle'] : null;
        $this->Cantidad= !empty($data['Cantidad']) ? $data['Cantidad'] : null;
        //Propiedades de otras tablegateway
        $this->Nombre_Sucursal = !empty($data['Nombre_Sucursal']) ? $data['Nombre_Sucursal'] : null;
        //Propiedades proveedor
        $this->Cliente = !empty($data['Cliente']) ? $data['Cliente'] : null;
        $this->RTN_DNI = !empty($data['RTN_DNI']) ? $data['RTN_DNI'] : null;
        $this->Nombres_Cliente = !empty($data['Nombres_Cliente']) ? $data['Nombres_Cliente'] : null;
        //Propiedades de otras tablegateway
        $this->Usuario = !empty($data['Usuario']) ? $data['Usuario'] : null;
        $this->Fecha_Ingreso = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;

    }
    
    public function getArrayCopy()
    {
        return [
            'Cod_Nota' => $this->Cod_Nota,
            'Fecha_Emision' =>$this->Fecha_Emision,
            'Fecha_Emision_Comprobante' =>$this->Fecha_Emision_Comprobante,
            'Consecutivo_Actual_Establ'  => $this->Consecutivo_Actual_Establ,
            'Consecutivo_Actual_Punto'  => $this->Consecutivo_Actual_Punto,
            'Consecutivo_Actual_Tipo'  => $this->Consecutivo_Actual_Tipo,
            'Consecutivo_Actual_Correlativo'  => $this->Consecutivo_Actual_Correlativo,
            'Autorizacion_Sar' => $this->Autorizacion_Sar,
            'No_Correlativo' => $this->No_Correlativo,
            'Cai_Comprobante' => $this->Cai_Comprobante,
            'Sucursal' => $this->Sucursal,
            'Motivo' => $this->Motivo,
            'Gravado' => $this->Gravado,
            'Exento' => $this->Exento,
            'Exonerado' => $this->Exonerado,
            'Isv' => $this->Isv,
            'Total' => $this->Total,
            'Cod_Detalle' => $this->Cod_Detalle,
            'Cod_Producto' => $this->Cod_Producto,
            'Descripcion'  => $this->Descripcion,
            'Cantidad'  => $this->Cantidad,
            'Precio'  => $this->Precio,
            'Cliente' => $this->Cliente,
            'Nombres_Cliente' => $this->Nombres_Cliente,
            'Usuario'  => $this->Usuario,
            'Fecha_Ingreso'  => $this->Fecha_Ingreso, 
        ];
    }
    
}
