<?php
session_start();
$userName = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;

// Datos que deberían venir de los controladores
$heroTitle = "JOKER";
$heroDescription = "La pasión de Arthur Fleck, un hombre ignorado por la sociedad, es hacer reír a la gente. Sin embargo, una serie de trágicos sucesos harán que su visión del mundo se distorsione.";

$movies = [
    ['title' => '15 de agosto', 'image' => './img/imgc1.jpg'],
    ['title' => '15 de agosto', 'image' => './img/imgc2.jpg'],
    ['title' => '06 de septiembre', 'image' => './img/imgc3.jpg'],
    ['title' => '24 de septiembre', 'image' => './img/imgc4.jpg'],
];

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
        width: 224px;
        height: 400px;
    }
    .movie-card .card-img-top {
        border-radius: 0;
        height: 320px;
        object-fit: cover;
    }
    .movie-card .card-body {
        padding: 0;
    }
    .movie-card .card-title {
        background-color: #000000;
        color: #ffffff;
        padding: 0.6rem;
        margin: 0;
        font-size: 17px; 
        font-family: 'Instrument Sans', sans-serif;
        line-height: 1.4;
        text-align: center;
        font-weight: bold;
    }
    .movie-card .btn-reservar {
        background-color: #FF0000;
        color: #ffffff;
        border: none;
        border-radius: 0;
        padding: 0.4rem; 
        font-size: 17px; 
        width: 100%;
        font-family: 'Instrument Sans', sans-serif;
        text-transform: capitalize;
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
                        <a href="#" class="text-warning text-decoration-none me-3 estreno-link">Estrenos Recientes</a>
                        <a href="#" class="text-white text-decoration-none estreno-link">Futuros Estrenos</a>
                    </div>
                </div>
                <br>
                <div class="movie-carousel">
                    <div class="movie-cards-container">
                        <div class="row">
                            <?php foreach ($movies as $movie): ?>
                            <div class="col-12 col-sm-6 col-md-3 mb-4">
                                <div class="card movie-card text-white">
                                    <h6 class="card-title mb-0"><?php echo htmlspecialchars($movie['title']); ?></h6>
                                    <img src="<?php echo htmlspecialchars($movie['image']); ?>" class="card-img-top" alt="Movie Poster">
                                    <div class="card-body">
                                        <a href="#" class="btn btn-reservar">Reservar</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="btn-next">
                        <a href="#" class="btn btn-danger rounded-circle">
                            <i class="fas fa-chevron-right"></i>
                        </a>
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
</body>
</html>