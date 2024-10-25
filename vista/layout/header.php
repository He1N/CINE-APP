<?php
$pageTitle = "Cine - Página Principal";
$logoText = "Cinesmero";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Agdasima:wght@700&family=Instrument+Sans:wght@400;700&family=Koulen&family=Konkhmer+Sleokchher&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/estilos.css">
    <style>
        .user-icon-container {
            display: flex;
            align-items: center;
            margin-left: auto;
            height: 40px;
            padding-left: 10px;
            transform: translateX(-120px);
            position: relative;
        }

        .user-initials {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #007bff;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid white;
            z-index: 1001;
            font-family: 'Instrument Sans', sans-serif;
        }

        .user-icon {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 50%;
        }

        .flyout--content {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: -10px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            width: 130px; /* Reducido de 140px a 130px */
            padding: 3px 0;
        }

        .header--right-menu-items-container {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .header--right-menu-items-container-item {
            padding: 4px 12px; /* Reducido el padding horizontal de 15px a 12px */
        }

        .header--right-menu-items-container-item a {
            color: #333;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
        }

        .header--right-menu-items-container-item a:hover {
            color: #ff0000;
        }

        .flyout--content-arrow-wrapper {
            position: absolute;
            top: -10px;
            right: 10px;
        }

        .flyout--content-arrow {
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid white;
        }

        .navbar-content {
            transform: translateX(90px);
        }

        @media (max-width: 991px) {
            .user-icon-container {
                margin-left: 0;
                margin-top: 10px;
            }
            .navbar-content {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="./index.php" class="navbar-brand">
                <img src="./img/logoCine.png" alt="<?php echo $logoText; ?> Logo" class="navbar-logo">
                <span class="navbar-logo-text"><?php echo $logoText; ?></span>
            </a>
            <div class="navbar-content">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <br><br>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Estrenos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Cines</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Promociones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Socio</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="user-icon-container">
                <?php if (isset($_SESSION['usuario_nombre'])): ?>
                    <?php
                    $nombre_completo = $_SESSION['usuario_nombre'];
                    $palabras = explode(' ', $nombre_completo);
                    $iniciales = '';
                    if (count($palabras) >= 2) {
                        $iniciales = strtoupper(substr($palabras[0], 0, 1) . substr($palabras[count($palabras) - 1], 0, 1));
                    } else {
                        $iniciales = strtoupper(substr($nombre_completo, 0, 2));
                    }
                    ?>
                    <div class="user-initials" id="userDropdown">
                        <?php echo $iniciales; ?>
                    </div>
                    <div class="flyout--content">
                        <ul class="header--right-menu-items-container">
                            <li class="header--right-menu-items-container-item">
                                <a href="./logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                        <div class="flyout--content-arrow-wrapper">
                            <div class="flyout--content-arrow"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="./login.php" class="user-account">
                        <img src="./img/usericon.png" alt="User Account" class="user-icon">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userDropdown = document.getElementById('userDropdown');
            const flyoutContent = document.querySelector('.flyout--content');

            if (userDropdown && flyoutContent) {
                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                    flyoutContent.style.display = flyoutContent.style.display === 'block' ? 'none' : 'block';
                });

                document.addEventListener('click', function(e) {
                    if (!flyoutContent.contains(e.target) && e.target !== userDropdown) {
                        flyoutContent.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>