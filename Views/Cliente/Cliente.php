<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://api.fontshare.com/v2/css?f[]=panchang@400&f[]=satoshi@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/../css/estilos.css">
    <title>Historial</title>
</head>
<body>
    <nav class="navegacion">
        <ul>
            <li><a href="/historial" class="opcion">Historial</a></li>
            <li><a href="/deposito" class="opcion">Deposito</a></li>
            <li><a href="/retiro" class="opcion">Retiro</a></li>
            <li><a href="/cliente" class="opcion">Cliente</a></li>
            <li><a href="/cerrar_sesion" class="cerrar">Cerrar sesión</a></li>
        </ul>
    </nav>
    <main class="contenedor">
        <h1>Registrar Cliente</h1>
            <form action="/cliente/registrar" method="POST" class="formulario">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            <button type="submit" class="boton">Registrar</button>
        </form>
    </main>
</body>
</html>