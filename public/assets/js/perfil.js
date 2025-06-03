// JavaScript para gestion 
document.addEventListener('DOMContentLoaded', function() {
    bindEditGameBtns();
    bindAddGameBtn();
    changeBetweenSections();
    searchUser();
    categoryForm();
    actionBtns();
    paginationLogic();
});

// Mostrar y ocultar formulario
function bindAddGameBtn() {
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

// Cambiar entre secciones
function changeBetweenSections() {
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

// Búsqueda en tiempo real
function searchUser() {
    const searchInput = document.getElementById('user-search');
    if (!searchInput) return;
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.users-admin-table tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}

// Botones de accion (placeholder)
function actionBtns() {
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            // Lógica para editar usuario
        });
    });
}

// Manejar el formulario de nueva categoria
function categoryForm() {
    const addCategoryBtn = document.getElementById('add-category-btn');
    const categoryFormContainer = document.getElementById('category-form-container');
    const cancelCategoryBtn = document.getElementById('cancel-category');
    const deleteModal = document.getElementById('delete-category-modal');
    const categoryFormEl = document.getElementById('category-form');
    const iconInput = document.getElementById('category-icon');
    const iconPreview = document.getElementById('icon-preview');
    const categoryIdInput = document.getElementById('category-id');
    const categoryNameInput = document.getElementById('category-name');
    const categorySlugInput = document.getElementById('category-slug');
    const categorySubmitText = document.getElementById('category-submit-text');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const categoryToDelete = document.getElementById('category-to-delete');

    if (!addCategoryBtn || !categoryFormContainer || !cancelCategoryBtn || !deleteModal || !categoryFormEl) return;

    // Mostrar/ocultar formulario
    addCategoryBtn.addEventListener('click', function() {
        categoryFormContainer.style.display = 'block';
        categoryFormEl.reset();
        if (categoryIdInput) categoryIdInput.value = '';
        if (categorySubmitText) categorySubmitText.textContent = 'Guardar';
        if (iconPreview) iconPreview.className = 'bi bi-question-circle';
    });

    cancelCategoryBtn.addEventListener('click', function() {
        categoryFormContainer.style.display = 'none';
    });

    // Preview del icono
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            const iconClass = this.value.trim() ? 'bi-' + this.value.trim() : 'bi-question-circle';
            iconPreview.className = 'bi ' + iconClass;
        });
    }

    // Botones de editar categorias
    document.querySelectorAll('.btn-edit[data-id]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-id');
            // Aquí iría la lógica para cargar los datos de la categoría (AJAX)
            categoryFormContainer.style.display = 'block';
            if (categorySubmitText) categorySubmitText.textContent = 'Actualizar';

            // Ejemplo con datos estáticos:
            if (categoryId === '1') {
                if (categoryIdInput) categoryIdInput.value = '1';
                if (categoryNameInput) categoryNameInput.value = 'RPG';
                if (categorySlugInput) categorySlugInput.value = 'juegos-rpg';
                if (iconInput) iconInput.value = 'dice-5';
                if (iconPreview) iconPreview.className = 'bi bi-dice-5';
            }
        });
    });

    // Botones de eliminar
    document.querySelectorAll('.btn-danger[data-id]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-id');
            const row = this.closest('tr');
            const categoryName = row ? row.querySelector('td:nth-child(2)').textContent : '';
            if (categoryToDelete) categoryToDelete.textContent = categoryName;
            deleteModal.style.display = 'flex';

            // Configurar acción de eliminación
            if (confirmDeleteBtn) {
                confirmDeleteBtn.onclick = function() {
                    // Aquí iría la lógica AJAX para eliminar
                    console.log('Eliminar categoría ID:', categoryId);
                    deleteModal.style.display = 'none';
                    // Recargar o eliminar la fila
                    if (row) row.remove();
                };
            }
        });
    });

    // Cerrar modal
    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', function() {
            deleteModal.style.display = 'none';
        });
    }

    // Enviar formulario
    categoryFormEl.addEventListener('submit', function(e) {
        e.preventDefault();
        // Aquí iría la lógica AJAX para guardar
        console.log('Formulario enviado:', {
            id: categoryIdInput ? categoryIdInput.value : '',
            name: categoryNameInput ? categoryNameInput.value : '',
            slug: categorySlugInput ? categorySlugInput.value : '',
            icon: iconInput ? iconInput.value : ''
        });

        // Simular éxito
        categoryFormContainer.style.display = 'none';
        alert('¡Categoría guardada con éxito!');
    });
}

