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
        <h1>Realizar Retiro</h1>
        <form id="form-retiro" action="/procesar_retiro" method="POST" class="formulario">
            <label for="usuario">Selecciona un cliente:</label>
            <select id="usuario" name="id_cliente" required>
                <option value="" disabled selected>-- Selecciona un cliente --</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo htmlspecialchars($cliente['id_cliente']); ?>"
                        data-saldo="<?php echo htmlspecialchars($cliente['saldo_total']); ?>">
                        <?php echo htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido'] . ' - ' . $cliente['cuenta']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="monto">Monto a retirar:</label>
            <input type="number" id="monto" name="monto" step="0.01" min="0.01" required>
            <label for="concepto">Concepto:</label>
            <textarea name="concepto" id="concepto" required></textarea>
            <button type="submit" class="boton">Retirar</button>
        </form>
    </main>
    <script>
        document.getElementById('form-retiro').addEventListener('submit', function(e) {
            var select = document.getElementById('usuario');
            var selectedOption = select.options[select.selectedIndex];
            var saldo = parseFloat(selectedOption.getAttribute('data-saldo'));
            var monto = parseFloat(document.getElementById('monto').value);

            if (monto > saldo) {
                alert('No tiene saldo suficiente para realizar el retiro.');
                e.preventDefault();
            }
        });
    </script>
</body>

</html>