<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        $alertas=[];

        $auth= new Usuario;
        
        //Crear el post para cuando se precione el boton se ejecute todo lo que este en login
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth=new Usuario ($_POST);

            $alertas=$auth->validarLogin();

            if(empty($alertas)){ //valida q las alertas esten vacias para saber q tenemos datos digitados
                //comprovar q exista el usuario por medio de email
                $usuario = Usuario::where('email', $auth->email);   //metodo ActiveRecord, se conecta a la DB y recorre cada columna y valor

                if($usuario){      //Verificar el usuario; contraseña y confirmado
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {  //llamar metodo de Usuario.php
                        //autenticar al usuario
                        session_start();        //iniciar sesión

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre." ". $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;                                             

                        //Redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;                                                        
                            header('Location: /admin');
                        }else{                            
                            header('Location: /cita');
                        }                                           
                    }                
                }else{
                    Usuario::setAlerta('error','Usuario no encontrado'); 
                }
                
            }
        }
        
        $alertas = Usuario::getAlertas();   //Obtener alertas previamente guardadas en memoria, metodo de AvriveRecor.php

        $router->render('auth/login',[
            'alertas'=> $alertas,   //pasa la variables de alertas a la vista
            'auth'=>$auth
        ]);
    }

    public static function logout(){
        session_start();
        isset($_SESSION);           
        $_SESSION = [];             //limpiar el arreglo de sesion
       header('Location: /');
    }

    public static function olvide(Router $router){
        $alertas=[];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas= $auth -> validarEmail();

            if(empty($alertas)){    //valida q las alertas esten vacias para saber q tenemos datos digitados
                $usuario = Usuario::where('email', $auth->email);       //busca en la tabla por columna y valor
                
                if($usuario && $usuario->confirmado==="1"){         //valida que el usuario exista "Y" este confirmado
                    
                    //Genear 1 token de 1 solo uso
                    $usuario->crearToken();
                    $usuario->guardar();

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);   //clase email, diferente de la clase de PHPMAILER (use Classes\Email)
                    $email->enviarInstrucciones();


                    //asignar alerta de exito
                    Usuario::setAlerta('exito','Revisa tu email');
                }else{
                    Usuario::setAlerta('error','El usuario no existe o no esta confirmado');    //asignar alertas                    
                }                                
            }            
        }
        $alertas = Usuario::getAlertas();                   //obtener alertas
        $router->render('auth/olvide-password', [   //renderisar la vista
            'alertas'=>$alertas                     //arreglo asociativo
        ]);
    }

    public static function recuperar(Router $router){    //se declara el router para poder usar el render de la vista
        $alertas=[];
        $error=false;                                           //se quitar el formulario en la vista

        $token = s($_GET['token']);                               //sanitisar url

        $usuario = Usuario::where('token',$token);              //buscar usuario por su token  

        if(empty($usuario)){
            Usuario::setAlerta('error','Token no Válido');        //asignar alertas 
            $error=true;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){
            //Leer el nuevo password y guardarlo

            $password = new Usuario ($_POST);
            $alertas = $password->validarPassword();                  //llama el metodo que esta en  Usuarios.php

            if(empty($alertas)){                                     //Revisar que alertas este vacio             
                $usuario->password = null;                           // elimina el password antiguo en la DB
                $usuario->password = $password->password;            //asigna el valor digitado del usuario en el campo de password de el objeto usuario               
                $usuario->hashPassword();                            //hashea el nuevo password                
                $usuario->token = null;                              // vuelve nulo el token para evitar acontesimientos                
               
                $resultado = $usuario->guardar();                    //guarda o actualiza los registros en la DB

                if($resultado){                                                    
                    header('Location: /');                           //enviar al login                     
                }
            }            
        }

        $alertas= Usuario::getAlertas();                        //obtener alertas 
        $router->render('auth/recuperar-password',[             //renderisar la vista
            'alertas' => $alertas,                              //todo pasa a la vista (html)
            'error' => $error
        ]);
    }

    public static function crear(Router $router){
        
        $usuario = new Usuario;

        //Alertas Vacias
        $alertas = [];

        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

           //Revisar que alertas este vacio
           if(empty($alertas)){
                //Verificar que el usuario no este registrado
                $resultado = $usuario-> existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    
                    //Hashear el password
                    $usuario->hashPassword();

                    //Generar un Token Unico
                    $usuario->crearToken();
                    

                    //Enviar el Email
                    $email = new Email($usuario->nombre, $usuario->email,$usuario->token);
                    $email->enviarConfirmacion();

                    //Crear usuario
                    $resultado=$usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }
                   
                }
           }
          

        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas

        ]);
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje');
        
    }

    public static function confirmar(Router $router){
        $alertas=[];
        $token = s($_GET['token']);                     //sanitisar url
        $usuario = Usuario::where('token', $token);     //filtrar por token en la url
        if(empty($usuario)){
            //mostrar mensaje de error
            Usuario::setAlerta('error','Token No Válido');   //mensaje de error, clase(scss) y mensaje
        }else{
            //modificar a usuario confirmado y borrar token.
            $usuario->confirmado="1";   //actualiza en la base de datos             
            $usuario-> token=null;      //borra el token
            $usuario-> guardar();       //metodo para guardar usuario en ActiveRecord.php
            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');
        }
        $alertas= Usuario::getAlertas(); //Obtener alertas previamente guardadas en memoria metodo de AvriveRecor.php

        //Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas'=>$alertas
        ]);
    }
}