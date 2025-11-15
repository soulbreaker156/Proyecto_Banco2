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
            
                

            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmtInsertar = $this->conexion->prepare("INSERT INTO usuarios (nombre, contrasena) VALUES (?, ?)");
            $resultado = $stmtInsertar->execute([$nombre, $hashedPassword]);

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

    


    public function __destruct()
    {
        $this->conexion = null;
    }
}
