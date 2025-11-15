<?php

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../Models/ClienteModel.php';

class TransaccionModel
{
    private $conexion;
    private $clienteModel;

    public function __construct()
    {
        $this->conexion = getConexion();
        $this->clienteModel = new ClienteModel();
    }

    public function procesarDeposito($monto, $concepto, $id_cliente)
    {
        try {
            $this->conexion->beginTransaction();

            $stmtInsertar = $this->conexion->prepare("INSERT INTO transacciones (monto,tipo_mov, concepto, fecha_mov,fk_cliente) VALUES (?, 'deposito', ?, NOW(), ?)");
            $resultado = $stmtInsertar->execute([$monto, $concepto, $id_cliente]);

            $this->clienteModel->actualizarSaldo($id_cliente, $monto);

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

    public function procesarRetiro($monto, $concepto, $id_cliente)
    {
        try {
            $this->conexion->beginTransaction();

            $stmtInsertar = $this->conexion->prepare("INSERT INTO transacciones (monto,tipo_mov, concepto, fecha_mov,fk_cliente) VALUES (?, 'retiro', ?, NOW(), ?)");
            $resultado = $stmtInsertar->execute([$monto, $concepto, $id_cliente]);

            $this->clienteModel->actualizarSaldo($id_cliente, -$monto);

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