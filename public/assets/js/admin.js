// JavaScript para gestion 
document.addEventListener('DOMContentLoaded', function() {
    menuLateral();
    subirFotoPerfil();
    logicaPaginacion();
    agregarJuegoDisplay();
    agregarCategoriaDisplay();
    cambiarEntreSecciones();
    asociarModalDescuento();
    logicaModalDetalleVenta();
    
    // Usar event delegation para todos los botones dinámicos
    setupEventDelegation();
    
    // Inicializar validación de formularios
    initGameFormValidation();
});

// Event delegation para botones que se regeneran con AJAX
function setupEventDelegation() {
    // Event delegation para botones de editar juego
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-edit-game')) {
            const btn = e.target.closest('.btn-edit-game');
            const gameId = btn.getAttribute('data-id');
            editarJuegoHandler(gameId);
        }
    });

    // Event delegation para botones de desactivar juego
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-ban-game')) {
            const btn = e.target.closest('.btn-ban-game');
            const gameId = btn.getAttribute('data-id');
            if (confirm('¿Seguro que deseas desactivar este juego?')) {
                fetch('/admin-section/desactivar-juego/' + gameId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo desactivar el juego');
                });
            }
        }
    });

    // Event delegation para botones de activar juego
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-active-game')) {
            const btn = e.target.closest('.btn-active-game');
            const gameId = btn.getAttribute('data-id');
            if (confirm('¿Seguro que deseas activar este juego?')) {
                fetch('/admin-section/activar-juego/' + gameId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo activar el juego');
                });
            }
        }
    });

    // Event delegation para botones de banear usuario
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-ban-user')) {
            const btn = e.target.closest('.btn-ban-user');
            const userId = btn.getAttribute('data-id');
            if(confirm('¿Seguro que deseas banear a este usuario?')) {
                fetch('/admin-section/banear-usuario/' + userId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo banear el usuario');
                });
            }
        }
    });

    // Event delegation para botones de desbanear usuario
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-desban-user')) {
            const btn = e.target.closest('.btn-desban-user');
            const userId = btn.getAttribute('data-id');
            if(confirm('¿Seguro que deseas desbanear a este usuario?')) {
                fetch('/admin-section/desbanear-usuario/' + userId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo desbanear el usuario');
                });
            }
        }
    });

    // Event delegation para botones de eliminar categoría
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-del-cat')) {
            const btn = e.target.closest('.btn-del-cat');
            const catId = btn.getAttribute('data-id');
            if (confirm('¿Seguro que deseas borrar esta categoria?')) {
                fetch('/admin-section/eliminar-categoria/' + catId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo eliminar la categoría');
                });
            }
        }
    });

    // Event delegation para botones de descuento especial
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-special')) {
            const btn = e.target.closest('.btn-special');
            const gameId = btn.getAttribute('data-game-id');
            const actionUrl = btn.getAttribute('data-action-url');
            modalDescuento(gameId, actionUrl);
        }
    });
}

function menuLateral() {
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleBtn = document.querySelector('.admin-sidebar-toggle');
    const overlay = document.querySelector('.admin-sidebar-overlay');
    const menuItems = document.querySelectorAll('.admin-menu .menu-item');

    if (toggleBtn && sidebar && overlay) {
        // Toggle del sidebar
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        // Cerrar sidebar al hacer click en overlay
        overlay.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Cerrar el menú al hacer click en cualquier sección del menú (solo en móvil)
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
        });

        // Prevenir que el header hamburger interfiera
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                if (sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            }
        });
    }
}

function modalDescuento(gameId, actionUrl) {
  const modal = document.getElementById('specialModal');
  const form = document.getElementById('specialDiscountForm');
  form.action = actionUrl; // Establece la acción del formulario dinámicamente
  modal.style.display = 'flex';
  form.reset();
}

function cerrarModalDescuento() {
  document.getElementById('specialModal').style.display = 'none';
}

