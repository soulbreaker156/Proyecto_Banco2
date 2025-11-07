<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../Controllers/LoginController.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

$router = new AltoRouter();

// Rutas
$router->map('GET', '/', function (){
    $controller = new LoginController;
    $conexion = $controller->mostrarLogin();
});
$router->map('POST', '/login', function (){
    $controller = new LoginController;
    $controller->login();
});
$router->map('GET', '/registrar', function (){
    $controller = new LoginController;
    $conexion = $controller->mostrarRegistro();
});
$router->map('POST', '/registrar', function (){
    $controller = new LoginController;
    $controller->registrar();
});
$router->map('GET', '/historial', function (){
    $controller = new HistorialController;
    $controller->mostrarHistorial();
});

// Coincidir ruta actual
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // Si no encuentra ruta
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo 'Página no encontrada';
}
