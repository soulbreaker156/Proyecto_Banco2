<?php
// Iniciar sesión para mantener el estado del usuario
session_start();

// Cargar controladores y modelos
require_once '../controllers/UserController.php';
require_once '../controllers/TransactionController.php';

// Router simple
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'user/login';
$urlParts = explode('/', $url);

$controllerName = ucfirst($urlParts[0]) . 'Controller'; // Ej: UserController
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index'; // Ej: login

// Determinar el controlador y el método a llamar
switch ($controllerName) {
    case 'UserController':
        $controller = new UserController();
        if (method_exists($controller, $methodName)) {
            $controller->$methodName();
        } else {
            echo "Error 404: Método no encontrado.";
        }
        break;
    case 'TransactionController':
        $controller = new TransactionController();
        if (method_exists($controller, $methodName)) {
            $controller->$methodName();
        } else {
            echo "Error 404: Método no encontrado.";
        }
        break;
    default:
        echo "Error 404: Controlador no encontrado.";
        break;
}
?>