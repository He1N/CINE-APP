<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-2 footer-column">
                    <h3>CARTELERA</h3>
                    <br>
                    <ul>
                        <li><a href="#">Preventas</a></li>
                        <li><a href="#">Próximos Estrenos</a></li>
                        <li><a href="#">Contenido Cinesmero</a></li>
                    </ul>
                </div>
                <div class="col-md-3 footer-column">
                    <h3>¿QUIENES SOMOS?</h3>
                    <br>
                    <ul>
                        <li><a href="#">Nuestra Historia</a></li>
                        <li><a href="#">Misión y Visión</a></li>
                        <li><a href="#">Trabaja con Nosotros</a></li>
                    </ul>
                </div>
                <div class="col-md-2 footer-column">
                    <h3>POLÍTICAS</h3>
                    <br>
                    <ul>
                        <li><a href="#">Términos y Condiciones</a></li>
                        <li><a href="#">Política de Privacidad</a></li>
                        <li><a href="#">Política de Reembolsos</a></li>
                    </ul>
                </div>
                <div class="col-md-2 footer-column">
                    <div class="social-icons-vertical">
                        <a href="#" class="social-icon-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 footer-column">
                    <div class="footer-logo">
                        <a href="#" class="d-inline-block">
                        <img src="./img/logoCine.png" alt="Cinesmero Logo" width="150" height="150">                            <div class="footer-logo-text">Cinesmero</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        const navbar = document.querySelector('.navbar');
        let lastScrollTop = 0;

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                if (window.innerWidth < 992) {
                    closeNavbar();
                }
            });

            link.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.setProperty('--underline-width', '60%');
                }
            });

            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.setProperty('--underline-width', '0%');
                }
            });
        });

        function openNavbar() {
            navbarCollapse.style.maxHeight = '0px';
            navbarCollapse.style.opacity = '0';
            navbarCollapse.classList.add('show');
            
            setTimeout(() => {
                navbarCollapse.style.maxHeight = navbarCollapse.scrollHeight + 'px';
                navbarCollapse.style.opacity = '1';
            }, 10);
        }

        function closeNavbar() {
            if (window.innerWidth < 992) {
                navbarCollapse.style.maxHeight = navbarCollapse.scrollHeight + 'px';
                
                setTimeout(() => {
                    navbarCollapse.style.maxHeight = '0px';
                    navbarCollapse.style.opacity = '0';
                }, 10);

                setTimeout(() => {
                    navbarCollapse.classList.remove('show');
                }, 300);
            }
        }

        navbarToggler.addEventListener('click', function() {
            if (navbarCollapse.classList.contains('show')) {
                closeNavbar();
            } else {
                openNavbar();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                navbarCollapse.style.maxHeight = '';
                navbarCollapse.style.opacity = '';
                navbarCollapse.classList.remove('show');
            } else {
                if (!navbarCollapse.classList.contains('show')) {
                    navbarCollapse.style.maxHeight = '0px';
                    navbarCollapse.style.opacity = '0';
                }
            }
        });

        // Add scroll event listener
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                // Scrolling down
                navbar.classList.add('navbar-hidden');
            } else {
                // Scrolling up
                navbar.classList.remove('navbar-hidden');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
        }, false);
    });
    </script>
</body>
</html>