<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../Controllers/LoginController.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

// Función para verificar si el usuario tiene sesión activa
function verificarSesion()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verificar si existe la sesión del usuario
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        return false;
    }

    // verificar si la sesión no ha expirado
    if (isset($_SESSION['login_time'])) {
        $tiempoExpiracion = 2 * 60 * 60; // 2 horas en segundos
        if ((time() - $_SESSION['login_time']) > $tiempoExpiracion) {
            // Sesión expirada
            session_destroy();
            return false;
        }
    }

    return true;
}

// Función para mostrar acceso restringido
function mostrarAccesoRestringido()
{
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Acceso Restringido</title>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                background-color: #f4f4f4; 
                text-align: center; 
                padding: 50px; 
            }
            .contenedor { 
                background-color: #fff; 
                padding: 40px; 
                border-radius: 10px; 
                box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
                max-width: 500px; 
                margin: 0 auto; 
            }
            h1 { color: #d32f2f; }
            a { 
                display: inline-block; 
                background-color: #004080; 
                color: white; 
                padding: 10px 20px; 
                text-decoration: none; 
                border-radius: 5px; 
                margin-top: 20px; 
            }
            a:hover { background-color: #003366; }
        </style>
    </head>
    <body>
        <div class='contenedor'>
            <h1>🔒 Acceso Restringido</h1>
            <p>No tienes autorización para acceder a esta página.</p>
            <p>Por favor, inicia sesión para continuar.</p>
            <a href='/'>Ir al Login</a>
        </div>
    </body>
    </html>";
    exit;
}

$router = new AltoRouter();

// Rutas
$router->map('GET', '/', function () {
    $controller = new LoginController;
    $controller->mostrarLogin();
});
$router->map('POST', '/login', function () {
    $controller = new LoginController;
    $controller->login();
});
$router->map('GET', '/registrar', function () {
    $controller = new LoginController;
    $controller->mostrarRegistro();
});
$router->map('POST', '/registrar', function () {
    $controller = new LoginController;
    $controller->registrar();
});
// RUTAS PROTEGIDAS (requieren sesión)
$router->map('GET', '/historial', function () {
    if (!verificarSesion()) {
        mostrarAccesoRestringido();
    }
    $controller = new HistorialController;
    $controller->mostrarHistorial();
});

$router->map('GET', '/cerrar_sesion', function () {
    if (!verificarSesion()) {
        mostrarAccesoRestringido();
    }
    $controller = new LoginController;
    $controller->logout();
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
