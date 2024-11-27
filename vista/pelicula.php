<?php
session_start();
$userName = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;

require_once '../controlador/pelicula.controlador.php';
$peliculaController = new PeliculaControlador();

// Obtener el ID de la película de la URL
$id_pelicula = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener los detalles de la película
$pelicula = $peliculaController->obtenerPeliculaPorId($id_pelicula);

// Si no se encuentra la película, redirigir a la página principal
if (!$pelicula) {
    header("Location: index.php");
    exit();
}

$pageTitle = "Cinesmero - " . $pelicula['nombre'];

// Función para obtener el ID del video de YouTube y la URL de inserción
function getYoutubeInfo($url) {
    $parsedUrl = parse_url($url);
    $videoId = '';
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);
        if (isset($queryParams['v'])) {
            $videoId = $queryParams['v'];
        }
    } elseif (isset($parsedUrl['path'])) {
        $path = explode('/', trim($parsedUrl['path'], '/'));
        $videoId = end($path);
    }
    return [
        'embedUrl' => "https://www.youtube.com/embed/" . $videoId,
        'thumbnailUrl' => "https://img.youtube.com/vi/" . $videoId . "/maxresdefault.jpg"
    ];
}

// Obtener información del video
$youtubeInfo = !empty($pelicula['trailer_url']) ? getYoutubeInfo($pelicula['trailer_url']) : null;

