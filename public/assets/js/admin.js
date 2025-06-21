// JavaScript para gestion 
document.addEventListener('DOMContentLoaded', function() {
    subirFotoPerfil();
    logicaPaginacion();
    editarJuego();
    agregarJuegoDisplay();
    agregarCategoriaDisplay();
    cambiarEntreSecciones();
    eliminarCategoria();
    banearUsuario();
    desbanearUsuario();
    activar_juego();
    desactivar_juego();
    asociarModalDescuento();
    logicaModalDetalleVenta();
});

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

                form.submit();
            }
        });
    }
}

// Cambiar entre secciones
function cambiarEntreSecciones() {
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            menuItems.forEach(i => i.classList.remove('active'));
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            this.classList.add('active');
            const sectionId = this.getAttribute('data-section') + '-section';
            const section = document.getElementById(sectionId);
            if (section) section.classList.add('active');
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
            } else {
                gameFormContainer.style.display = 'none';
                gameTableContainer.style.display = 'block';
                if (paginationContainer) paginationContainer.style.display = 'flex';
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
                        form.trailer.value = data.juego.youtube_trailer_id;
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
                                form.min_cpu.value = data.requisitos.minimo.cpu;
                                form.min_ram.value = data.requisitos.minimo.ram;
                                form.min_gpu.value = data.requisitos.minimo.gpu;
                                form.min_storage.value = data.requisitos.minimo.storage;
                            }
                            if (data.requisitos.recomendado) {
                                form.rec_cpu.value = data.requisitos.recomendado.cpu;
                                form.rec_ram.value = data.requisitos.recomendado.ram;
                                form.rec_gpu.value = data.requisitos.recomendado.gpu;
                                form.rec_storage.value = data.requisitos.recomendado.storage;
                            }
                            if (data.requisitos.ultra) {
                                form.ultra_cpu.value = data.requisitos.ultra.cpu;
                                form.ultra_ram.value = data.requisitos.ultra.ram;
                                form.ultra_gpu.value = data.requisitos.ultra.gpu;
                                form.ultra_storage.value = data.requisitos.ultra.storage;
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

            // rebindeamos las funciones para poder trabajar con ajax
            const rebindeo = [
                'games-list-container',
                'usuarios-list-container',
                'categorias-list-container',
                'ventas-list-container'
            ];
            if (rebindeo.includes(containerId)) {
                agregarJuegoDisplay();
                editarJuego();
                eliminarCategoria();
                banearUsuario();
                desbanearUsuario();
                activar_juego();
                desactivar_juego();
                asociarModalDescuento();
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
                        <span class="product-quantity">${producto.cantidad || 1} x</span>
                        <span class="product-price">$${Number(producto.precio_unitario).toFixed(2)}</span>
                        <span class="product-total">$${(Number(producto.precio_unitario) * (producto.cantidad || 1)).toFixed(2)}</span>
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
    modal.querySelector('#modal-transaccion').textContent = compra.transaccion_id || '';
    const estado = modal.querySelector('#modal-estado');
    estado.textContent = compra.estado || '';
    estado.className = 'detail-value status-badge ' + (compra.estado ? compra.estado.toLowerCase() : '');
    modal.querySelector('#modal-fecha').textContent = compra.fecha ? (new Date(compra.fecha)).toLocaleString('es-AR') : '';

    // Mostrar modal (usa flex si tu CSS lo requiere)
    modal.style.display = 'flex';
}