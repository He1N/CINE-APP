document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

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
});