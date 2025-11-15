<?php
require_once __DIR__ . '/../Models/UsuarioModel.php';
class LoginController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }
    public function mostrarLogin($error = null)
    {
        // Pasar el error a la vista si existe
        $mensaje_error = $error;
        require_once __DIR__ . '/../Views/Login/Login.php';
    }
    public function mostrarRegistro($error = null)
    {
        // Pasar el error a la vista si existe
        $mensaje_error = $error;
        require_once __DIR__ . '/../Views/Registrar/Registrar.php';
    }

    public function login()
    {
        // Validar que los datos existan
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            echo "Datos incompletos.";
            return;
        }

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Validar que no estén vacíos
        if (empty($username) || empty($password)) {
            echo "Usuario y contraseña son requeridos.";
            return;
        }

        $usuario = $this->usuarioModel->buscarUsuarios($username, $password);

        if ($usuario) {
            // Iniciar sesión de forma segura
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            session_regenerate_id(true);

            // Guardar información del usuario en sesión
            $_SESSION['user_id'] = $usuario['id_usuario'];
            $_SESSION['username'] = $usuario['nombre'];
            $_SESSION['login_time'] = time();


            echo "<script>alert('Sesión iniciada correctamente'); window.location.href='/historial';</script>";
            exit;
        } else {
            echo "<script>alert('Credenciales inválidas'); window.location.href='/';</script>";
            exit;
        }
    }
    public function registrar()
    {  
        // Validar que los datos existan
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            echo "Datos incompletos.";
            return;
        }

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Validar que no estén vacíos
        if (empty($username) || empty($password)) {
            echo "Usuario y contraseña son requeridos.";
            return;
        }

        $resultado = $this->usuarioModel->registrarUsuario($username, $password);

        if ($resultado) {
            echo "<script>alert('Usuario registrado correctamente'); window.location.href='/';</script>";
            exit;
        } else {
            echo "<script>alert('Error al registrar usuario'); window.location.href='/registrar';</script>";
            exit;
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destruir todas las variables de sesión
        $_SESSION = [];

        // Destruir la sesión
        session_destroy();

        // Redirigir al login
        header('Location: /');
        exit;
    }


    public function __destruct()
    {
        $this->usuarioModel = null;
    }
}
