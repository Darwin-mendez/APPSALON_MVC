<?php

namespace Model;


class Cita extends ActiveRecord{
    //Base de datos                         
    protected static $tabla = 'citas';          
    protected static $columnasDB = ['id','fecha','hora','fk_usuarioid'];

    //variables q se usaran para interactuar con los campos de la DB
    public $id;
    public $fecha;
    public $hora;
    public $fk_usuarioid;
    

    //si no tiene valor se asigna null o string vacio
    public function __construct($args = []){     
        $this-> id =  $args ['id'] ?? null;
        $this-> fecha =  $args ['fecha'] ?? '';
        $this-> hora =  $args ['hora'] ?? '';
        $this-> fk_usuarioid =  $args ['fk_usuarioid'] ?? '';
    }
}