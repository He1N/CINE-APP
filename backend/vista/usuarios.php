<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirigir al inicio de sesión
    header('Location: ../vista/login.php');
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="css/panel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
    <?php
    include 'layout/sidebar.php';   
    include 'layout/topbar.php';
    ?>
    <h2>Usuarios</h2>
    <button id="mostrarFormularioBtn">Abrir Formulario</button>

    <div id="formularioOverlay" class="overlay">
        <div class="formulario">
            <h2>Formulario</h2>
            <form action="./index.php?accion=registrarNuevoAdmin" method="POST">
                <label for="nombre">Nombre de Usuario:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <button type="submit">Enviar</button>
                <button type="button" id="cerrarFormularioBtn">Cerrar</button>
            </form>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
