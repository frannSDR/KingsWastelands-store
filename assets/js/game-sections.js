//! ----------- filtro para los juegos ----------- //
const filterButton = document.getElementById('filterButton');
const filterDropdown = document.getElementById('filterDropdown');
const arrowIcon = document.getElementById('arrowIcon');
const dropdownItems = document.querySelectorAll('.dropdown-item');
const selectedFilterText = document.getElementById('selectedFilterText');

// Estado del filtro actual (obtenido de la URL o valores por defecto)
const urlParams = new URLSearchParams(window.location.search);
let currentFilter = urlParams.get('filter') || 'rating';
let currentDirection = urlParams.get('direction') || 'desc';

const filterNames = {
    'alphabetic': 'Alfabético',
    'release': 'Fecha',
    'rating': 'Calificación',
    'price': 'Precio'
};

// Mostrar filtro actual en el botón
selectedFilterText.textContent = filterNames[currentFilter];
selectedFilterText.classList.add('visible');

// Marcar item activo en el dropdown
dropdownItems.forEach(item => {
    if (item.getAttribute('data-filter') === currentFilter) {
        item.classList.add('active');
        item.setAttribute('data-direction', currentDirection);
        
        // Mostrar icono de dirección correcto
        const directionIcons = item.querySelectorAll('.asc-icon, .desc-icon');
        directionIcons.forEach(icon => icon.style.display = 'none');
        item.querySelector(`.${currentDirection}-icon`).style.display = 'block';
    }
});

// Mostrar/ocultar dropdown
filterButton.addEventListener('click', (e) => {
    e.stopPropagation();
    filterDropdown.classList.toggle('show');
    arrowIcon.classList.toggle('rotate');
});

// Cerrar dropdown al hacer clic fuera
document.addEventListener('click', () => {
    filterDropdown.classList.remove('show');
    arrowIcon.classList.remove('rotate');
});

// Manejar selección de filtros
dropdownItems.forEach(item => {
    item.addEventListener('click', (e) => {
        e.stopPropagation();
        const filterType = item.getAttribute('data-filter');
        
        // Determinar nueva dirección
        let newDirection;
        if (currentFilter === filterType) {
            newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
        } else {
            newDirection = 'desc'; // Nueva dirección por defecto
        }

        // Actualizar URL con los nuevos parámetros
        const url = new URL(window.location);
        url.searchParams.set('filter', filterType);
        url.searchParams.set('direction', newDirection);
        window.location.href = url.toString();
    });
});

//! ----------- ajustes de lightbox2 ------------ //

lightbox.option({
  'resizeDuration': 200, // Duración de la animación al abrir/cerrar
  'wrapAround': true,    // Permite navegar en bucle por las imágenes
  'fadeDuration': 300,   // Duración de la transición entre imágenes
  'imageFadeDuration': 300, // Duración de la transición de la imagen
  'showImageNumberLabel': true // Muestra el número de la imagen actual
});