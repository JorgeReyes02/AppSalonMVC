<?php 
namespace Model;

class CitasServicio extends ActiveRecord{
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id','citaId','servicioId'];

    public $id;
    public $icitaIdd;
    public $servicioId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
    }
}