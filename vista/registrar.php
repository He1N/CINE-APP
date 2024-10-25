<?php
require_once '../controlador/usuario.controlador.php';

session_start();

$controlador = new UsuarioControlador();
$mensaje = '';
$registroExitoso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
        $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $contrasena = $_POST['contrasena'];

        $resultado = $controlador->registrar($nombre, $apellido, $dni, $correo, $contrasena);
        
        if ($resultado === true) {
            $registroExitoso = true;
        } else {
            $mensaje = $resultado;
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
    <title>Cinesmero - Registro</title>
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
            background-color: rgba(45, 27, 27, 0.95);
        }
        .cinema-pattern-overlay {
            background-image: url('./img/body.png');
            background-repeat: repeat;
            background-size: 700px;
            opacity: 0.1;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: scale(0.9); }
            10% { opacity: 1; transform: scale(1); }
            90% { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(0.9); }
        }
        .fade-in-out {
            animation: fadeInOut 2s ease-in-out;
        }
    </style>
</head>
<body class="bg-[#2D1B1B] text-[#F1EED0] font-sans h-full overflow-hidden">
    <div class="flex h-full">
        <!-- Imagen en la mitad izquierda -->
        <div class="hidden lg:block w-1/2 h-full overflow-hidden">
            <img src="./img/imgLogin.png" alt="Cinesmero Login Image" class="w-full h-full object-cover">
        </div>

        <!-- Formulario en la mitad derecha -->
        <div class="w-full lg:w-1/2 h-full overflow-y-auto login-background">
            <div class="cinema-pattern-overlay absolute inset-0"></div>
            <div class="relative z-10 flex flex-col min-h-full p-8">
                <a href="index.php" class="inline-flex items-center text-accent font-['Inter'] focus:outline-none group mb-4">
                    <div class="w-8 h-8 rounded-full border border-accent flex items-center justify-center mr-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-lg">Regresar</span>
                </a>
                <div class="flex items-center mb-8">
                    <img src="./img/logoCine.png" alt="Cinesmero Logo" class="w-16 h-16 mr-4">
                    <h1 class="text-3xl font-bold text-accent" style="font-family: 'Pacifico', cursive;">Cinesmero</h1>
                </div>

                <main class="w-full max-w-md mx-auto">
                    <h2 class="text-2xl font-bold text-center text-yellow-400 mb-2">
                        Registro
                    </h2>
                    <div class="w-full h-px bg-white mb-4"></div>

                    <?php if (!empty($mensaje)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error:</strong>
                            <span class="block sm:inline"><?php echo htmlspecialchars($mensaje); ?></span>
                        </div>
                    <?php endif; ?>

                    <form id="registroForm" class="space-y-6" action="registrar.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="nombre" 
                                    id="nombre" 
                                    class="w-full bg-transparent border border-[#F1EED0] text-[#F1EED0] rounded-lg focus:ring-[#F1EED0] focus:border-[#F1EED0] p-3 placeholder-[#F1EED0] placeholder-opacity-70" 
                                    placeholder="Nombres" 
                                    required
                                >
                            </div>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="apellido" 
                                    id="apellido" 
                                    class="w-full bg-transparent border border-[#F1EED0] text-[#F1EED0] rounded-lg focus:ring-[#F1EED0] focus:border-[#F1EED0] p-3 placeholder-[#F1EED0] placeholder-opacity-70" 
                                    placeholder="Apellidos" 
                                    required
                                >
                            </div>
                        </div>

                        <div class="relative">
                            <svg class="w-5 h-5 text-[#F1EED0] absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                            <input 
                                type="text" 
                                name="dni" 
                                id="dni" 
                                class="w-full bg-transparent border border-[#F1EED0] text-[#F1EED0] rounded-lg focus:ring-[#F1EED0] focus:border-[#F1EED0] p-3 pl-10 placeholder-[#F1EED0] placeholder-opacity-70" 
                                placeholder="DNI" 
                                required
                            >
                        </div>

                        <div class="relative">
                            <svg class="w-5 h-5 text-[#F1EED0] absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <input 
                                type="email" 
                                name="correo" 
                                id="email" 
                                class="w-full bg-transparent border border-[#F1EED0] text-[#F1EED0] rounded-lg focus:ring-[#F1EED0] focus:border-[#F1EED0] p-3 pl-10 placeholder-[#F1EED0] placeholder-opacity-70" 
                                placeholder="Correo electrónico" 
                                required
                            >
                        </div>

                        <div class="relative">
                            <svg class="w-5 h-5 text-[#F1EED0] absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <input 
                                type="password" 
                                name="contrasena" 
                                id="password" 
                                class="w-full bg-transparent border border-[#F1EED0] text-[#F1EED0] rounded-lg focus:ring-[#F1EED0] focus:border-[#F1EED0] p-3 pl-10 pr-10 placeholder-[#F1EED0] placeholder-opacity-70" 
                                placeholder="Contraseña" 
                                required
                            >
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                <svg class="h-5 w-5 text-[#F1EED0]" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-base px-5 py-3 text-center transition duration-150 ease-in-out"
                            >
                                Registrar
                            </button>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>

    <!-- Modal de registro exitoso -->
    <div id="registroExitosoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-sm mx-auto text-center fade-in-out">
            <div class="text-green-500 w-24 h-24 mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold  text-gray-900 mb-2">¡Éxito!</h2>
            <p class="text-gray-600">Usuario registrado correctamente</p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('svg').innerHTML = type === 'password' 
                ? '<path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0  0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>'
                : '<path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4  77.89-10.46L346 397.39a144.13 144.13 0 0 1-26  2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"></path>';
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const nombre = document.querySelector('input[name="nombre"]').value;
            const apellido = document.querySelector('input[name="apellido"]').value;
            const dni = document.querySelector('input[name="dni"]').value;
            const email = document.querySelector('input[name="correo"]').value;
            const password = document.querySelector('input[name="contrasena"]').value;
            let isValid = true;

            if (!nombre || !apellido) {
                alert('Por favor, introduce tu nombre y apellido.');
                isValid = false;
            }

            if (!dni) {
                alert('Por favor, introduce tu DNI.');
                isValid = false;
            }

            if (!email || !/\S+@\S+\.\S+/.test(email)) {
                alert('Por favor, introduce un correo electrónico válido.');
                isValid = false;
            }

            if (password.length < 8) {
                alert('La contraseña debe tener al menos 8 caracteres.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        <?php if ($registroExitoso): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('registroExitosoModal');
            modal.style.display = 'flex';
            setTimeout(function() {
                modal.style.display = 'none';
                window.location.href = 'login.php';
            }, 2000);
        });
        <?php endif; ?>
    </script>
</body>
</html>