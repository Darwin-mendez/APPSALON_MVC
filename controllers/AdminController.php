<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{

    public static function index( Router $router){
        session_start();

        isAdmin();                                          //protege el panel de administración, funcion helper, /includes/funciones.php

        $fecha = $_GET['fecha'] ?? date('Y-m-d');           //valida la url, si no tiene una fecha filtrada, asigana la del servidor
        $fechas = explode('-', $fecha);                     //extrae por separado los valores en un arreglo, con la condicion '-'

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){ //valida que la fecha sea real mes, dia, año
            header('Location:  /404');
        }
        

        //Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.fk_usuarioid=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.fk_citaid=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.fk_servicioid ";
        $consulta .= " WHERE fecha =  '${fecha}' ";
        
        $citas = AdminCita::SQL($consulta);

        $router -> render('admin/index',[           //vista
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}
