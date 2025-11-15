<?php
require_once __DIR__ . '/../config/conexion.php';

class HistorialModel {

    private $conexion;

    public function __construct() {
        $this->conexion = getConexion();
    }

    // Obtener historial por cliente
    public function obtenerHistorialPorCliente($id_cliente) {
        $sql = "SELECT t.id_transaccion, t.monto, t.tipo_mov, t.concepto, t.fecha_mov,
                       c.nombre, c.apellido, c.cuenta
                FROM Transacciones t
                INNER JOIN Cliente c ON c.id_cliente = t.fk_cliente
                WHERE t.fk_cliente = :id_cliente
                ORDER BY t.fecha_mov DESC, t.id_transaccion DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(['id_cliente' => $id_cliente]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener lista de clientes para el select
    public function obtenerClientes() {
        $sql = "SELECT id_cliente, nombre, apellido, cuenta FROM Cliente ORDER BY nombre ASC";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
