document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.profile-info-container form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Limpiar mensajes previos
        document.querySelectorAll('.alert').forEach(el => el.remove());

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Mensaje de éxito
                const success = document.createElement('div');
                success.className = 'alert alert-success';
                success.textContent = data.message;
                form.prepend(success);

                // Opcional: actualiza los campos en la página si es necesario
            } else if (data.errors) {
                // Mostrar errores de validación
                for (const campo in data.errors) {
                    const error = document.createElement('div');
                    error.className = 'alert alert-danger';
                    error.textContent = data.errors[campo];
                    form.prepend(error);
                }
            } else if (data.error) {
                // Otro error
                const error = document.createElement('div');
                error.className = 'alert alert-danger';
                error.textContent = data.error;
                form.prepend(error);
            }
        })
        .catch(() => {
            const error = document.createElement('div');
            error.className = 'alert alert-danger';
            error.textContent = 'Error de conexión.';
            form.prepend(error);
        });
    });
});

// quitar agregar un juego desde la seccion games
document.addEventListener('DOMContentLoaded', function() {
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
});

// agregar/quitar un juego de la lista de deseados de game-section
document.addEventListener('DOMContentLoaded', function() {
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
});

// agregar/quitar un juego de la lista de deseados de proximos lanzamientos (home)
document.addEventListener('DOMContentLoaded', function() {
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
});

// quitar un juego de la lista de deseados
document.addEventListener('DOMContentLoaded', function() {
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
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(() => {
                alert('Error de conexión');
            });
        });
    });
});