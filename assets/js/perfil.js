function bindAddGameBtn() {
    const addGameBtn = document.getElementById('addGameBtn');
    const gameFormContainer = document.getElementById('game-form-container');
    const gameTableContainer = document.getElementById('adminTable');
    const paginationContainer = document.getElementById('gamesPagination-container');

    if (addGameBtn && gameFormContainer && gameTableContainer) {
        addGameBtn.onclick = function () {
            const formVisible = gameFormContainer.style.display === 'block';

            gameFormContainer.style.transition = 'opacity 0.4s';
            gameTableContainer.style.transition = 'opacity 0.4s';
            if (paginationContainer) paginationContainer.style.transition = 'opacity 0.4s';

            if (!formVisible) {
                gameFormContainer.style.display = 'block';
                gameFormContainer.style.opacity = 0;
                setTimeout(() => {
                    gameFormContainer.style.opacity = 1;
                }, 10);

                gameTableContainer.style.opacity = 1;
                setTimeout(() => {
                    gameTableContainer.style.opacity = 0;
                    setTimeout(() => {
                        gameTableContainer.style.display = 'none';
                    }, 400);
                }, 10);

                // Ocultar paginación
                if (paginationContainer) {
                    paginationContainer.style.opacity = 1;
                    setTimeout(() => {
                        paginationContainer.style.opacity = 0;
                        setTimeout(() => {
                            paginationContainer.style.display = 'none';
                        }, 400);
                    }, 10);
                }
            } else {
                gameFormContainer.style.opacity = 1;
                setTimeout(() => {
                    gameFormContainer.style.opacity = 0;
                    setTimeout(() => {
                        gameFormContainer.style.display = 'none';
                    }, 400);
                }, 10);

                gameTableContainer.style.display = 'block';
                gameTableContainer.style.opacity = 0;
                setTimeout(() => {
                    gameTableContainer.style.opacity = 1;
                }, 10);

                // Mostrar paginación
                if (paginationContainer) {
                    paginationContainer.style.display = 'flex';
                    paginationContainer.style.opacity = 0;
                    setTimeout(() => {
                        paginationContainer.style.opacity = 1;
                    }, 10);
                }
            }
        };
    }
}

// JavaScript para gestion 
document.addEventListener('DOMContentLoaded', function() {
    
    bindAddGameBtn(); // Función para bindear el botón de añadir juego

    // Cambiar entre secciones
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remover active de todos
            menuItems.forEach(i => i.classList.remove('active'));
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            
            // Activar el seleccionado
            this.classList.add('active');
            const sectionId = this.getAttribute('data-section') + '-section';
            document.getElementById(sectionId).classList.add('active');
        });
    });

    // Tabs de requisitos
    const tabBtns = document.querySelectorAll('.tab-btn');
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remover active de todos
            tabBtns.forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            
            // Activar el seleccionado
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Validación básica del formulario de juegos
    const form = document.getElementById('upload-game-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const categories = document.querySelectorAll('input[name="category"]:checked');
            if (categories.length === 0) {
                alert('Selecciona al menos una categoría');
                return;
            }
            alert('Formulario validado correctamente (simulación)');
            // form.submit(); // Descomentar cuando integres backend
        });
    }

    // Búsqueda en tiempo real
    const searchInput = document.getElementById('user-search');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.users-admin-table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    
    // Botones de acción
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            // Lógica para editar usuario
        });
    });
    
    // Manejar la paginación
    document.addEventListener('click', function(e) {
        // Paginación de usuarios
        if (e.target.closest('.user-pagination-button a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;
            fetchPaginatedContent(url, 'usuarios-list-container');
        }
        
        // Paginación de juegos
        if (e.target.closest('.games-pagination-button a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;
            fetchPaginatedContent(url, 'games-list-container');
        }
        
        // Paginación de categorías
        if (e.target.closest('.cat-pagination-button a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;
            fetchPaginatedContent(url, 'categorias-list-container');
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
            document.getElementById(containerId).innerHTML = html;
            history.pushState(null, null, url);
        });
    }

    // Manejar el popstate (navegación con el botón atrás/adelante)
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.section) {
            loadSectionContent(event.state.section);
        } else {
            window.location.reload();
        }
    });

    const addCategoryBtn = document.getElementById('add-category-btn');
    const categoryFormContainer = document.getElementById('category-form-container');
    const cancelCategoryBtn = document.getElementById('cancel-category');
    const deleteModal = document.getElementById('delete-category-modal');
    
    // Mostrar/ocultar formulario
    addCategoryBtn.addEventListener('click', function() {
        categoryFormContainer.style.display = 'block';
        document.getElementById('category-form').reset();
        document.getElementById('category-id').value = '';
        document.getElementById('category-submit-text').textContent = 'Guardar';
    });
    
    cancelCategoryBtn.addEventListener('click', function() {
        categoryFormContainer.style.display = 'none';
    });
    
    // Preview del icono
    document.getElementById('category-icon').addEventListener('input', function() {
        const iconPreview = document.getElementById('icon-preview');
        const iconClass = this.value.trim() ? 'bi-' + this.value.trim() : 'bi-question-circle';
        iconPreview.className = 'bi ' + iconClass;
    });
    
    // Botones de editar
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            // Aquí iría la lógica para cargar los datos de la categoría
            categoryFormContainer.style.display = 'block';
            document.getElementById('category-submit-text').textContent = 'Actualizar';
            
            // Ejemplo con datos estáticos:
            if (categoryId === '1') {
                document.getElementById('category-id').value = '1';
                document.getElementById('category-name').value = 'RPG';
                document.getElementById('category-slug').value = 'juegos-rpg';
                document.getElementById('category-icon').value = 'dice-5';
                document.getElementById('icon-preview').className = 'bi bi-dice-5';
            }
        });
    });
    
    // Botones de eliminar
    document.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            const categoryName = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            
            document.getElementById('category-to-delete').textContent = categoryName;
            deleteModal.style.display = 'flex';
            
            // Configurar acción de eliminación
            document.getElementById('confirm-delete').onclick = function() {
                // Aquí iría la lógica AJAX para eliminar
                console.log('Eliminar categoría ID:', categoryId);
                deleteModal.style.display = 'none';
                // Recargar o eliminar la fila
            };
        });
    });
    
    // Cerrar modal
    document.getElementById('cancel-delete').addEventListener('click', function() {
        deleteModal.style.display = 'none';
    });
    
    // Enviar formulario
    document.getElementById('category-form').addEventListener('submit', function(e) {
        e.preventDefault();
        // Aquí iría la lógica AJAX para guardar
        console.log('Formulario enviado:', {
            id: this.category_id.value,
            name: this.name.value,
            slug: this.slug.value,
            icon: this.icon.value
        });
        
        // Simular éxito
        categoryFormContainer.style.display = 'none';
        alert('¡Categoría guardada con éxito!');
    });
});