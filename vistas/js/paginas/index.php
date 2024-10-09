<?php
include 'modulos/header.php';
?>

<header class="hero">
    <div class="hero-content">
        <h1 class="hero-title">JOKER</h1>
        <p class="hero-description">La pasión de Arthur Fleck, un hombre ignorado por la sociedad, es hacer reír a la gente. Sin embargo, una serie de trágicos sucesos harán que su visión del mundo se distorsione.</p>
        <button class="btn btn-custom">Reservar</button>
        <br><br><br>
        <div class="social-icons mt-3">
            <img width="40px" src="../img/facebook.png" alt="Facebook">
            <img width="40px" src="../img/twitter.png" alt="Twitter">
            <img width="40px" src="../img/instagram.png" alt="Instagram">
        </div>
    </div>
</header>

<main>
    <section class="movie-releases py-5">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title m-0">
                    <span class="cartelera">Cartelera</span>
                    <span class="estrenos">ESTRENOS</span>
                </h2>
                <div class="estreno-links">
                    <a href="#" class="text-warning text-decoration-none me-3 estreno-link">Estrenos Recientes</a>
                    <a href="#" class="text-white text-decoration-none  estreno-link">Futuros Estrenos</a>
                </div>
            </div>
            <br>
            <div class="movie-carousel">
                <div class="movie-cards-container">
                    <div class="row">
                        <div class="col-12  col-sm-6 col-md-3 mb-4">
                            <div class="card movie-card text-white">
                                <h6 class="card-title mb-0">15 de agosto</h6>
                                <img src="../img/imgc1.jpg" class="card-img-top" alt="Movie Poster">
                                <div class="card-body">
                                    <a href="#" class="btn btn-reservar">Reservar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-4">
                            <div class="card movie-card text-white">
                                <h6 class="card-title mb-0">15 de agosto</h6>
                                <img src="../img/imgc2.jpg" class="card-img-top" alt="Movie Poster">
                                <div class="card-body">
                                    <a href="#" class="btn btn-reservar">Reservar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-4">
                            <div class="card movie-card text-white">
                                <h6 class="card-title mb-0">06 de septiembre</h6>
                                <img src="../img/imgc3.jpg" class="card-img-top" alt="Movie Poster">
                                <div class="card-body">
                                    <a href="#" class="btn btn-reservar">Reservar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 mb-4">
                            <div class="card movie-card text-white">
                                <h6 class="card-title mb-0">24 de septiembre</h6>
                                <img src="../img/imgc4.jpg" class="card-img-top" alt="Movie Poster">
                                <div class="card-body">
                                    <a href="#" class="btn btn-reservar">Reservar</a>
                                </div>
                            </div>
                        </div>
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
                    <img src="../img/imgPromo.jpg" alt="Look Back Promotion" class="promotion-image">
                </div>
                
                <div class="promotion-text">
                    <h3>Obtén un ticket holográfico de Look Back</h3>
                    <p>Asiste al estreno de Look Back y obtén</p>
                    <p>un ticket conmemorativo.</p>
                    <br>
                    <a href="#" class="btn btn-promotion">Quiero saber más</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include 'modulos/footer.php';
?>