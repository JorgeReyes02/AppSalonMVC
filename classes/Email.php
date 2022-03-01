<?php 
namespace Classes;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email,$nombre,$token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
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
        $contenido .="<p><strong>Hola " .$this->nombre . "</strong>Haz creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido.= "<p>Presiona aquí: <a href='htpp://localhost:3000/confirmar-cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido.= "<p>Si tu no solicitaste esta cuenta,puedes ignorar el mensaje</p>";
        $contenido.= "</html>";
        
        $mail->Body = $contenido;

        //Enviar correo
        $mail->send();
    }
}