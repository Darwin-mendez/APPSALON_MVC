<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//
function esUltimo(string $actual, string $proximo): bool{
    if($actual !== $proximo){
        return true;
    }
    return false;
}

//Funcion que revisa que el usuario este autentificado
function isAuth(): void {       //cuando una funcion no retorna nada se le asigna Void
    if(!isset($_SESSION['login'])){                 //valida que no se encuentre la variable
        header('Location: /');
    }                
}

//Funcion que revisa que el usuario este autentificado
function isAdmin(): void {       //cuando una funcion no retorna nada se le asigna Void
    if(!isset($_SESSION['admin'])){                 //valida que no se encuentre la variable
        header('Location: /');
    }                
}