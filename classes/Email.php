<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre,$email,$token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //Crear el obejeto de Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c3e8ef7686e86a';
        $mail->Password = '3dbf0141861ee9';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu Cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet= 'UTF-8';
        $contenido ="<html>";
        $contenido .="<p><strong>Hola " . $this->nombre . "</strong> Haz creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido.= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido.= "<p>Si tu no solicitaste esta cuenta,puedes ignorar el mensaje</p>";
        $contenido.= "</html>";
        
        $mail->Body = $contenido;

        //Enviar correo
        $mail->send();
    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c3e8ef7686e86a';
        $mail->Password = '3dbf0141861ee9';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu password';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet= 'UTF-8';
        $contenido ="<html>";
        $contenido .="<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restablecer tu password, sigue el siguiente enlace para hacerlo</p>";
        $contenido.= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar-password?token=". $this->token ."'>Reestablecer tu password</a></p>";
        $contenido.= "<p>Si tu no solicitaste esta cambio,puedes ignorar el mensaje</p>";
        $contenido.= "</html>";
        
        $mail->Body = $contenido;

        //Enviar correo
        $mail->send();
    }
}