<?php
require_once __DIR__ . '/../config/conexion.php';

class UsuarioModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = getConexion();
    }

    public function buscarUsuarios($username, $password)
    {
        // Primero obtener el usuario
        $stmt = $this->conexion->prepare("SELECT id_usuario, nombre, contrasena FROM usuarios WHERE nombre = ?");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['contrasena'])) {
            // Retornar datos del usuario
            return $usuario;
        } else {
            // Credenciales inválidas
            return false;
        }
    }
    public function registrarUsuario($nombre, $password)
    {
        try {
            // Iniciar transacción
            $this->conexion->beginTransaction();

            // Verificar si el usuario ya existe
            $stmtVerificar = $this->conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre = ?");
            $stmtVerificar->execute([$nombre]);

            if ($stmtVerificar->fetchColumn() > 0) {
                // Usuario ya existe
                $this->conexion->rollback();
                return false;
            }
            // Generar número de cuenta único
            do {
            $cuenta = '';
                for ($i = 0; $i < 12; $i++) {
                    $cuenta .= mt_rand(0, 9);
                }

            $stmtVerificarCuenta = $this->conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE cuenta = ?");
            $stmtVerificarCuenta->execute([$cuenta]);

            } while ($stmtVerificarCuenta->fetchColumn() > 0);
                

            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmtInsertar = $this->conexion->prepare("INSERT INTO usuarios (nombre, contrasena, cuenta) VALUES (?, ?, ?)");
            $resultado = $stmtInsertar->execute([$nombre, $hashedPassword, $cuenta]);

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
            error_log("Error en registrarUsuario: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerCuentas($usuarioLogueadoId)
    {
        if($usuarioLogueadoId !== null) {
            // Consulta excluyendo al usuario logueado
            $stmt = $this->conexion->prepare("SELECT id_usuario, nombre, cuenta FROM usuarios ");
            $stmt->execute();
            return $stmt->fetchAll();
        }   
        else{
            return false;
        }

    }
    public function actualizarSaldo($id_usuario, $monto)
    {
        $stmt = $this->conexion->prepare("UPDATE usuarios SET saldo_total = saldo_total + ? WHERE id_usuario = ?");
        return $stmt->execute([$monto, $id_usuario]);
    }


    public function __destruct()
    {
        $this->conexion = null;
    }
}
