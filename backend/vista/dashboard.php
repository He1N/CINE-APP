<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirigir al inicio de sesión
    header('Location: ../vista/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>CREDENCIALES CORRECTAS</h1>
    <button class="btn-cerrar-sesion" onclick="window.location.href='logout.php'">Cerrar Sesión</button>

    <?php
    // Mostrar el mensaje de bienvenida
    echo "Bienvenido, " . $_SESSION['usuario'] . "!";

    // Mostrar información personalizada según el rol
    if ($_SESSION['rol'] == 'admin') {
        echo "Eres administrador.";
    } else {
        echo "Eres un usuario estándar.";
    }
    ?>
</body>
</html>