// Función para formatear la duración
function formatDuration($minutes) {
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return $hours . "h " . $mins . "m";
}
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Instrument+Sans:wght@400;700&family=Koulen&family=Agdasima:wght@700&family=Istok+Web:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: rgba(37, 18, 18);
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
        }
        .trailer-section {
            background-color: #000;
            padding: 2rem 0;
        }
        .movie-details {
            background-color: rgba(37, 18, 18);
            padding: 2rem 0;
        }
        .movie-title {
            font-family: 'Agdasima', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #ffffff;
        }
        .movie-info {
            font-family: 'Istok Web', sans-serif;
            font-weight: 400;
            font-size: 1rem;
        }
        .movie-description {
            font-family: 'Istok Web', sans-serif;
            font-weight: 400;
            font-size: 1rem;
            line-height: 1.6;
        }
        .btn-custom {
            background-color: #FF0000;
            color: #ffffff;
            padding: 0.5rem 2rem;
            border: none;
            font-family: 'Instrument Sans', sans-serif;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .btn-custom:hover {
            background-color: #CC0000;
            color: #ffffff;
        }
        .trailer-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }
        .trailer-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        #playButtonOverlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            cursor: pointer;
        }
        #playButton {
            font-size: 5rem;
            color: #ffffff;
        }
        .cast-name {
            font-family: 'Istok Web', sans-serif;
            font-weight: 700;
            font-size: 1rem;
        }
        .text-yellow-400 {
            color: #facc15;
        }
        .bg-gray-600 {
            background-color: #4b5563;
        }
        .bg-opacity-50 {
            --tw-bg-opacity: 0.5;
        }
        .details-section {
            border-top: 1px solid #ffffff;
            padding-top: 1rem;
            margin-top: 1rem;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .detail-label {
            font-weight: 600;
            font-size: 1rem;
        }
        .detail-value {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <main>
        <?php if ($youtubeInfo): ?>
        <section class="trailer-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div id="videoContainer" class="trailer-container" style="background-image: url('<?php echo htmlspecialchars($youtubeInfo['thumbnailUrl']); ?>');">
                            <iframe id="youtubePlayer" width="560" height="315" 
                                    src="<?php echo htmlspecialchars($youtubeInfo['embedUrl']); ?>?autoplay=0&enablejsapi=1" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen 
                                    style="display: none;">
                            </iframe>
                            <div id="playButtonOverlay">
                                <i id="playButton" class="fas fa-play-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <section class="movie-details">
            <div class="container" style="max-width: 1000px;">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?php echo htmlspecialchars($pelicula['imagen']); ?>" alt="<?php echo htmlspecialchars($pelicula['nombre']); ?>" class="img-fluid mb-3">
                        <div class="text-center mb-4">
                            <a href="reserva.php?id=<?php echo $pelicula['id']; ?>" class="btn btn-custom w-100">Reservar</a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h1 class="movie-title"><?php echo htmlspecialchars($pelicula['nombre']); ?></h1>
                        <div class="movie-info mb-3 d-flex flex-wrap align-items-center gap-3">
                            <?php if (!empty($pelicula['puntuación'])): ?>
                            <span class="bg-gray-600 bg-opacity-50 px-2 py-1 rounded">IMDb <?php echo htmlspecialchars($pelicula['puntuación']); ?></span>
                            <?php endif; ?>
                            <span><?php echo htmlspecialchars($pelicula['clasificacion']); ?></span>
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span><?php echo formatDuration($pelicula['duracion']); ?></span>
                            </div>
                            <span><?php echo str_replace(',', ' / ', htmlspecialchars($pelicula['genero'])); ?></span>
                        </div>

                        <div class="details-section">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h2 class="section-title mb-4 text-yellow-400">Detalles</h2>
                                    <div>
                                        <p><span class="detail-label">Director:</span> <span class="detail-value"><?php echo htmlspecialchars($pelicula['director']); ?></span></p>
                                        <?php if (!empty($pelicula['lenguaje'])): ?>
                                        <p><span class="detail-label">Lenguaje:</span> <span class="detail-value"><?php echo str_replace(',', ' / ', htmlspecialchars($pelicula['lenguaje'])); ?></span></p>
                                        <?php endif; ?>
                                        <p><span class="detail-label">Fecha de lanzamiento:</span> <span class="detail-value"><?php echo htmlspecialchars($pelicula['fecha_estreno']); ?></span></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h2 class="section-title mb-4 text-yellow-400">Reparto</h2>
                                    <div>
                                        <?php if (!empty($pelicula['actores'])): ?>
                                            <?php foreach ($pelicula['actores'] as $index => $actor): ?>
                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                <?php if (!empty($pelicula['img_actores'][$index])): ?>
                                                    <img 
                                                        src="<?php echo htmlspecialchars($pelicula['img_actores'][$index]); ?>" 
                                                        alt="<?php echo htmlspecialchars($actor); ?>" 
                                                        class="rounded-circle" width="48" height="48"
                                                    />
                                                <?php else: ?>
                                                    <img 
                                                        src="/placeholder.svg?height=50&width=50&text=<?php echo substr(htmlspecialchars($actor), 0, 4); ?>" 
                                                        alt="<?php echo htmlspecialchars($actor); ?>" 
                                                        class="rounded-circle" width="48" height="48"
                                                    />
                                                <?php endif; ?>
                                                <span class="cast-name"><?php echo htmlspecialchars($actor); ?></span>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>Información del reparto no disponible</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-top border-white">
                                <h2 class="section-title mb-2 text-yellow-400">Sinópsis</h2>
                                <p class="movie-description">
                                    <?php echo nl2br(htmlspecialchars($pelicula['descripcion'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php require_once 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const playButton = document.getElementById('playButton');
        const videoContainer = document.getElementById('videoContainer');
        const playButtonOverlay = document.getElementById('playButtonOverlay');
        const youtubePlayer = document.getElementById('youtubePlayer');

        if (playButton && youtubePlayer) {
            playButton.addEventListener('click', () => {
                let src = youtubePlayer.src;
                if (src.indexOf('autoplay=0') !== -1) {
                    src = src.replace('autoplay=0', 'autoplay=1');
                } else {
                    src += '&autoplay=1';
                }
                youtubePlayer.src = src;
                youtubePlayer.style.display = 'block';
                playButtonOverlay.style.display = 'none';
            });
        }
    </script>

</body>
</html>