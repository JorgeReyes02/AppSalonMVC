<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router) {
        
        $router->render('auth/login', [
            
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
      
        
        $router->render('auth/confirmar-cuenta', [
            
        ]);
    }
}