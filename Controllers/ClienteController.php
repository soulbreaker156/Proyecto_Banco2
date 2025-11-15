<?php
require_once __DIR__ . '/../Models/ClienteModel.php';
class ClienteController
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    public function mostrarFormularioCliente()
    {
        // Cargar la vista y pasar los datos de los clientes
        require_once __DIR__ . '/../Views/Cliente/Cliente.php';
    }
    public function registrarCliente()
    {
        if (!isset($_POST['nombre']) || !isset($_POST['apellido']) || !isset($_POST['fecha_nacimiento'])) {
            return false;
        }

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];

        $resultado = $this->clienteModel->agregarCliente($nombre, $apellido, $fecha_nacimiento);
        if ($resultado) {
            echo "<script>alert('Cliente registrado correctamente'); window.location.href='/historial';</script>";
            exit;
        } else {
            echo "<script>alert('Error al registrar el cliente'); window.location.href='/cliente';</script>";
            exit;
        }
    }
}
