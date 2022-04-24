<?php
namespace Controllers;

use Model\Cita;
use Model\CitasServicio;
use Model\Servicio;


 class APIController{

    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){
        //Almacena la cita y devuelve el Id
         $cita = new Cita($_POST);
         $resultado =$cita->guardar();
         $id = $resultado['id'];

        //Almacena la Cita y el servicio con el Id
        $idServicios = explode(",", $_POST['servicios']);
        foreach($idServicios as $idServicio){
            $args = [
                'citaId' =>$id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitasServicio($args);
            $citaServicio->guardar();
        }
        $respuesta = [
            'resultado' => $resultado
        ];

        echo json_encode($respuesta);
    }
}