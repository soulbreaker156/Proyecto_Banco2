<?php 
$title = 'Dashboard'; 
require_once '../views/layouts/header.php'; 
?>

<div class="header">
    <h1>Bienvenido, <b><?php echo htmlspecialchars($_SESSION["usuario"]); ?></b></h1>
    <h3>Tu saldo actual es: $<?php echo number_format($_SESSION["saldo"], 2); ?></h3>
</div>

<div class="dashboard-links">
    <p>Selecciona una operación:</p>
  
    <a href="../transaction/deposit" class="btn">Depositar Dinero</a>
    <a href="../transaction/withdraw" class="btn">Retirar Dinero</a>
    <a href="../transaction/history" class="btn">Ver Historial</a>
    <a href="logout" class="btn btn-danger">Cerrar Sesión</a>
</div>

<?php require_once '../views/layouts/footer.php'; ?>