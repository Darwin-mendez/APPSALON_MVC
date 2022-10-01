<?php

namespace Controllers;       //conecion con el composer

use MVC\Router;             //importar libreria de compuser para poder usar el router

class CitaController{
    public static function index( Router $router){
        session_start();        

        isAuth();

        $router->render('cita/index',[
            'nombre'=> $_SESSION['nombre'],   //envia a la vista una variable con el campo seleccionado de la seción
            'id'=> $_SESSION['id']   
        ]);
    }
}