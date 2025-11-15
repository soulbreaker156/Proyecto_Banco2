<?php
function getConexion() {
    $host = "localhost";
    $user = "postgres";
    $port = "5432";
    $password = "Jeff0101Valle";
    $database = "Banco2";

    try {
        $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$database", $user, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $conexion;
    } catch (PDOException $e) {
        die("Conexion fallida: " . $e->getMessage());
    }
}
?>
