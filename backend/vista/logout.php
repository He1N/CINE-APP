<?php
session_start(); // Iniciar la sesión
session_destroy(); // Destruir todas las variables de sesión
header('Location: ../vista/login.php'); // Redirigir al inicio de sesión
exit;
?>
