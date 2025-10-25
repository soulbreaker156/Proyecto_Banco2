<?php
// Iniciar sesión para mantener el estado del usuario
session_start();

// Cargar controladores usando el nombre de carpeta correcto (con C mayúscula)
require_once __DIR__ . '/../Controllers/UserController.php';
require_once __DIR__ . '/../Controllers/TransactionController.php';

// El resto del router sigue igual
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'user/login';
$urlParts = explode('/', $url);

$controllerName = ucfirst($urlParts[0]) . 'Controller';
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';

switch ($controllerName) {
    case 'UserController':
        // Aquí también, el nombre de la clase no cambia
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