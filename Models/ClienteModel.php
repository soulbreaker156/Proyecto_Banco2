<?php

require_once __DIR__ . '/../config/conexion.php';
class ClienteModel {
    private $conexion;

    public function __construct() {
        $this->conexion = getConexion();
    }

    public function obtenerClientes() {
        $stmt = $this->conexion->prepare("SELECT id_cliente, nombre, apellido, cuenta FROM clientes");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function agregarCliente($nombre, $apellido, $fecha_nacimiento,) {
        // Iniciar transacción
        $this->conexion->beginTransaction();
         
            // Generar número de cuenta único
            do {
            $cuenta = '';
                for ($i = 0; $i < 12; $i++) {
                    $cuenta .= mt_rand(0, 9);
                }

            $stmtVerificarCuenta = $this->conexion->prepare("SELECT COUNT(*) FROM cliente WHERE cuenta = ?");
            $stmtVerificarCuenta->execute([$cuenta]);

            } while ($stmtVerificarCuenta->fetchColumn() > 0);
                
        $stmt = $this->conexion->prepare("INSERT INTO clientes (nombre, apellido, fecha_nacimiento, cuenta) VALUES (?, ?, ?, ?)");
        $resultado = $stmt->execute([$nombre, $apellido, $fecha_nacimiento, $cuenta]);

        if (!$resultado) {
            // Error al insertar
            $this->conexion->rollback();
            return false;
        }

        // Confirmar transacción
        $this->conexion->commit();
        return true;
    }

    public function obtenerCuentas($usuarioLogueadoId)
    {
        if($usuarioLogueadoId !== null) {
            // Consulta excluyendo al usuario logueado
            $stmt = $this->conexion->prepare("SELECT id_cliente, nombre, apellido, cuenta FROM clientes ");
            $stmt->execute();
            return $stmt->fetchAll();
        }   
        else{
            return false;
        }

    }
    public function actualizarSaldo($id_cliente, $monto)
    {
        $stmt = $this->conexion->prepare("UPDATE clientes SET saldo_total = saldo_total + ? WHERE id_cliente = ?");
        return $stmt->execute([$monto, $id_cliente]);
    }

     public function __destruct()
    {
        $this->conexion = null;
    }
}