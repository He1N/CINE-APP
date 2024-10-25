<?php
require_once '../controlador/usuario.controlador.php';

session_start();

$controlador = new UsuarioControlador();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $contrasena = $_POST['contrasena'];

        if ($controlador->login($correo, $contrasena)) {
            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Correo electrónico o contraseña incorrectos.";
        }
    } else {
        $mensaje = "Error de validación del formulario.";
    }
}

$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinesmero - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#D32F2F',
                        secondary: '#4A0E0E',
                        accent: '#F1EED0',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Istok+Web:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Istok Web', sans-serif;
        }
        .login-background {
            background-color: rgba(52, 22, 22, 0.95);
        }
        .cinema-pattern-overlay {
            background-image: url('./img/body.png');
            background-repeat: repeat;
            background-size: 700px;
            opacity: 0.1;
        }
        :root {
          --image-position: 30%;
        }
        .login-image {
          object-position: var(--image-position) center;
        }
    </style>
</head>
<body class="bg-[#3D0000] text-white font-sans h-full overflow-hidden">
    <div class="flex h-full">
        <!-- Left half - Image -->
        <div class="hidden lg:block w-1/2 h-full overflow-hidden">
            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/imgLogin-Mbe2ZuOqB70kFX4pnMazBKd8avYGCY.png" alt="Personas disfrutando en el cine" class="w-full h-full object-cover login-image">
        </div>

        <!-- Right half - Login form -->
        <div class="w-full lg:w-1/2 flex flex-col h-full login-background relative">
            <div class="cinema-pattern-overlay absolute inset-0"></div>
            <div class="flex flex-col justify-between h-full p-4 sm:p-6 lg:p-8 relative z-10 overflow-y-auto">
                <!-- Header with return button -->
                <header class="mb-2">
                    <a href="index.php" class="inline-flex items-center text-accent font-['Inter'] focus:outline-none group">
                        <div class="w-8 h-8 rounded-full border border-accent flex items-center justify-center mr-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-lg">Regresar</span>
                    </a>
                </header>

                <!-- Main content -->
                <main class="flex-grow flex flex-col items-center justify-center space-y-4">
                    <!-- Logo and title -->
                    <div class="flex flex-col sm:flex-row items-center mb-2">
                        <img src="./img/logoCine.png" alt="Cinesmero Logo" class="w-16 h-16 lg:w-20 lg:h-20 mb-2 sm:mb-0 sm:mr-4">
                        <h1 class="text-3xl lg:text-4xl font-bold text-accent text-center sm:text-left" style="font-family: 'Pacifico', cursive;">Cinesmero</h1>
                    </div>

                    <!-- Login form -->
                    <div class="w-full max-w-md">
                        <h2 class="text-2xl lg:text-3xl font-bold text-center text-yellow-400 mb-2">
                            Iniciar Sesión
                        </h2>
                        <div class="w-full h-px bg-white mb-4"></div>

                        <div class="mt-2 p-4 rounded-lg shadow-lg">
                            <?php if (!empty($mensaje)): ?>
                                <p class="text-red-500 text-center mb-4 text-base"><?php echo htmlspecialchars($mensaje); ?></p>
                            <?php endif; ?>

                            <form class="space-y-4" action="login.php" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                                
                                <!-- Email input -->
                                <div class="relative">
                                    <svg class="w-6 h-6 text-accent absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <input 
                                        type="email" 
                                        name="correo" 
                                        id="email" 
                                        class="bg-transparent border border-accent text-accent text-base rounded-lg focus:ring-accent focus:border-accent block w-full p-2.5 pl-12 placeholder-accent placeholder-opacity-70" 
                                        placeholder="Ingresa tu correo" 
                                        required
                                    >
                                </div>

                                <!-- Password input -->
                                <div class="relative">
                                    <svg class="w-6 h-6 text-accent absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <input 
                                        type="password" 
                                        name="contrasena" 
                                        id="password" 
                                        placeholder="Ingresa tu contraseña" 
                                        class="bg-transparent border border-accent text-accent text-base rounded-lg focus:ring-accent focus:border-accent block w-full p-2.5 pl-12 placeholder-accent placeholder-opacity-70" 
                                        required
                                    >
                                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-base leading-5">
                                        <svg class="h-6 w-6 text-accent" fill="none" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                                            <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Forgot password link -->
                                <div class="flex items-center justify-end">
                                    <a href="#" class="text-base font-medium text-red-500 hover:text-red-600 hover:underline font-['Inter']">¿Olvidaste tu contraseña?</a>
                                </div>

                                <!-- Submit button -->
                                <button
                                type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-base px-5 py-3 text-center transition duration-150 ease-in-out"
                            >
                                Ingresar
                            </button>
                            </form>

                            <!-- Register link -->
                            <p class="mt-4 text-base font-light text-center text-accent font-['Inter']">
                                ¿No tienes una cuenta? <a href="./registrar.php" class="font-medium text-red-500 hover:underline font-['Inter']">Regístrate</a>
                            </p>
                        </div>
                    </div>
                </main>

                <!-- Footer space -->
                <footer class="h-2"></footer>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('svg').innerHTML = type === 'password' 
                ? '<path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>'
                : '<path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54    10l-73.61-56.89A142.31  142.31 0 0 1 320  112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"></path>';
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="correo"]').value;
            const password = document.querySelector('input[name="contrasena"]').value;
            let isValid = true;

            if (!email || !/\S+@\S+\.\S+/.test(email)) {
                alert('Por favor, introduce un correo electrónico válido.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>