// Asocia el evento a todos los botones con la clase .btn-special
function asociarModalDescuento() {
    document.querySelectorAll('.btn-special').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = btn.getAttribute('data-game-id');
            const actionUrl = btn.getAttribute('data-action-url');
            modalDescuento(gameId, actionUrl);
        });
    });
}

function subirFotoPerfil() {
    const changeBtn = document.getElementById('changeProfileBtn');
    const inputFile = document.getElementById('profileImageInput');
    const imagePreview = document.getElementById('currentProfileImage');
    const form = document.getElementById('profileImageForm');

    if (changeBtn && inputFile && imagePreview && form) {
        changeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            inputFile.click();
        });

        inputFile.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);

                // Enviar formulario tradicional (no AJAX) para admin
                // El controlador ya maneja los redirects correctamente
                form.submit();
            }
        });
    }
}

// Cambiar entre secciones
function cambiarEntreSecciones() {
    const menuItems = document.querySelectorAll('.admin-menu .menu-item');
    const contentSections = document.querySelectorAll('.content-section');

    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Remover clase active de todos los items y secciones
            menuItems.forEach(i => i.classList.remove('active'));
            contentSections.forEach(s => s.classList.remove('active'));

            // Agregar clase active al item clickeado
            this.classList.add('active');

            // Mostrar la sección correspondiente
            const sectionId = this.getAttribute('data-section') + '-section';
            const section = document.getElementById(sectionId);
            
            if (section) {
                section.classList.add('active');
                console.log('Sección activada:', sectionId); // Para debug
            } else {
                console.error('Sección no encontrada:', sectionId); // Para debug
            }
        });
    });
}

// Mostrar y ocultar formulario
function agregarJuegoDisplay() {
    const addGameBtn = document.getElementById('addGameBtn');
    const gameFormContainer = document.getElementById('game-form-container');
    const gameTableContainer = document.getElementById('adminTable');
    const paginationContainer = document.getElementById('gamesPagination-container');

    if (addGameBtn && gameFormContainer && gameTableContainer) {
        addGameBtn.onclick = function () {
            const formVisible = gameFormContainer.style.display === 'block';

            if (!formVisible) {
                gameFormContainer.style.display = 'block';
                gameTableContainer.style.display = 'none';
                if (paginationContainer) paginationContainer.style.display = 'none';
                
                // Reinicializar validación y limpiar errores
                setTimeout(() => {
                    initGameFormValidation();
                    clearAllFormErrors();
                }, 100);
            } else {
                gameFormContainer.style.display = 'none';
                gameTableContainer.style.display = 'block';
                if (paginationContainer) paginationContainer.style.display = 'flex';
                
                // Limpiar formulario y errores
                const form = document.getElementById('upload-game-form');
                if (form) {
                    form.reset();
                    clearAllFormErrors();
                }
            }
        };
    }
}

