<?php
namespace Controllers;

use Model\Servicio;
use MVC\Router;

 class APIController{

    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){
        $respuesta = [
            'mensaje' => 'Todo OK'
        ];

        echo json_encode($respuesta);
    }
}