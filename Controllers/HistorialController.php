<?php
require_once __DIR__ . '/../Models/TransaccionModel.php';
require_once __DIR__ . '/../Models/ClienteModel.php';
class HistorialController
{
    private $transaccionModel;
    private $clienteModel;
    public function __construct()
    {
        $this->transaccionModel = new TransaccionModel();
        $this->clienteModel = new ClienteModel();
    }
    public function mostrarHistorial()
    {
        $clientes = $this->clienteModel->obtenerClientes();

        // Obtener historial solo si se seleccionó un cliente
        $historial = [];
        if (isset($_GET['id_cliente']) && $_GET['id_cliente'] !== '') {
            $historial = $this->transaccionModel->obtenerTransaccionesPorCliente($_GET['id_cliente']);
        }

        require __DIR__ . '/../Views/Historial/Historial.php';
    }
}