function editarJuego() {
    document.querySelectorAll('.btn-edit-game').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const gameId = this.getAttribute('data-id');
            fetch('/admin-section/obtener-juego/' + gameId)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // aca obtenemos y mostramos los datos del objeto $juego
                        const form = document.getElementById('upload-game-form');
                        form.title.value = data.juego.title;
                        form.price.value = data.juego.price;
                        form.release_date.value = data.juego.release_date;
                        form.developer.value = data.juego.developer;
                        form.about.value = data.juego.about;
                        form.synopsis.value = data.juego.synopsis;
                        document.getElementById('trailer-url').value = data.juego.youtube_trailer_id;
                        form.cover_url.value = data.juego.cover_image_url;
                        form.card_url.value = data.juego.card_image_url;
                        form.banner_url.value = data.juego.banner_image_url;
                        form.logo_url.value = data.juego.logo_url;
                        form.game_rating.value = data.juego.rating;

                        // aca obtenemos los checkboxes de categorias marcados para cada juego
                        // esto se hace obteniendo un array con los valores de categoria que tiene cada juego, luego, dado que los checkboxes se muestran en el mismo orden en el que las categorias estan ordenadas en la base de datos, se marcan aquellos checkboxes que coinciden con los valores de las categorias
                        if (Array.isArray(data.categories)) {
                            document.querySelectorAll('input[name="categories[]"]').forEach(cb => {
                                cb.checked = data.categories.includes(parseInt(cb.value));
                            });
                        }

                        // aca obtengo las posiciones de las urls de las imagens adicionales de cada juego y se muestran en su input correspondiente
                        if (Array.isArray(data.additional_images)) {
                            const imgs = document.querySelectorAll('input[name="additional_images[]"]');
                            imgs.forEach((input, idx) => {
                                input.value = data.additional_images[idx] || '';
                            });
                        }

                        // aca obtenemos los requisitos, simplemente se verifica por un condicional si cada requisito coincide con el 'tipo', y se muestra el valor acorde a eso
                        if (data.requisitos) {
                            if (data.requisitos.minimo) {
                                document.getElementById('min-cpu').value = data.requisitos.minimo.cpu || '';
                                document.getElementById('min-ram').value = data.requisitos.minimo.ram || '';
                                document.getElementById('min-gpu').value = data.requisitos.minimo.gpu || '';
                                document.getElementById('min-storage').value = data.requisitos.minimo.storage || '';
                            }
                            if (data.requisitos.recomendado) {
                                document.getElementById('rec-cpu').value = data.requisitos.recomendado.cpu || '';
                                document.getElementById('rec-ram').value = data.requisitos.recomendado.ram || '';
                                document.getElementById('rec-gpu').value = data.requisitos.recomendado.gpu || '';
                                document.getElementById('rec-storage').value = data.requisitos.recomendado.storage || '';
                            }
                            if (data.requisitos.ultra) {
                                document.getElementById('ultra-cpu').value = data.requisitos.ultra.cpu || '';
                                document.getElementById('ultra-ram').value = data.requisitos.ultra.ram || '';
                                document.getElementById('ultra-gpu').value = data.requisitos.ultra.gpu || '';
                                document.getElementById('ultra-storage').value = data.requisitos.ultra.storage || '';
                            }
                        }

                        // cambiamos la funcion y el texto del boton 'publicar juego' que por defecto es subir un juego nuevo a la base de datos, por la funcion de actualizar un juego basado en su $id
                        form.action = '/admin-section/actualizar-juego/' + gameId;
                        const submitBtn = form.querySelector('button[type="submit"]');
                        submitBtn.textContent = 'Actualizar juego';

                        // aca simplemente mostramos o ocultamos el formulario para rellenar los datos
                        document.getElementById('game-form-container').style.display = 'block';
                        document.getElementById('adminTable').style.display = 'none';

                        // devolvemos el boton submit a su funcion y texto por defecto, la de subir un juego
                        form.onsubmit = function() {
                            setTimeout(() => {
                                // restauracion del boton
                                form.action = '/admin-section/guardar-juego';
                                submitBtn.textContent = 'Publicar juego';
                                form.reset();
                                document.getElementById('game-form-container').style.display = 'none';
                                document.getElementById('adminTable').style.display = 'block';
                            }, 500);
                        };
                    } else {
                        alert('No se pudo cargar el juego');
                    }
                });
        });
    });
}

