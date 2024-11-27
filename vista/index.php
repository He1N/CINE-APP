<?php
session_start();
$userName = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;

// Datos estáticos
$heroTitle = "JOKER";
$heroDescription = "La pasión de Arthur Fleck, un hombre ignorado por la sociedad, es hacer reír a la gente. Sin embargo, una serie de trágicos sucesos harán que su visión del mundo se distorsione.";

// Require del controlador solo para las películas
require_once '../controlador/pelicula.controlador.php';
$peliculaController = new PeliculaControlador();
$estrenosRecientes = $peliculaController->obtenerEstrenosRecientes();
$futurosEstrenos = $peliculaController->obtenerFuturosEstrenos();

$pageTitle = "Cinesmero - Página Principal";
?>

<?php require_once 'layout/header.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Instrument+Sans:wght@400;700&family=Koulen&family=Agdasima:wght@700&display=swap" rel="stylesheet">
    <style>
    body {
        background-image: url('./img/body.png');
        background-repeat: repeat;
        background-size: 300px;
        color: #ffffff;
        font-family: 'Inter', sans-serif;
        font-size: 20px;
    }
    .hero {
        background-image: url('./img/img1.jpg');
        background-size: cover;
        background-position: center;
        height: 600px;
        position: relative;
    }
    .hero-content {
        position: absolute;
        bottom: 50px;
        left: 140px;
        max-width: 400px;
    }
    .hero-title {
        font-family: 'Agdasima', sans-serif;
        font-size: 5rem;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .hero-description {
        font-size: 1.2rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    .movie-releases {
        background-color: rgba(60, 0, 0, 0.8);
    }
    .movie-card {
        background-color: #8B0000;
        border: none;
        border-radius: 0;
        overflow: hidden;
        width: 224px; /* Ancho fijo */
        height: 400px; /* Alto fijo */
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }
    .movie-card .card-img-top,
    .movie-card .card-img-placeholder {
        height: 320px;
        width: 100%;
        object-fit: cover;
    }
    .movie-card .card-body {
        padding: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .movie-card .card-title {
        background-color: #000000;
        color: #ffffff;
        padding: 0.6rem;
        margin: 0;
        font-size: 14px; 
        font-family: 'Instrument Sans', sans-serif;
        line-height: 1.2;
        text-align: center;
        font-weight: bold;
        height: 40px; /* Altura fija para el título */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .movie-card .btn-reservar {
        background-color: #FF0000;
        color: #ffffff;
        border: none;
        border-radius: 0;
        padding: 0.4rem; 
        font-size: 16px; 
        width: 100%;
        font-family: 'Instrument Sans', sans-serif;
        text-transform: capitalize;
    }
    .card-img-placeholder {
        background-color: #1a1a1a;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 0.9rem;
    }
    .section-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }
    .section-title .cartelera {
        font-family: 'Instrument Sans', sans-serif;
        background-color: rgba(255, 0, 0, 0.8);
        color: #ffffff;
        padding: 0.2rem 0.5rem;
        display: inline-block;
        width: 175px;
    }
    .section-title .estrenos {
        font-family: 'Koulen', cursive;
        color: rgba(255, 215, 0, 0.9);
        padding: 0.2rem 0.5rem;
        background-color: transparent;
        display: inline-block;
        position: absolute;
        top: 0.1em;
        right: -3.35em;
        font-size: 2.7rem;
        font-weight: normal;
    }
    .promotions {
        background-color: rgba(34, 0, 0, 0.8);
        padding: 2rem 0;
        padding-bottom: 50px;
    }
    .promotion-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0;
        position: relative;
        display: inline-block;
    }
    .promotion-title .offers {
        font-family: 'Instrument Sans', sans-serif;
        background-color: rgba(255, 0, 0, 0.8);
        color: #ffffff;
        padding: 0.2rem 0.5rem;
        display: inline-block;
        width: 180px;
    }
    .promotion-title .promotions {
        font-family: 'Koulen', cursive;
        color: rgba(255, 215, 0, 0.9);
        padding: 0.2rem 0.5rem;
        background-color: transparent;
        display: inline-block;
        position: absolute;
        top: 0.1em;
        right: -4.7em;
        font-size: 2.7rem;
        font-weight: normal;
    }
    .promotion-title-spacer {
        display: block;
        height: 2rem;
        content: "";
    }
    .promotion-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: stretch;
        line-height: normal;
        margin-top: 1rem;
    }
    .promotion-image-container {
        width: 50%;
        padding-right: 25px;
        padding-left: 23px;
    }
    .promotion-image {
        width: 510px;
        height: 525px;
    }
    .promotion-text {
        width: 50%;
        padding: 1.5rem;
        padding-left: 40px;
    }
    .promotion-text h3 {
        color: rgba(160, 149, 74, 0.9);
        font-size: 3.5rem;
        margin-bottom: 1rem;
        line-height: 1.45;
        font-weight: bold;
        font-family: 'Instrument Sans', sans-serif;
    }
    .promotion-text p {
        font-size: 1.2rem;
        margin-bottom: 8px;
        font-family: 'Instrument Sans', sans-serif;
        font-weight: bold;
        padding-left: 5px;
        line-height: normal;
    }
    .btn-promotion {
        background-color: rgba(149, 18, 23);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        font-weight: bold;
    }
    .btn-promotion:hover {
        background-color: rgb(114, 14, 16);
    }
    .btn-custom {
        background-color: #FF0000;
        color: #ffffff;
        padding: 0.5rem 2rem;
        border: none;
    }
    .card-img-placeholder {
        height: 320px;
        background-color: #1a1a1a;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 0.9rem;
    }
    .movie-carousel-container {
        position: relative;
        padding: 0 40px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .movie-carousel {
        position: relative;
        overflow: hidden;
    }
    .movie-carousel-inner {
        display: flex;
        transition: transform 0.5s ease;
        gap: 24px;
    }
    .movie-carousel-item {
        flex: 0 0 224px;
        max-width: 224px;
        padding: 0;
        margin-right: 24px;
    }
    .btn-carousel-container {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        background: transparent;
    }
    .btn-prev-container {
        left: 0;
    }
    .btn-next-container {
        right: 0;
    }
    .btn-carousel {
        background-color: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
        line-height: 1;
        aspect-ratio: 1;
    }
    .btn-carousel:hover {
        background-color: rgba(255, 0, 0, 0.9);
        transform: scale(1.1);
    }
    @media (max-width: 1200px) {
        .movie-carousel-item {
            flex: 0 0 calc(33.333% - 16px);
            max-width: calc(33.333% - 16px);
        }
    }
    @media (max-width: 992px) {
        .movie-carousel-item {
            flex: 0 0 calc(50% - 12px);
            max-width: calc(50% - 12px);
        }
    }
    @media (max-width: 768px) {
        .hero-content {
            left: 20px;
            right: 20px;
            bottom: 30px;
        }
        .hero-title {
            font-size: 3.5rem;
        }
        .promotion-content {
            flex-direction: column;
        }
        .promotion-image-container,
        .promotion-text {
            width: 100%;
            padding: 1rem;
        }
        .promotion-image {
            width: 100%;
            height: auto;
        }
        .promotion-text h3 {
            font-size: 2.5rem;
        }
        .movie-carousel-item {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .movie-carousel-container {
            padding: 0 32px;
        }
    }
    .estreno-link {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .estreno-link.active {
        color: #FFD700; /* Amarillo */
    }
    </style>
</head>
<body>
    <main>
        <header class="hero">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo htmlspecialchars($heroTitle); ?></h1>
                <p class="hero-description"><?php echo htmlspecialchars($heroDescription); ?></p>
                <button class="btn btn-custom">Reservar</button>
                <br><br><br>
                <div class="social-icons mt-3">
                    <img width="40" src="./img/facebook.png" alt="Facebook">
                    <img width="40" src="./img/twitter.png" alt="Twitter">
                    <img width="40" src="./img/instagram.png" alt="Instagram">
                </div>
            </div>
        </header>

        <section class="movie-releases py-5">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title m-0">
                        <span class="cartelera">Cartelera</span>
                        <span class="estrenos">ESTRENOS</span>
                    </h2>
                    <div class="estreno-links">
                        <a href="#" class="estreno-link active" data-type="recientes">Estrenos Recientes</a>
                        <a href="#" class="estreno-link" data-type="futuros">Futuros Estrenos</a>
                    </div>
                </div>
                <br>
                <div class="movie-carousel-container">
                    <div class="movie-carousel">
                        <div class="movie-carousel-inner" id="estrenosRecientes">
                            <?php if (!empty($estrenosRecientes)): ?>
                                <?php foreach ($estrenosRecientes as $pelicula): ?>
                                <div class="movie-carousel-item">
                                    <div class="card movie-card text-white">
                                        <h6 class="card-title">
                                            <?php echo htmlspecialchars($pelicula['fecha_estreno']); ?>
                                        </h6>
                                        <?php if (!empty($pelicula['imagen'])): ?>
                                            <a href="pelicula.php?id=<?php echo $pelicula['id']; ?>" class="movie-link">
                                                <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" 
                                                     class="card-img-top" 
                                                     alt="Póster de <?php echo htmlspecialchars($pelicula['nombre']); ?>">
                                            </a>
                                        <?php else: ?>
                                            <a href="pelicula.php?id=<?php echo $pelicula['id']; ?>" class="movie-link">
                                                <div class="card-img-placeholder">
                                                    <span>Imagen no disponible</span>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <a href="reserva.php?id=<?php echo $pelicula['id']; ?>" 
                                               class="btn btn-reservar">
                                                Reservar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12 text-center">
                                    <p>No hay estrenos recientes disponibles.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="movie-carousel-inner" id="futurosEstrenos" style="display: none;">
                            <?php if (!empty($futurosEstrenos)): ?>
                                <?php foreach ($futurosEstrenos as $pelicula): ?>
                                <div class="movie-carousel-item">
                                    <div class="card movie-card text-white">
                                        <h6 class="card-title">
                                            <?php echo htmlspecialchars($pelicula['fecha_estreno']); ?>
                                        </h6>
                                        <?php if (!empty($pelicula['imagen'])): ?>
                                            <a href="pelicula.php?id=<?php echo $pelicula['id']; ?>" class="movie-link">
                                                <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" 
                                                     class="card-img-top" 
                                                     alt="Póster de <?php echo htmlspecialchars($pelicula['nombre']); ?>">
                                            </a>
                                        <?php else: ?>
                                            <a href="pelicula.php?id=<?php echo $pelicula['id']; ?>" class="movie-link">
                                                <div class="card-img-placeholder">
                                                    <span>Imagen no disponible</span>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <a href="reserva.php?id=<?php echo $pelicula['id']; ?>" 
                                               class="btn btn-reservar">
                                                Reservar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12 text-center">
                                    <p>No hay futuros estrenos disponibles.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="btn-carousel-container btn-prev-container">
                        <button class="btn-carousel btn-prev">&lt;</button>
                    </div>
                    <div class="btn-carousel-container btn-next-container">
                        <button class="btn-carousel btn-next">&gt;</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="promotions">
            <div class="container">
                <h2 class="promotion-title">
                    <span class="offers">Ofertas y</span>
                    <span class="promotions">PROMOCIONES</span>
                </h2>
                <br class="promotion-title-spacer">
                <div class="promotion-content">
                    <div class="promotion-image-container">
                        <img src="./img/imgPromo.jpg" alt="Look Back Promotion" class="promotion-image">
                    </div>
                    <div class="promotion-text">
                        <h3>Obtén un ticket holográfico de Look Back</h3>
                        <p>Asiste al estreno de Look Back y obtén</p>
                        <p>un ticket conmemorativo.</p>
                        <br>
                        <a href="OfertasyPromociones.php" class="btn btn-promotion">Quiero saber más</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php require_once 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('.movie-carousel-inner');
        const items = carousel.querySelectorAll('.movie-carousel-item');
        const prevBtn = document.querySelector('.btn-prev');
        const nextBtn = document.querySelector('.btn-next');
        let itemsPerView = 4;
        let currentIndex = 0;

        function updateCarouselPosition() {
            const itemWidth = 224 + 24; // Ancho de la card + gap
            const offset = -(currentIndex * itemWidth);
            carousel.style.transform = `translateX(${offset}px)`;
        }

        function showSlide(index) {
            const maxIndex = items.length - itemsPerView;
            
            if (index < 0) {
                currentIndex = maxIndex;
            } else if (index > maxIndex) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }
            
            updateCarouselPosition();
            updateButtonsVisibility();
        }

        function updateButtonsVisibility() {
            const maxIndex = items.length - itemsPerView;
            prevBtn.parentElement.style.display = currentIndex <= 0 ? 'none' : 'flex';
            nextBtn.parentElement.style.display = currentIndex >= maxIndex ? 'none' : 'flex';
        }

        function adjustCarousel() {
            const viewportWidth = window.innerWidth;
            const cardWidth = 224; // Ancho fijo de la card
            const gap = 24; // Espacio entre cards

            // Calcula cuántas cards caben en el viewport
            itemsPerView = Math.floor((viewportWidth - 80) / (cardWidth + gap)); // 80px para los botones de navegación
            itemsPerView = Math.max(1, Math.min(itemsPerView, 4)); // Mínimo 1, máximo 4

            currentIndex = 0;
            updateCarouselPosition();
            updateButtonsVisibility();
        }

        prevBtn.addEventListener('click', () => showSlide(currentIndex - 1));
        nextBtn.addEventListener('click', () => showSlide(currentIndex + 1));

        window.addEventListener('resize', adjustCarousel);
        
        // Initial setup
        adjustCarousel();
        updateButtonsVisibility();

        // Add functionality for switching between recent and future releases
        const estrenoLinks = document.querySelectorAll('.estreno-link');
        const estrenosRecientes = document.getElementById('estrenosRecientes');
        const futurosEstrenos = document.getElementById('futurosEstrenos');

        estrenoLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const type = this.getAttribute('data-type');
                
                estrenoLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                if (type === 'recientes') {
                    estrenosRecientes.style.display = 'flex';
                    futurosEstrenos.style.display = 'none';
                } else {
                    estrenosRecientes.style.display = 'none';
                    futurosEstrenos.style.display = 'flex';
                }

                // Reset carousel position
                currentIndex = 0;
                updateCarouselPosition();
                updateButtonsVisibility();
            });
        });
    });
    </script>
</body>
</html>

