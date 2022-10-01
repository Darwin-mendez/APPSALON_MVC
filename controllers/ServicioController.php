<?php 

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        session_start();
        isAdmin();                                      //valida que el usuario sea Admin
        
        $servicios = Servicio::all();
        
        $router->render('servicios/index',[ //vista 
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAdmin();
        $servicio = new Servicio;
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){  //Se usa ya q crear, tiene llamada post y get
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        
        $router->render('servicios/crear',[ //vista 
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        session_start();  
        isAdmin();                                      
        if(!is_numeric($_GET['id'])) return;   //valida q sea numero, sanitiza el id de la url      
        $servicio = Servicio::find($_GET['id']);    //busca el servicio,  por su campo id, metodo de ActiveRecord.php
        if($servicio === null){                     //valida que el numero exista en la db
            header('Location: /servicios');
        }
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){  //Se usa ya q crear, tiene llamada post y get
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar',[ //vista 
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){   
        session_start();      
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){  //Se usa ya q crear, tiene llamada post y get
            $id = $_POST['id'];
            $servicio = Servicio::find($id);

            $servicio->eliminar();                      //llama la funcion eliminar de el modelo ActiveRecord.php
            header('Location: /servicios');
        }
        
    }

}