// Función para manejar la edición de juegos (extraída para event delegation)
function editarJuegoHandler(gameId) {
    fetch('/admin-section/obtener-juego/' + gameId)
        .then(res => res.json())
        .then(data => {
            console.log('Datos recibidos para editar juego:', data); // Log de depuración
            if (data.success) {
                // aca obtenemos y mostramos los datos del objeto $juego
                const form = document.getElementById('upload-game-form');
                form.title.value = data.juego.title;
                form.price.value = data.juego.price;
                form.release_date.value = data.juego.release_date;
                form.developer.value = data.juego.developer;
                form.about.value = data.juego.about;
                form.synopsis.value = data.juego.synopsis;
                document.getElementById('trailer-url').value = data.juego.youtube_trailer_id;
                form.cover_url.value = data.juego.cover_image_url;
                form.card_url.value = data.juego.card_image_url;
                form.banner_url.value = data.juego.banner_image_url;
                form.logo_url.value = data.juego.logo_url;
                form.game_rating.value = data.juego.rating;

                // aca obtenemos los checkboxes de categorias marcados para cada juego
                if (Array.isArray(data.categories)) {
                    document.querySelectorAll('input[name="categories[]"]').forEach(cb => {
                        cb.checked = data.categories.includes(parseInt(cb.value));
                    });
                }

                // aca obtengo las posiciones de las urls de las imagens adicionales de cada juego y se muestran en su input correspondiente
                console.log('Imágenes adicionales:', data.additional_images); // Log de depuración
                if (Array.isArray(data.additional_images)) {
                    const imgs = document.querySelectorAll('input[name="additional_images[]"]');
                    imgs.forEach((input, idx) => {
                        input.value = data.additional_images[idx] || '';
                    });
                }

                // aca obtenemos los requisitos, usando la misma lógica que la función original
                console.log('Requisitos:', data.requisitos); // Log de depuración
                if (data.requisitos) {
                    if (data.requisitos.minimo) {
                        document.getElementById('min-cpu').value = data.requisitos.minimo.cpu || '';
                        document.getElementById('min-ram').value = data.requisitos.minimo.ram || '';
                        document.getElementById('min-gpu').value = data.requisitos.minimo.gpu || '';
                        document.getElementById('min-storage').value = data.requisitos.minimo.storage || '';
                    }
                    if (data.requisitos.recomendado) {
                        document.getElementById('rec-cpu').value = data.requisitos.recomendado.cpu || '';
                        document.getElementById('rec-ram').value = data.requisitos.recomendado.ram || '';
                        document.getElementById('rec-gpu').value = data.requisitos.recomendado.gpu || '';
                        document.getElementById('rec-storage').value = data.requisitos.recomendado.storage || '';
                    }
                    if (data.requisitos.ultra) {
                        document.getElementById('ultra-cpu').value = data.requisitos.ultra.cpu || '';
                        document.getElementById('ultra-ram').value = data.requisitos.ultra.ram || '';
                        document.getElementById('ultra-gpu').value = data.requisitos.ultra.gpu || '';
                        document.getElementById('ultra-storage').value = data.requisitos.ultra.storage || '';
                    }
                }

                // cambiamos la funcion y el texto del boton 'publicar juego' que por defecto es subir un juego nuevo a la base de datos, por la funcion de actualizar un juego basado en su $id
                form.action = '/admin-section/actualizar-juego/' + gameId;
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.textContent = 'Actualizar juego';

                // aca simplemente mostramos o ocultamos el formulario para rellenar los datos
                document.getElementById('game-form-container').style.display = 'block';
                document.getElementById('adminTable').style.display = 'none';

                // Reinicializar validación y limpiar errores
                setTimeout(() => {
                    initGameFormValidation();
                    clearAllFormErrors();
                }, 100);

                // devolvemos el boton submit a su funcion y texto por defecto, la de subir un juego
                form.onsubmit = function() {
                    setTimeout(() => {
                        // restauracion del boton
                        form.action = '/admin-section/guardar-juego';
                        submitBtn.textContent = 'Publicar juego';
                        form.reset();
                        clearAllFormErrors();
                        document.getElementById('game-form-container').style.display = 'none';
                        document.getElementById('adminTable').style.display = 'block';
                    }, 500);
                };
            } else {
                alert('No se pudo cargar el juego');
            }
        });
}

// Funcion para desactivar un juego
function desactivar_juego() {
    document.querySelectorAll('.btn-ban-game').forEach(btn => {
        btn.addEventListener('click', function() {
            const gameId = this.getAttribute('data-id');
            if (confirm('¿Seguro que deseas desactivar este juego?')) {
                fetch('/admin-section/desactivar-juego/' + gameId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo desactivar el juego');
                });
            }
        });
    });
}

