<!DOCTYPE html>
<html lang="es">
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
            <li><a href="/deposito" class="opcion">Depósito</a></li>
            <li><a href="/retiro" class="opcion">Retiro</a></li>
            <li><a href="/cerrar_sesion" class="cerrar">Cerrar sesión</a></li>
        </ul>
    </nav>

    <main class="contenedor">
        <h1>Historial de Movimientos</h1>

        <!-- SELECCIÓN DE CLIENTE -->
        <form action="/historial" method="GET" class="formulario">
            <label for="usuario">Selecciona un cliente:</label>
            <select id="usuario" name="id_cliente" required>
                <option value="" disabled selected>-- Selecciona un cliente --</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo htmlspecialchars($cliente['id_cliente']); ?>"
                        <?php echo (isset($_GET['id_cliente']) && $_GET['id_cliente'] == $cliente['id_cliente']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido'] . ' - ' . $cliente['cuenta']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="boton">Buscar</button>
        </form>

        <!-- TABLA DE HISTORIAL -->
        <?php if (!empty($historial)): ?>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Monto</th>
                        <th>Tipo</th>
                        <th>Concepto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $mov): ?>
                        <tr>
                            <td><?php echo $mov['id_transaccion']; ?></td>
                            <td><?php echo $mov['monto']; ?></td>
                            <td><?php echo ucfirst($mov['tipo_mov']); ?></td>
                            <td><?php echo htmlspecialchars($mov['concepto']); ?></td>
                            <td><?php echo $mov['fecha_mov']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php elseif (isset($_GET['id_cliente'])): ?>
            <p class="mensaje">Este cliente no tiene movimientos registrados.</p>
        <?php endif; ?>
    </main>
</body>
</html>
