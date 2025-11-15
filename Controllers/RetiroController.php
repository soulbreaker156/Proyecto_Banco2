<?php
require_once __DIR__ . '/../Models/TransaccionModel.php';
require_once __DIR__ . '/../Models/UsuarioModel.php';

class RetiroController
{
    private $transaccionModel;
    private $usuarioModel;
    public function __construct()
    {
        $this->transaccionModel = new TransaccionModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function mostrarRetiro()
    {
         $usuarioLogueadoId = null;
        if ($usuarioLogueadoId === null) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Obtener el ID del usuario logueado de la sesión
            $usuarioLogueadoId = $_SESSION['user_id'] ?? null;
        }
        
        $usuarios = $this->usuarioModel->obtenerCuentas($usuarioLogueadoId);
        require_once __DIR__ . '/../Views/Retiro/Retiro.php';
    }
    public function retiro(){

        if (!isset($_POST['id_usuario']) || !isset($_POST['monto']) || !isset($_POST['concepto'])) {
            return false;
        }

        $id_usuario = $_POST['id_usuario'];
        $monto = $_POST['monto'];
        $concepto = $_POST['concepto'];

        if(!is_numeric($monto) || $monto <= 0) {
            return false;
        }

        if (empty($concepto)) {
            return false;
        }

        $resultado = $this->transaccionModel->procesarRetiro($monto, $concepto, $id_usuario);
        if ($resultado) {
            header('Location: /historial');
            exit;
        } else {
            echo "Error al procesar el retiro. Por favor, inténtelo de nuevo.";
        }
    }
}