// Funcion para activar un juego
function activar_juego() {
    document.querySelectorAll('.btn-active-game').forEach(btn => {
        btn.addEventListener('click', function() {
            const gameId = this.getAttribute('data-id');
            if (confirm('¿Seguro que deseas activar este juego?')) {
                fetch('/admin-section/activar-juego/' + gameId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo activar el juego');
                });
            }
        });
    });
}

// Funcion para banear a un usuario
function banearUsuario() {
    document.querySelectorAll('.btn-ban-user').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const userId = this.getAttribute('data-id');
            if(confirm('¿Seguro que deseas banear a este usuario?')) {
                fetch('/admin-section/banear-usuario/' + userId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo banear este usuario');
                });
            }
        });
    });
}

// Funcion para desbanear a un usuario
function desbanearUsuario() {
    document.querySelectorAll('.btn-desban-user').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const userId = this.getAttribute('data-id');
            if(confirm('¿Seguro que deseas desbanear a este usuario?')) {
                fetch('/admin-section/desbanear-usuario/' + userId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo desbanear este usuario');
                });
            }
        });
    });
}

// Manejar el formulario de nueva categoria
function eliminarCategoria() {
    document.querySelectorAll('.btn-del-cat').forEach(btn => {
        btn.addEventListener('click', function() {
            const catId = this.getAttribute('data-id');
            if (confirm('¿Seguro que deseas borrar esta categoria?')) {
                fetch('/admin-section/eliminar-categoria/' + catId, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) location.reload();
                    else alert('No se pudo eliminar la categoría');
                });
            }
        });
    });
}

function agregarCategoriaDisplay() {
    const addGameBtn = document.getElementById('add-category-btn');
    const gameFormContainer = document.getElementById('category-form-container');

    if (addGameBtn && gameFormContainer) {
        addGameBtn.onclick = function () {
            const formVisible = gameFormContainer.style.display === 'block';

            if (!formVisible) {
                gameFormContainer.style.display = 'block';
            } else {
                gameFormContainer.style.display = 'none';
            }
        };
    }   
}

// Manejar la paginacion
function logicaPaginacion() {
    document.addEventListener('click', function(e) {
        // paginacion de usuarios
        const userPagBtn = e.target.closest('.user-pagination-button a');
        if (userPagBtn) {
            e.preventDefault();
            fetchPaginatedContent(userPagBtn.href, 'usuarios-list-container');
            return;
        }
        // paginacion de juegos
        const gamesPagBtn = e.target.closest('.games-pagination-button a');
        if (gamesPagBtn) {
            e.preventDefault();
            fetchPaginatedContent(gamesPagBtn.href, 'games-list-container');
            return;
        }
        // paginacion para las categorias
        const catPagBtn = e.target.closest('.cat-pagination-button a');
        if (catPagBtn) {
            e.preventDefault();
            fetchPaginatedContent(catPagBtn.href, 'categorias-list-container');
            return;
        }
        // paginacion de ventas 
        const ventasPagBtn = e.target.closest('.ventas-pagination-button a');
        if (ventasPagBtn) {
            e.preventDefault();
            fetchPaginatedContent(ventasPagBtn.href, 'ventas-list-container');
            return;
        }
    });

    // función para cargar el contenido paginado
    function fetchPaginatedContent(url, containerId) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.text())
        .then(html => {
            const container = document.getElementById(containerId);
            if (container) container.innerHTML = html;
            history.pushState({section: containerId}, '', url);

            // Solo rebindeamos las funciones que no usan event delegation
            if (containerId === 'games-list-container') {
                agregarJuegoDisplay();
            }
        });
    }

    // Manejar el popstate (navegación con el botón atrás/adelante)
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.section) {
            window.location.reload();
        }
    });
}

function logicaModalDetalleVenta() {
    // Abrir modal al hacer click en cualquier botón de detalles
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.view-btn[data-compra]');
        if (btn) {
            const compra = JSON.parse(btn.getAttribute('data-compra'));
            mostrarDetalleVenta(compra);
        }
    });

    // Cerrar modal al hacer click en el fondo o en el botón de cerrar
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('close-modal') || e.target.id === 'sale-detail-modal') {
            document.getElementById('sale-detail-modal').style.display = 'none';
        }
    });

    // Cerrar modal con ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.getElementById('sale-detail-modal').style.display = 'none';
        }
    });
}

