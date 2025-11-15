<?php
require_once __DIR__ . '/../Models/TransaccionModel.php';
require_once __DIR__ . '/../Models/ClienteModel.php';

class DepositoController
{
    private $transaccionModel;
    private $clienteModel;

    public function __construct()
    {
        $this->transaccionModel = new TransaccionModel();
        $this->clienteModel = new ClienteModel();
    }

    public function mostrarDeposito()
    {
        $usuarioLogueadoId = null;
        if ($usuarioLogueadoId === null) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Obtener el ID del usuario logueado de la sesión
            $usuarioLogueadoId = $_SESSION['user_id'] ?? null;
        }

        $clientes = $this->clienteModel->obtenerCuentas($usuarioLogueadoId);
        require_once __DIR__ . '/../Views/Deposito/Deposito.php';
    }
    public function deposito(){

        if (!isset($_POST['id_cliente']) || !isset($_POST['monto']) || !isset($_POST['concepto'])) {
            return false;
        }

        $id_cliente = $_POST['id_cliente'];
        $monto = $_POST['monto'];
        $concepto = $_POST['concepto'];

        if(!is_numeric($monto) || $monto <= 0) {
            return false;
        }

        if (empty($concepto)) {
            return false;
        }

        $resultado = $this->transaccionModel->procesarDeposito($monto, $concepto, $id_cliente);
        if ($resultado) {
            echo "<script>alert('Depósito realizado correctamente'); window.location.href='/historial';</script>";
            exit;
        } else {
            echo "<script>alert('Error al procesar el depósito'); window.location.href='/deposito';</script>";
            exit;
        }
    }
}