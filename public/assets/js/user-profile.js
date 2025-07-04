document.addEventListener('DOMContentLoaded', function() {
    // ====================
    // FUNCIONALIDAD PARA CAMBIAR ENTRE SECCIONES DEL PERFIL
    // ====================
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');

    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            const sectionName = this.getAttribute('data-section');
            
            // Remover clase active de todos los elementos del menú
            menuItems.forEach(menuItem => {
                menuItem.classList.remove('active');
            });
            
            // Agregar clase active al elemento clickeado
            this.classList.add('active');
            
            // Ocultar todas las secciones
            contentSections.forEach(section => {
                section.classList.remove('active');
            });
            
            // Mostrar la sección correspondiente
            const targetSection = document.getElementById(sectionName + '-section');
            if (targetSection) {
                targetSection.classList.add('active');
            }
        });
    });

    // ====================
    // FUNCIONALIDAD PARA CAMBIAR IMAGEN DE PERFIL DEL USUARIO
    // ====================
    const changeProfileBtn = document.getElementById('userChangeProfileBtn');
    const profileImageInput = document.getElementById('userProfileImageInput');
    const profileImageForm = document.getElementById('userProfileImageForm');
    const currentProfileImage = document.getElementById('userCurrentProfileImage');

    if (changeProfileBtn && profileImageInput) {
        changeProfileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            profileImageInput.click();
        });

        profileImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Previsualizar la imagen antes de subirla
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (currentProfileImage) {
                        currentProfileImage.src = e.target.result;
                    }
                };
                reader.readAsDataURL(this.files[0]);

                // Subir la imagen automáticamente
                if (profileImageForm) {
                    const formData = new FormData(profileImageForm);
                    
                    fetch(profileImageForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Imagen actualizada correctamente');
                            // Opcional: mostrar mensaje de éxito
                        } else if (data.error) {
                            alert(data.error);
                            location.reload();
                        }
                    })
                    .catch(() => {
                        alert('Error al subir la imagen');
                        location.reload();
                    });
                }
            }
        });
    }

    // ====================
    // FORMULARIO DE ACTUALIZACIÓN DE PERFIL
    // ====================
    const form = document.querySelector('.profile-info-container form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Permitir envío normal del formulario (sin AJAX) 
            // para que se recargue la página y se actualice el header de bienvenida
            console.log('Enviando formulario de perfil con recarga de página');
            return true; // Permitir envío normal del formulario
        });
    }

    // ====================
    // AGREGAR/QUITAR JUEGOS DE WISHLIST (DESDE SECCIÓN GAMES)
    // ====================
    document.querySelectorAll('.games-add-wishlist').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const icon = this.querySelector('i');
            const isInWishlist = icon.classList.contains('bi-bookmark-check-fill');
            const url = isInWishlist ? '/remove-from-wishlist' : '/add-to-wishlist';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ game_id: gameId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (isInWishlist) {
                        icon.classList.remove('bi-bookmark-check-fill');
                        icon.classList.add('bi-bookmark');
                    } else {
                        icon.classList.remove('bi-bookmark');
                        icon.classList.add('bi-bookmark-check-fill');
                    }
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(() => {
                alert('Error de conexión');
            });
        });
    });

    // ====================
    // AGREGAR/QUITAR JUEGOS DE WISHLIST (DESDE GAME-SECTION)
    // ====================
    document.querySelectorAll('.game-section-add-wishlist').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const icon = this.querySelector('i');
            const isInWishlist = icon.classList.contains('bi-bookmark-check-fill');
            const url = isInWishlist ? '/remove-from-wishlist' : '/add-to-wishlist';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ game_id: gameId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (isInWishlist) {
                        icon.classList.remove('bi-bookmark-check-fill');
                        icon.classList.add('bi-bookmark');
                    } else {
                        icon.classList.remove('bi-bookmark');
                        icon.classList.add('bi-bookmark-check-fill');
                    }
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(() => {
                alert('Error de conexión');
            });
        });
    });

    // ====================
    // AGREGAR/QUITAR JUEGOS DE WISHLIST (DESDE PRÓXIMOS LANZAMIENTOS)
    // ====================
    document.querySelectorAll('.proxLanzamientos-wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const icon = this.querySelector('i');
            const isInWishlist = icon.classList.contains('bi-heart-fill');
            const url = isInWishlist ? '/remove-from-wishlist' : '/add-to-wishlist';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ game_id: gameId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (isInWishlist) {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    } else {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    }
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(() => {
                alert('Error de conexión');
            });
        });
    });

    // ====================
    // QUITAR JUEGOS DE WISHLIST (DESDE PERFIL DE USUARIO)
    // ====================
    document.querySelectorAll('.remove-wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const item = this.closest('.wishlist-item');

            fetch('/remove-from-wishlist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ game_id: gameId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (item) item.remove();
                    
                    // Verificar si ya no hay más elementos en la wishlist
                    const remainingItems = document.querySelectorAll('.wishlist-item');
                    if (remainingItems.length === 0) {
                        const container = document.querySelector('.wishlist-container');
                        if (container) {
                            container.innerHTML = `
                                <div class="empty-state">
                                    <i class="bi bi-heart"></i>
                                    <p>Tu lista de deseados está vacía</p>
                                    <a href="${window.baseUrl}todos" class="browse-btn">Descubrir juegos</a>
                                </div>
                            `;
                        }
                    }
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(() => {
                alert('Error de conexión');
            });
        });
    });

    // ====================
    // AGREGAR AL CARRITO DESDE PERFIL DE USUARIO
    // ====================
    document.querySelectorAll('.add-to-cart-btn-profile').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const icon = this.querySelector('i');
            const textSpan = this.querySelector('.cart-btn-text');
            const isInCart = icon.classList.contains('bi-cart-check-fill');

            if (!isInCart) {
                fetch('/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ game_id: gameId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        icon.classList.remove('bi-cart-plus');
                        icon.classList.add('bi-cart-check-fill');
                        if (textSpan) textSpan.textContent = 'En el carrito';
                        
                        // Actualizar contador del carrito si existe
                        const cartCount = document.querySelector('.cart-count');
                        if (cartCount && data.cartCount) {
                            cartCount.textContent = data.cartCount;
                        }
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch(() => {
                    alert('Error de conexión');
                });
            }
        });
    });
});