function mostrarDetalleVenta(compra) {
    const modal = document.getElementById('sale-detail-modal');
    if (!modal) return;

    // ID de venta
    modal.querySelector('#sale-id').textContent = '#KW-' + compra.compra_id;

    // Info cliente
    modal.querySelector('#modal-nombre').textContent = compra.nombre_completo || '';
    modal.querySelector('#modal-email').textContent = compra.user_email || compra.email || '';
    modal.querySelector('#modal-telefono').textContent = compra.telefono || '';
    modal.querySelector('#modal-userid').textContent = compra.user_id || '';

    // Productos
    const prodList = modal.querySelector('#modal-productos');
    if (prodList) {
        prodList.innerHTML = '';
        (compra.productos || []).forEach(producto => {
            prodList.innerHTML += `
                <div class="product-detail-item">
                    <div class="product-info">
                        <span class="product-name">${producto.nombre || ''}</span>
                        <span class="product-platform">${producto.platform || ''}</span>
                        <span class="product-sku">${producto.sku ? 'SKU: ' + producto.sku : ''}</span>
                    </div>
                    <div class="product-pricing">
                        <span class="product-quantity-price">${producto.cantidad || 1} x $${Number(producto.precio_unitario).toFixed(2)}</span>
                    </div>
                </div>
            `;
        });
    }

    // Totales
    const saleTotals = modal.querySelector('#modal-totales');
    if (saleTotals) {
        let subtotal = 0;
        (compra.productos || []).forEach(p => {
            subtotal += Number(p.precio_unitario) * (p.cantidad || 1);
        });
        saleTotals.innerHTML = `
            <div class="total-row">
                <span>Subtotal:</span>
                <span>$${subtotal.toFixed(2)}</span>
            </div>
            <div class="total-row grand-total">
                <span>Total:</span>
                <span>$${Number(compra.total).toFixed(2)}</span>
            </div>
        `;
    }

    // Info de pago
    modal.querySelector('#modal-metodo').textContent = compra.metodo_pago || '';
    modal.querySelector('#modal-transaccion').textContent = '#KW-' + compra.compra_id || '';
    const estado = modal.querySelector('#modal-estado');
    estado.textContent = compra.estado || '';
    estado.className = 'detail-value status-badge ' + (compra.estado ? compra.estado.toLowerCase() : '');
    modal.querySelector('#modal-fecha').textContent = compra.fecha ? (new Date(compra.fecha)).toLocaleString('es-AR') : '';

    modal.style.display = 'flex';
}

// ========== VALIDACIÓN DE FORMULARIOS ==========

// Función principal para inicializar validación
function initGameFormValidation() {
    const form = document.getElementById('upload-game-form');
    if (!form) return;

    // Agregar event listeners para validación en tiempo real
    setupFieldValidation(form);
    
    // Validar al enviar el formulario
    form.addEventListener('submit', function(e) {
        if (!validateCompleteForm()) {
            e.preventDefault();
            scrollToFirstError();
        }
    });
}

