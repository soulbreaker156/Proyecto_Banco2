<?php
require_once __DIR__ . '/../Models/TransaccionModel.php';

class DepositoController
{
    private $transaccionModel;

    public function __construct()
    {
        $this->transaccionModel = new TransaccionModel();
    }

    public function mostrarDeposito()
    {
        require_once __DIR__ . '/../Views/Deposito/Deposito.php';
    }
}