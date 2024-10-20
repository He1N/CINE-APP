// Obtener los elementos del DOM
const mostrarFormularioBtn = document.getElementById('mostrarFormularioBtn');
const formularioOverlay = document.getElementById('formularioOverlay');
const cerrarFormularioBtn = document.getElementById('cerrarFormularioBtn');

// Función para mostrar el formulario
mostrarFormularioBtn.addEventListener('click', () => {
    formularioOverlay.style.display = 'flex';
});

// Función para cerrar el formulario
cerrarFormularioBtn.addEventListener('click', () => {
    formularioOverlay.style.display = 'none';
});

new DataTable('#example', {
    ajax: 'arrays.txt'
});