// Configurar validación para cada campo
function setupFieldValidation(form) {
    // Campos de texto requeridos
    const textFields = [
        'title', 'developer', 'about', 'synopsis', 'trailer',
        'min_cpu', 'min_ram', 'min_gpu', 'min_storage',
        'rec_cpu', 'rec_ram', 'rec_gpu', 'rec_storage',
        'ultra_cpu', 'ultra_ram', 'ultra_gpu', 'ultra_storage'
    ];

    textFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('blur', () => validateTextField(fieldName));
            field.addEventListener('input', () => clearFieldError(fieldName));
        }
    });

    // Campos URL
    const urlFields = ['cover_url', 'card_url', 'banner_url', 'logo_url'];
    urlFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('blur', () => validateUrlField(fieldName));
            field.addEventListener('input', () => clearFieldError(fieldName));
        }
    });

    // Campos numéricos
    const field_price = form.querySelector('[name="price"]');
    if (field_price) {
        field_price.addEventListener('blur', () => validatePriceField());
        field_price.addEventListener('input', () => clearFieldError('game-price'));
    }

    const field_rating = form.querySelector('[name="game_rating"]');
    if (field_rating) {
        field_rating.addEventListener('blur', () => validateRatingField());
        field_rating.addEventListener('input', () => clearFieldError('game-rating'));
    }

    // Campo de fecha
    const dateField = form.querySelector('[name="release_date"]');
    if (dateField) {
        dateField.addEventListener('blur', () => validateDateField());
        dateField.addEventListener('change', () => clearFieldError('release-date'));
    }

    // Imágenes adicionales
    for (let i = 1; i <= 4; i++) {
        const field = form.querySelector(`#additional-image-${i}`);
        if (field) {
            field.addEventListener('blur', () => validateAdditionalImageField(i));
            field.addEventListener('input', () => clearFieldError(`additional-image-${i}`));
        }
    }

    // Categorías
    const categoryCheckboxes = form.querySelectorAll('[name="categories[]"]');
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (getSelectedCategories().length > 0) {
                clearCategoriesError();
            }
        });
    });
}

// Validar campo de texto
function validateTextField(fieldName) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (!field) return true;

    const value = field.value.trim();
    
    if (!value) {
        showFieldError(fieldName, 'Este campo es obligatorio');
        return false;
    }
    
    // Validaciones específicas
    if (fieldName === 'title' && value.length < 2) {
        showFieldError(fieldName, 'El título debe tener al menos 2 caracteres');
        return false;
    }
    
    if (fieldName === 'about' && value.length < 10) {
        showFieldError(fieldName, 'La descripción debe tener al menos 10 caracteres');
        return false;
    }
    
    if (fieldName === 'synopsis' && value.length < 20) {
        showFieldError(fieldName, 'La sinopsis debe tener al menos 20 caracteres');
        return false;
    }
    
    clearFieldError(fieldName);
    return true;
}

// Validar campo URL
function validateUrlField(fieldName) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (!field) return true;

    const value = field.value.trim();
    
    if (!value) {
        showFieldError(fieldName, 'Este campo es obligatorio');
        return false;
    }
    
    const urlPattern = /^https?:\/\/.+\..+/;
    if (!urlPattern.test(value)) {
        showFieldError(fieldName, 'Debe ser una URL válida (http:// o https://)');
        return false;
    }
    
    clearFieldError(fieldName);
    return true;
}

// Validar campo de precio
function validatePriceField() {
    const field = document.querySelector('[name="price"]');
    if (!field) return true;

    const value = field.value.trim();
    
    if (!value) {
        showFieldError('game-price', 'Este campo es obligatorio');
        return false;
    }
    
    const numValue = parseFloat(value);
    
    if (isNaN(numValue) || numValue <= 0) {
        showFieldError('game-price', 'El precio debe ser un número mayor a 0');
        return false;
    }
    
    clearFieldError('game-price');
    return true;
}

// Validar campo de valoración
function validateRatingField() {
    const field = document.querySelector('[name="game_rating"]');
    if (!field) return true;

    const value = field.value.trim();
    
    if (!value) {
        showFieldError('game-rating', 'Este campo es obligatorio');
        return false;
    }
    
    const numValue = parseFloat(value);
    
    if (isNaN(numValue) || numValue < 1 || numValue > 10) {
        showFieldError('game-rating', 'La valoración debe estar entre 1 y 10');
        return false;
    }
    
    clearFieldError('game-rating');
    return true;
}

// Validar campo de fecha
function validateDateField() {
    const field = document.querySelector('[name="release_date"]');
    if (!field) return true;

    const value = field.value;
    
    if (!value) {
        showFieldError('release-date', 'Este campo es obligatorio');
        return false;
    }
    
    clearFieldError('release-date');
    return true;
}

