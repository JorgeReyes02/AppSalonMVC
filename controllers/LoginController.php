<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router) {
        $alertas = [];
        $auth = new Usuario();

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Comprobar que exsite el usuario
                
                $usuario =  Usuario::where('email',$auth->email);
                if($usuario){
                    //Verificar la contraseña
                    $usuario->comprobarPasswordAndVerificado($auth->password);
                }else{
                    Usuario::setAlerta('error','Usuario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas'=>$alertas,
            'auth'=>$auth
        ]);
    }

    public static function logout() {
       
    }

    public static function olvide(Router $router) {
        $router->render('auth/olvide', [
            
        ]);
    }

    public static function recuperar(Router $router) {
       
        $router->render('auth/recuperar-password', [
           
        ]);
    }

    public static function crear(Router $router) {
        $usuario = new Usuario;
        
        //Alertas vacias

        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas=$usuario->validarNuevaCuenta();
            
            //Revisar que alertas este vacío
            if(empty($alertas)){
                //Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //No esta registrado
                    //Hashear el password
                    $usuario->hashPassword();
                    
                    //Generar un Token único
                    $usuario->crearToken();
                    
                    //Enviar Email
                    $email = new Email($usuario->nombre,$usuario->email,$usuario->token);

                    $email->enviarConfirmacion();
                    
                    //Crear el usuario
                    $resultado = $usuario->guardar();
                     
                   
                    if($resultado){
                        header('Location:/mensaje');
                    }
                }
            }
        }
        
        $router->render('auth/crear-cuenta', [
            'usuario'=> $usuario,
            'alertas'=> $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        
        
        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token no válido');
        }
        else{
           //cambiar valor de columna confirmado
           $usuario->confirmado = '1';
           //eliminar token
           $usuario->token = '';
           //Guardar y Actualizar 
           $usuario->guardar();
           //mostrar mensaje de exito
           Usuario::setAlerta('exito', 'Cuenta verificada exitosamente...');
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
    
    


}