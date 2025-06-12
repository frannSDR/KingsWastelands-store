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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const icon = this.querySelector('i');

            fetch('/add-to-wishlist', {
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
                    // Cambia el icono a "bookmark-check-fill"
                    icon.classList.remove('bi-bookmark');
                    icon.classList.add('bi-bookmark-check-fill');
                    // Opcional: deshabilita el botón para evitar duplicados
                    btn.disabled = true;
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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-wish').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const icon = this.querySelector('i');

            fetch('/add-to-wishlist', {
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
                    // Cambia el icono a "bookmark-check-fill"
                    icon.classList.remove('bi-bookmark');
                    icon.classList.add('bi-bookmark-check-fill');
                    // Opcional: deshabilita el botón para evitar duplicados
                    btn.disabled = true;
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