<?php

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../Models/UsuarioModel.php';

class TransaccionModel
{
    private $conexion;
    private $usuarioModel;

    public function __construct()
    {
        $this->conexion = getConexion();
        $this->usuarioModel = new UsuarioModel();
    }

    public function procesarDeposito($monto, $concepto, $id_usuario)
    {
        try {
            $this->conexion->beginTransaction();

            $stmtInsertar = $this->conexion->prepare("INSERT INTO transacciones (monto,tipo_mov, concepto, fecha_mov,fk_usuario) VALUES (?, 'deposito', ?, NOW(), ?)");
            $resultado = $stmtInsertar->execute([$monto, $concepto, $id_usuario]);

            $this->usuarioModel->actualizarSaldo($id_usuario, $monto);

            if (!$resultado) {
                // Error al insertar
                $this->conexion->rollback();
                return false;
            }

            // Confirmar transacción
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            $this->conexion->rollback();
            return false;
        }
    }
}