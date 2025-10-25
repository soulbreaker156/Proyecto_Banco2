<?php
require_once '../models/User.php';

class UserController {
    private function checkLoggedIn() {
        return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
    }
    
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new User();
            $user = $userModel->findByUsername($_POST['usuario']);

           
            if ($user && $_POST['password'] === $user['password']) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user['id'];
                $_SESSION["usuario"] = $user['usuario'];
                $_SESSION["saldo"] = $user['saldo'];
                header("Location: dashboard");
                exit;
            } else {
                // Manejar error de login
                header("Location: login");
                exit;
            }
        }
        require_once '../views/user/login.php';
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new User();
            if ($userModel->create($_POST['usuario'], $_POST['password'])) {
                header("Location: login");
                exit;
            }
        }
        require_once '../views/user/register.php';
    }

    public function dashboard() {
        if (!$this->checkLoggedIn()) {
            header("Location: login");
            exit;
        }
        require_once '../views/user/dashboard.php';
    }

    public function logout() {
        session_start();
        $_SESSION = [];
        session_destroy();
        header("Location: login");
        exit;
    }
}
?>