<?php

namespace Model;

class CitaServicio  extends ActiveRecord{
     //Base de datos 
    protected static $tabla = 'citasservicios';                 //nombre de la tabla de la DB
    protected static $columnasDB = ['id', 'fk_citaid', 'fk_servicioid'];    //nombre de los campos de la DB

    //copia de los campos de la tabla
    public $id;
    public $fk_citaid;
    public $fk_servicioid;

    //creacion del constructor, arreglo vacio
    public function __construct($args = []){ 
        $this->id = $args ['id' ?? null];
        $this->fk_citaid = $args ['fk_citaid' ?? ''];
        $this->fk_servicioid = $args ['fk_servicioid' ?? ''];
    }
}