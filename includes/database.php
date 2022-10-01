<?php

$db = mysqli_connect(           //variables de entorno, proteje la conexion a la db
    $_ENV['DB_HOST'], 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'], 
    $_ENV['DB_BD']);

$db->set_charset("utf8");       //formatear la conexión a la base de datos a utf8, visualisar json y mostrar la Ñ (collation y charset)

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
