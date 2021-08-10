<?php
namespace Usuario\Model;

/**
 * Agrega valores al modelo por medio del  método exchangeArray,los valores registrados  de cada elemento se extraen del modelo. Después de una validación, los datos del formulario se vuelven a colocar en el modelo para ello se utiliza el getArrayCopy. 
 */
class Entidad 
{ 
  /**
   * Define las propiedades del modelo.
   */
    public $Cod_Usuario;
    public $Cod_Empleado;
    public $Usuario;
    public $Correo;
    public $Clave;
    public $Confirmarclave;
    public $Rol;
    public $Estado;
    public $Fecha_Ingreso;
    public $Fecha_Actualizacion;

   /**
    * 
    */
    public function exchangeArray(array $data)
    {   
        $this->Cod_Usuario = !empty($data['Cod_Usuario']) ? $data['Cod_Usuario'] : null;
        $this->Cod_Empleado = !empty($data['Cod_Empleado']) ? $data['Cod_Empleado'] : null;
        $this->Usuario = !empty($data['Usuario']) ? $data['Usuario'] : null;
        $this->Correo = !empty($data['Correo']) ? $data['Correo'] : null;
        $this->Clave = !empty($data['Clave']) ? $data['Clave'] : null;
        $this->Rol = !empty($data['Rol']) ? $data['Rol'] : null;
        $this->Estado = !empty($data['Estado']) ? $data['Estado'] : null;
        $this->Fecha_Ingreso  = !empty($data['Fecha_Ingreso']) ? $data['Fecha_Ingreso'] : null;
        $this->Fecha_Actualizacion = !empty($data['Fecha_Actualizacion']) ? $data['Fecha_Actualizacion'] : null;
    }

/**
 *Al mostrar el formulario, los valores iniciales de cada elemento se extraen del modelo.Después de una validación, los datos del formulario se vuelven a colocar en el modelo.
 */
    public function getArrayCopy()
    {
        return [
            'Cod_Usuario' => $this->Cod_Usuario,
            'Cod_Empleado' => $this->Cod_Empleado,
            'Usuario' => $this->Usuario,
            'Correo' => $this->Correo, 
            'Clave' => $this->Clave,
            'Rol'=>$this->Rol,
            'Estado'=>$this->Estado,
            'Fecha_Ingreso'=>$this->Fecha_Ingreso,
            'Fecha_Actualizacion'=>$this->Fecha_Actualizacion,
        ];
    }
    
}