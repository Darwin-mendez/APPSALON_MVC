<?php 

//modelo de la consulta que conecta todas las tablas de la DB y lo tenga en memoria 

namespace Model;

class AdminCita extends ActiveRecord{
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'hora', 'cliente', 'email', 
    'telefono', 'servicio', 'precio'];      //la información se genera previamente en la consulta luego se usa el modelo

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct(){                                                  //MODELO QUE ESTA EN MEMORIA
        $this -> id = $args['id'] ??  null;                                         // Es el resultado de una Consulta avanzada
        $this -> hora = $args['hora'] ??  '';
        $this -> cliente = $args['cliente'] ??  '';
        $this -> email = $args['email'] ??  '';
        $this -> telefono = $args['telefono'] ??  '';
        $this -> servicio = $args['servicio'] ??  '';
        $this -> precio = $args['precio'] ??  '';
    }
}
