<?php
require_once __DIR__ . '/../Models/HistorialModel.php';
require_once __DIR__ . '/../Views/Historial/historial.php';

class HistorialController {

    private $model;

    public function __construct() {
        $this->model = new HistorialModel();
    }

    public function index() {
        // Obtener lista de clientes
        $clientes = $this->model->obtenerClientes();

        // Si el usuario seleccionó un cliente
        $historial = [];
        if (!empty($_GET['id_cliente'])) {
            $id_cliente = intval($_GET['id_cliente']);
            $historial = $this->model->obtenerHistorialPorCliente($id_cliente);
        }
    }
}
