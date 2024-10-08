<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="../controlador/usuario.controlador.php" method="POST">
        <label for="nombreUsuario">Usuario:</label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" required><br>

        <label for="contrasenaUsuario">Contraseña:</label>
        <input type="password" id="contrasenaUsuario" name="contrasenaUsuario" required><br>

        <button type="submit" name="iniciarSesion">Iniciar Sesión</button>

        <?php if (isset($_GET['error'])): ?>
            <p style="color:red;"><?php echo $_GET['error']; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
