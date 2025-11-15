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
            <li><a href="/cerrar_sesion" class="cerrar">Cerrar sesión</a></li>
        </ul>
    </nav>
    <main class="contenedor">
        <h1>Realizar Retiro</h1>
        <form action="/procesar_retiro" method="POST" class="formulario">
            <label for="usuario">Selecciona un usuario:</label>
            <select id="usuario" name="id_usuario" required>
                <option value="" disabled selected>-- Selecciona un usuario --</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                        <?php echo htmlspecialchars($usuario['nombre'] . ' - ' . $usuario['cuenta']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="monto">Monto a retirar:</label>
            <input type="number" id="monto" name="monto" step="0.01" min="0.01" required>
            <label for="concepto">Concepto:</label>
            <textarea id="concepto" name="concepto" required></textarea>
            <button type="submit" class="boton">Retirar</button>
        </form>
    </main>
</body>
</html>