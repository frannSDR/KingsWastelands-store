document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-item2').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            fetch(window.baseUrl + 'cart/remove', {
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
                    // Elimina el item del DOM
                    btn.closest('.cart-item2').remove();
                    // Opcional: recarga si el carrito queda vacío
                    if (document.querySelectorAll('.cart-item2').length === 0) {
                        location.reload();
                    }
                } else {
                    alert(data.error || 'Error al eliminar el item');
                }
            })
            .catch(() => alert('Error de conexión'));
        });
    });
});