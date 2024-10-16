<?php

// Verificar si el usuario está logueado
if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
    $username = $_SESSION['usuario']; // Nombre de usuario extraído de la sesión
    $role = $_SESSION['rol']; // Rol del usuario extraído de la sesión
} else {
    // Si no hay sesión activa, redirigir al login
    header("Location: login.php");
    exit();
}
?>
<head>
    <link rel="stylesheet" href="./css/topbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="top-bar">
        
        <div class="right-content">
            <!-- Icono de notificaciones -->
            <i class="icon-notificaciones"></i>
            <!-- Información de usuario -->
            <div class="user-info">
                <span class="username"><?php echo htmlspecialchars($username); ?></span> <!-- Nombre dinámico -->
                <span class="role"><?php echo htmlspecialchars($role); ?></span> <!-- Rol dinámico -->
            </div>
            <button class="btn-cerrar-sesion" onclick="window.location.href='logout.php'">Cerrar Sesión</button>
        </div>

    </div>
</body>