// Validar imagen adicional
function validateAdditionalImageField(index) {
    const field = document.querySelector(`#additional-image-${index}`);
    if (!field) return true;

    const value = field.value.trim();
    
    if (!value) {
        showFieldError(`additional-image-${index}`, 'Esta imagen es obligatoria');
        return false;
    }
    
    clearFieldError(`additional-image-${index}`);
    return true;
}

// Validar categorías
function validateCategories() {
    const selectedCategories = getSelectedCategories();
    
    if (selectedCategories.length === 0) {
        showCategoriesError('Debe seleccionar al menos una categoría');
        return false;
    }
    
    clearCategoriesError();
    return true;
}

// Obtener categorías seleccionadas
function getSelectedCategories() {
    const checkboxes = document.querySelectorAll('[name="categories[]"]:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// Mostrar error en campo específico
function showFieldError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + '-error');
    const field = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
    
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }
    
    if (field) {
        const formGroup = field.closest('.form-group');
        if (formGroup) {
            formGroup.classList.add('has-error');
            formGroup.classList.remove('has-success');
        }
    }
}

// Limpiar error de campo específico
function clearFieldError(fieldId) {
    const errorElement = document.getElementById(fieldId + '-error');
    const field = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
    
    if (errorElement) {
        errorElement.classList.remove('show');
    }
    
    if (field) {
        const formGroup = field.closest('.form-group');
        if (formGroup) {
            formGroup.classList.remove('has-error');
            formGroup.classList.add('has-success');
        }
    }
}

// Mostrar error en categorías
function showCategoriesError(message) {
    const errorElement = document.getElementById('categories-error');
    const container = document.getElementById('categories-container');
    
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }
    
    if (container) {
        container.classList.add('has-error');
    }
}

// Limpiar error de categorías
function clearCategoriesError() {
    const errorElement = document.getElementById('categories-error');
    const container = document.getElementById('categories-container');
    
    if (errorElement) {
        errorElement.classList.remove('show');
    }
    
    if (container) {
        container.classList.remove('has-error');
    }
}

// Validar todo el formulario
function validateCompleteForm() {
    let isValid = true;
    
    // Validar campos de texto
    const textFields = [
        'title', 'developer', 'about', 'synopsis', 'trailer',
        'min_cpu', 'min_ram', 'min_gpu', 'min_storage',
        'rec_cpu', 'rec_ram', 'rec_gpu', 'rec_storage',
        'ultra_cpu', 'ultra_ram', 'ultra_gpu', 'ultra_storage'
    ];
    
    textFields.forEach(fieldName => {
        if (!validateTextField(fieldName)) {
            isValid = false;
        }
    });
    
    // Validar campos URL
    const urlFields = ['cover_url', 'card_url', 'banner_url', 'logo_url'];
    urlFields.forEach(fieldName => {
        if (!validateUrlField(fieldName)) {
            isValid = false;
        }
    });
    
    // Validar campos numéricos
    if (!validatePriceField()) {
        isValid = false;
    }
    
    if (!validateRatingField()) {
        isValid = false;
    }
    
    // Validar fecha
    if (!validateDateField()) {
        isValid = false;
    }
    
    // Validar imágenes adicionales
    for (let i = 1; i <= 4; i++) {
        if (!validateAdditionalImageField(i)) {
            isValid = false;
        }
    }
    
    // Validar categorías
    if (!validateCategories()) {
        isValid = false;
    }
    
    return isValid;
}

// Hacer scroll al primer error
function scrollToFirstError() {
    const firstError = document.querySelector('.form-error.show, .categories-error.show');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Limpiar todos los errores del formulario
function clearAllFormErrors() {
    // Limpiar errores de campos
    const errorElements = document.querySelectorAll('.form-error');
    errorElements.forEach(error => {
        error.classList.remove('show');
    });
    
    // Limpiar clases de error
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach(group => {
        group.classList.remove('has-error', 'has-success');
    });
    
    // Limpiar error de categorías
    clearCategoriesError();
}