function bindEditGameBtns() {
    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const gameId = this.getAttribute('data-id');
            fetch('/perfil/obtener-juego/' + gameId)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const form = document.getElementById('upload-game-form');
                        // Rellenar campos principales
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

                        // Marcar categorías (debes traerlas en data.juego.categories como array de IDs)
                        if (Array.isArray(data.juego.categories)) {
                            document.querySelectorAll('input[name="categories[]"]').forEach(cb => {
                                cb.checked = data.juego.categories.includes(parseInt(cb.value));
                            });
                        }

                        // Imágenes adicionales (debes traerlas en data.juego.additional_images como array)
                        if (Array.isArray(data.juego.additional_images)) {
                            const imgs = document.querySelectorAll('input[name="additional_images[]"]');
                            imgs.forEach((input, idx) => {
                                input.value = data.juego.additional_images[idx] || '';
                            });
                        }

                        // Requisitos (debes traerlos en data.juego.requisitos como objeto por tipo)
                        if (data.juego.requisitos) {
                            if (data.juego.requisitos.minimo) {
                                form.min_cpu.value = data.juego.requisitos.minimo.cpu;
                                form.min_ram.value = data.juego.requisitos.minimo.ram;
                                form.min_gpu.value = data.juego.requisitos.minimo.gpu;
                                form.min_storage.value = data.juego.requisitos.minimo.storage;
                            }
                            if (data.juego.requisitos.recomendado) {
                                form.rec_cpu.value = data.juego.requisitos.recomendado.cpu;
                                form.rec_ram.value = data.juego.requisitos.recomendado.ram;
                                form.rec_gpu.value = data.juego.requisitos.recomendado.gpu;
                                form.rec_storage.value = data.juego.requisitos.recomendado.storage;
                            }
                            if (data.juego.requisitos.ultra) {
                                form.ultra_cpu.value = data.juego.requisitos.ultra.cpu;
                                form.ultra_ram.value = data.juego.requisitos.ultra.ram;
                                form.ultra_gpu.value = data.juego.requisitos.ultra.gpu;
                                form.ultra_storage.value = data.juego.requisitos.ultra.storage;
                            }
                        }

                        // Cambia el action y el texto del botón
                        form.action = '/perfil/actualizar-juego/' + gameId;
                        const submitBtn = form.querySelector('button[type="submit"]');
                        submitBtn.textContent = 'Actualizar juego';

                        // Mostrar formulario y ocultar tabla
                        document.getElementById('game-form-container').style.display = 'block';
                        document.getElementById('adminTable').style.display = 'none';

                        // Al enviar el formulario, restaurar todo a modo "alta"
                        form.onsubmit = function() {
                            setTimeout(() => {
                                // Restaurar formulario tras submit (espera redirección)
                                form.action = '/perfil/guardar-juego';
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

// Manejar la paginacion
function paginationLogic() {
    document.addEventListener('click', function(e) {
        // Paginación de usuarios
        const userPagBtn = e.target.closest('.user-pagination-button a');
        if (userPagBtn) {
            e.preventDefault();
            fetchPaginatedContent(userPagBtn.href, 'usuarios-list-container');
            return;
        }
        // Paginación de juegos
        const gamesPagBtn = e.target.closest('.games-pagination-button a');
        if (gamesPagBtn) {
            e.preventDefault();
            fetchPaginatedContent(gamesPagBtn.href, 'games-list-container');
            return;
        }
        // Paginación de categorías
        const catPagBtn = e.target.closest('.cat-pagination-button a');
        if (catPagBtn) {
            e.preventDefault();
            fetchPaginatedContent(catPagBtn.href, 'categorias-list-container');
            return;
        }
    });

    // Función para cargar contenido paginado
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

            // Re-bindeamos el boton solo si es la seccion de juegos
            if (containerId === 'games-list-container') {
                bindAddGameBtn();
            }
        });
    }

    // Manejar el popstate (navegación con el botón atrás/adelante)
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.section) {
            // Aquí deberías recargar el contenido de la sección usando AJAX si es necesario
            // Por simplicidad, recargamos la página
            window.location.reload();
        }
    });
}
