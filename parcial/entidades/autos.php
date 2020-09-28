<?php

    include_once "./Entidades/datos.php"; 

    class autos
    {
        public $patente;
        public $fechaIngreso;
        public $tipoEstacionamiento;
        public $emailUsuario;

        public function __construct($patente, $fechaIngreso, $tipoEstacionamiento, $emailUsuario)
        {
            $this->patente = $patente;
            $this->fechaIngreso = $fechaIngreso;
            $this->tipoEstacionamiento = $tipoEstacionamiento;
            $this->emailUsuario = $emailUsuario;
        }

        public function guardar($archivo)
        {
            return datos::guardar($archivo, $this);
        }

        
    }

?>