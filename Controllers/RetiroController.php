<?php
require_once __DIR__ . '/../Models/TransaccionModel.php';

class RetiroController
{
    private $transaccionModel;

    public function __construct()
    {
        $this->transaccionModel = new TransaccionModel();
    }

    public function mostrarRetiro()
    {
        require_once __DIR__ . '/../Views/Retiro/Retiro.php';
    }
}