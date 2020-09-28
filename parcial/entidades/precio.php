<?php

    include_once "./Entidades/datos.php"; 

    class precio
    {
        public $hora;
        public $estadia;
        public $mensual;

        public function __construct($hora, $estadia, $mensual)
        {
            $this->hora = $hora;
            $this->estadia = $estadia;
            $this->mensual = $mensual;
        }

        public function guardar($archivo)
        {
            return datos::guardar($archivo, $this);
        }

        
    }

?>