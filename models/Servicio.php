<?php

namespace Model;

class Servicio extends ActiveRecord{            //extends es una herencia de ActiveRecord
    //Configuracion de Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio'];    //nombre de las columnas de la db

    //declarar atributos 
    public $id;
    public $nombre;
    public $precio;

    //crear el constructor con un arreglo vacio
    public function __construct($args = []){  

        //asignar valores a el arreglo asociativo $args
        $this -> id = $args ['id'] ?? null;
        $this -> nombre = $args ['nombre'] ?? null;
        $this -> precio = $args ['precio'] ?? null;
    }
    
    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][]='El Nombre del Servicio es Obligatorio';
        }
        if(!$this->precio){                                          
            self::$alertas['error'][]='El Precio del Servicio es Obligatorio';
        }
        if(!is_numeric($this->precio)){                                           //valida que el contenido sea número
            self::$alertas['error'][]='El Precio no es válido';
        }
        return self::$alertas;
    }
    
}