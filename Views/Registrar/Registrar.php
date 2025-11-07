<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="css/loginestilos.css">
  <style>
    /* Invertir el fondo solo para esta página */
    body {
      background: linear-gradient(135deg, var(--color-secondary) 40%, var(--color-primary) 70%);
    }

    /* Opcional: Cambiar el color del botón para resaltar */
    button {
      background-color: var(--color-primary);
      color: var(--color-white);
    }

    button:hover {
      background-color: var(--color-secondary);
      color: var(--color-dark);
    }
  </style>
</head>
<body>
  <form method="POST" action="/register">
    <h1>Crear Cuenta</h1>

    <label for="username">Usuario:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Registrarse</button>

    <p style="margin-top: 15px; font-size: 0.95rem;">
      ¿Ya tienes una cuenta?
      <a href="/" style="color: var(--color-primary); text-decoration: none; font-weight: 600;">
        Inicia sesión aquí
      </a>
    </p>
  </form>
</body>
</html>
