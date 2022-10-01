<?php 

require __DIR__ . '/../vendor/autoload.php';            
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);      //usa la dependencia de Vlucas/dotenv para llamar las variables de entorno .env u  usarlas en database.php
$dotenv->safeload();                                   //si el archivo no existe no marcara error

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);