<?php $title = 'Iniciar Sesión'; require_once '../views/layouts/header.php'; ?>

<div class="form-container">
    <h2>Iniciar Sesión</h2>
    <p>Por favor, ingrese sus credenciales.</p>
    <form action="login" method="post">
        <div class="form-group">
            <label>Usuario</label>
            <input type="text" name="usuario" required>
        </div>    
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn" value="Login">
        </div>
        <p>¿No tienes una cuenta? <a href="register">Crea una ahora</a>.</p>
    </form>
</div>

<?php require_once '../views/layouts/footer.php'; ?>