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
        // Hashear la contraseña antes de guardarla
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre, contrasena) VALUES (?, ?)");
        return $stmt->execute([$nombre, $hashedPassword]);
    }

    public function __destruct()
    {
        $this->conexion = null;
    }
}
