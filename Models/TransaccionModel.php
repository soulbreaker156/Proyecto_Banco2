<?php

require_once __DIR__ . '/../config/conexion.php';

class TransaccionModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = getConexion();
    }
}