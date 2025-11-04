<?php
require_once __DIR__ . '/../vendor/autoload.php';

$router = new AltoRouter();

// Ejemplo de ruta
$router->map('GET', '/', function() {
    echo 'Página principal';
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
