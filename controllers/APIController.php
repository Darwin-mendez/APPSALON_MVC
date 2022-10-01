<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{                            
    public static function index(){             //esta separado el frondEnd del BackEnd y returna un Json, no requiere router para mostrar datos
        $servicios = Servicio::all();           //Importar el models Servicio.php y llamar la funcion all de ActiveRecord.php
        echo json_encode($servicios);           //tambien consulta la db, retorna un json el cual se consme con fetch y php
    }

    public static function guardar(){           //api para guardar el FormData(app.js)
        //Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);        //instanciamiento del modelo Cita,respuesta de la api por POST o cuando se ejecuta un submit, o FormData
        $resultado = $cita->guardar();   //llamar el metodo guardar, que esta en ActiveRecord.php y guarda la cita en la DB

        //extrae el Id de resultado
        $id = $resultado['id'];

        //Almacena los servicios con el ID de la Cita
        $idServicios = explode(",", $_POST['servicios']); //separa un elemento con un valor asignado, se convierte en arreglo
        foreach($idServicios as $idServicio){      //recorre el arreglo, y realiza el constructor de CitaServicio en un arreglo asociativo
             $args = [                                //arreglo asociativo se usan flecha => para asignar valor
                 'fk_citaid' => $id,
                 'fk_servicioid' => $idServicio      //instanciar cuantos $idServicios haya disponibles
            ];            
            $citaServicio = new CitaServicio($args);        //instanciar el modelo de CitaServicios para darle los valores argumentos
            $citaServicio -> guardar();                     //llama al metodo guardar de ActiveRecord.php
            }

        //retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){  //solo se ejecuta cuando se esta en un metodo POST
            $id = $_POST['id'];
            $cita = Cita::find($id);        //llama al metodo find el cual buscara en la tabla, dependiendo del modelo usado (Cita.php)
            $cita -> eliminar();
            //debuguear($_SERVER);
            header('Location:' . $_SERVER['HTTP_REFERER']); //usa uno de los atributos de $_SERVER para devolver a la pagina anterior
        }
    }
}