<?php 
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        date_default_timezone_set('America/Bogota');
        $fecha = date('Y-m-d');
       
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

        //Consultar la base de Datos

        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservcios ";
        $consulta .= " ON citasservcios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservcios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";
        $citas = AdminCita::SQL($consulta);
         


        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}