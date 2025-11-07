<?php

require_once __DIR__ . '/../config/conexion.php';

class TransaccionModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = getConexion();
    }

    public function procesarDeposito($monto, $concepto, $id_usuario)
    {
        try {
            $this->conexion->beginTransaction();

            $stmtInsertar = $this->conexion->prepare("INSERT INTO transacciones (monto,tipo_mov, concepto, fecha_mov,fk_usuario) VALUES (?, 'deposito', ?, NOW(), ?)");
            $resultado = $stmtInsertar->execute([$monto, $concepto, $id_usuario]);

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