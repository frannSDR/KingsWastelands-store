//! ----------- filtro para los juegos ----------- //

const filterButton = document.getElementById('filterButton');
const filterDropdown = document.getElementById('filterDropdown');
const arrowIcon = document.getElementById('arrowIcon');
const dropdownItems = document.querySelectorAll('.dropdown-item');
const selectedFilterText = document.getElementById('selectedFilterText');

// estado del filtro actual
let currentFilter = null;
let currentDirection = 'asc';
const filterNames = {
    'alphabetic': 'Alfabético',
    'release': 'Fecha',
    'popularity': 'Popularidad',
    'rating': 'Calificación',
    'price': 'Precio'
};

// mostrar/ocultar dropdown al hacer clic en el boton
filterButton.addEventListener('click', () => {
    filterDropdown.classList.toggle('show');
    arrowIcon.classList.toggle('rotate');
    filterButton.classList.toggle('active');
});

// cerrar dropdown si se hace clic fuera
window.addEventListener('click', (event) => {
    if (!event.target.closest('.filter-container')) {
        filterDropdown.classList.remove('show');
        arrowIcon.classList.remove('rotate');
        filterButton.classList.remove('active');
    }
});

// manejar seleccion de opciones de filtro
dropdownItems.forEach(item => {
    item.addEventListener('click', () => {
        const filterType = item.getAttribute('data-filter');
        
        // si ya esta seleccionado el mismo filtro, cambiar direccion
        if (currentFilter === filterType) {
            currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            item.setAttribute('data-direction', currentDirection);
        } else {
            // quitar active de todos los items
            dropdownItems.forEach(dropItem => {
                dropItem.classList.remove('active');
            });
            
            // activar el elemento actual
            item.classList.add('active');
            item.setAttribute('data-direction', 'asc');
            currentFilter = filterType;
            currentDirection = 'asc';
        }
        
        // actualizar texto del filtro seleccionado en el boton
        selectedFilterText.textContent = filterNames[filterType];
        selectedFilterText.classList.add('visible');
        
        // aplicar el filtro
        applyFilter(filterType, currentDirection);
        
        // cerrar dropdown despues de seleccionar
        setTimeout(() => {
            filterDropdown.classList.remove('show');
            arrowIcon.classList.remove('rotate');
            filterButton.classList.remove('active');
        }, 300);
    });
});

// funcion para aplicar el filtro 
function applyFilter(filterType, direction) {
    console.log(`Aplicando filtro: ${filterType}, dirección: ${direction}`);
    
    // aca va a ir el codigo para filtrar los juegos una vez que tengamos la db

    const filterEvent = new CustomEvent('gamefilter', {
        detail: {
            filter: filterType,
            direction: direction
        }
    });
    document.dispatchEvent(filterEvent);
}

// agregado de efectos al dropdown
dropdownItems.forEach((item, index) => {
    item.style.opacity = "0";
    item.style.transform = "translateX(-10px)";
    
    // animacion de entrada escalonada
    setTimeout(() => {
        item.style.transition = "all 0.3s ease";
        item.style.opacity = "1";
        item.style.transform = "translateX(0)";
    }, 50 * (index + 1));
});

// Escuchar el evento personalizado (opcional)
document.addEventListener('gamefilter', (e) => {
    const { filter, direction } = e.detail;
    // aqui iria el codigo par manejar el filtrado
});

//! ----------- ajustes de lightbox2 ------------ //

lightbox.option({
  'resizeDuration': 200, // Duración de la animación al abrir/cerrar
  'wrapAround': true,    // Permite navegar en bucle por las imágenes
  'fadeDuration': 300,   // Duración de la transición entre imágenes
  'imageFadeDuration': 300, // Duración de la transición de la imagen
  'showImageNumberLabel': true // Muestra el número de la imagen actual
});