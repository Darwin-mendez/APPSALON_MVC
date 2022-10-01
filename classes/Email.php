<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){

        $this->email= $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();                //protocolo de envio de email
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '8ba67030991b8a';
        $mail->Password = 'df7b0da4a1c5cb';


        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //set HTML
        $mail->isHTML(TRUE);       
        $mail->CharSet='UTF-8';     //definir el uso de html

        $contenido = '<hmtl>';
        $contenido .= "<p><strong>Hola " . $this->email . "</strong> Has creado tu cuenta en
        AppSalon, solo debes confirmarla precionando en el siguiente enlace para hacerlo.</p>";        
        $contenido .="<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" 
        .$this->token."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si no solocitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= '</hmtl>';

        $mail->Body= $contenido;

        //enviar el email
        $mail->send();
    }

    public function enviarInstrucciones(){          //ya vienen instanciados al inicio de la clase, revisar arriba
        
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();                         //protocolo de envio de email de Mailtrap
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '8ba67030991b8a';                 //datos de mailertrap
        $mail->Password = 'df7b0da4a1c5cb';


        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Reestablece tu password';                              //Encabezado del email

        //set HTML
        $mail->isHTML(TRUE);       
        $mail->CharSet='UTF-8';                     //definir el uso de html

        $contenido = '<hmtl>';                      //contenido que se enviara en el mensaje
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer 
        tu password en AppSalon, sigue el siguiente enlace para hacerlo.</p>";        
        $contenido .="<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=" 
        .$this->token."'>Restablecer Password</a></p>";
        $contenido .= "<p>Si no solocitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= '</hmtl>';

        $mail->Body= $contenido;                //asociar el contenido a el cuerpo del mensaje

        //enviar el email
        $mail->send();
    }

}