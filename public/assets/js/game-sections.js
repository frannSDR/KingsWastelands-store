//! ----------- seccion de reviews para el usuario ----------- //

document.addEventListener('DOMContentLoaded', function() {
    const botonEscribirResena = document.querySelector('.boton-escribir-resena');
    const formularioResena = document.getElementById('formulario-resena');
    const cerrarFormulario = document.getElementById('cerrar-formulario');
    const cancelarResena = document.getElementById('cancelar-resena');
    const formNuevaResena = document.getElementById('nueva-resena');

    botonEscribirResena.addEventListener('click', function() {
        formularioResena.style.display = 'flex';
        botonEscribirResena.disabled = true;
    });

    function habilitarBoton() {
        botonEscribirResena.disabled = false;
    }

    // Ocultar formulario
    function ocultarFormulario() {
        habilitarBoton();
        formularioResena.style.display = 'none';
    }

    cerrarFormulario.addEventListener('click', function () {
        ocultarFormulario();
        habilitarBoton();
    });

    cancelarResena.addEventListener('click', function() {
        ocultarFormulario();
        habilitarBoton();
    });

    // Cerrar al hacer clic fuera del formulario
    formularioResena.addEventListener('click', function(e) {
        if (e.target === formularioResena) {
            ocultarFormulario();
        }
    });

    // Manejar envío del formulario
    formNuevaResena.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Verificar si el usuario está logueado
        if (!window.isUserLoggedIn) {
            window.location.href = window.loginUrl;
            return;
        }

        // Mostrar spinner de carga
        const submitBtn = formNuevaResena.querySelector('[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Enviando...';

        // Obtener datos del formulario
        const formData = new FormData(formNuevaResena);
        formData.append('game_id', window.gameId || '');

        // Enviar datos al backend
        fetch(window.guardarResenaUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Para identificar peticiones AJAX
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                mostrarNotificacion('success', '¡Reseña enviada con éxito!');
                
                // Recargar la página para mostrar la nueva reseña
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                // Mostrar errores
                mostrarNotificacion('error', data.message || 'Error al enviar la reseña');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Enviar reseña';
            }
        })
        .catch(error => {
            mostrarNotificacion('error', 'Error de conexión');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar reseña';
        });
    });

    // Función para mostrar notificaciones
    function mostrarNotificacion(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }

    // Efecto hover para las estrellas
    const estrellas = document.querySelectorAll('.rating-estrellas label');
    estrellas.forEach(estrella => {
        estrella.addEventListener('mouseover', function() {
            const valor = this.getAttribute('for').replace('estrella', '');
            resaltarEstrellas(valor);
        });

        estrella.addEventListener('mouseout', function() {
            const seleccionada = document.querySelector('.rating-estrellas input:checked');
            if (seleccionada) {
                resaltarEstrellas(seleccionada.value);
            } else {
                estrellas.forEach(e => e.style.color = '#3d3d3d');
            }
        });
    });

    function resaltarEstrellas(hasta) {
        estrellas.forEach(estrella => {
            const valorEstrella = estrella.getAttribute('for').replace('estrella', '');
            estrella.style.color = valorEstrella <= hasta ? '#fbbf24' : '#3d3d3d';
        });
    }

    const filtros = document.querySelectorAll('.boton-filtro');
    const ordenSelect = document.getElementById('orden-resenas');
    const listaResenas = document.querySelector('.lista-resenas');

    function cargarResenas() {
        const filtroActivo = document.querySelector('.boton-filtro.activo');
        const estrellas = filtroActivo ? filtroActivo.getAttribute('data-estrellas') : 'all';
        const orden = ordenSelect.value;
        fetch(`${window.baseUrl}juego/${window.gameId}/filtrar-resenas?estrellas=${estrellas}&orden=${orden}`)
            .then(res => res.text())
            .then(html => {
                listaResenas.innerHTML = html;
            });
    }   

    filtros.forEach(boton => {
        boton.addEventListener('click', function() {
            filtros.forEach(b => b.classList.remove('activo'));
            this.classList.add('activo');
            cargarResenas();
        });
    });

    ordenSelect.addEventListener('change', cargarResenas);

    function cargarResenas(page = 1) {
        const filtroActivo = document.querySelector('.boton-filtro.activo');
        const estrellas = filtroActivo ? filtroActivo.getAttribute('data-estrellas') : 'all';
        const orden = ordenSelect.value;
        fetch(`${window.baseUrl}juego/${window.gameId}/filtrar-resenas?estrellas=${estrellas}&orden=${orden}&page=${page}`)
            .then(res => res.text())
            .then(html => {
                listaResenas.innerHTML = html;
                asignarEventosPaginacion(); // <-- importante
            });
    }

    function asignarEventosPaginacion() {
        document.querySelectorAll('.paginacion-resenas a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page') || 1;
                cargarResenas(page);
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    asignarEventosPaginacion();
});

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