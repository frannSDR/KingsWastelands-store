//! agregar/quitar un juego del carrito de la seccion game-section

document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    if (!addToCartBtn) return;

    const icon = addToCartBtn.querySelector('i');
    const textSpan = addToCartBtn.querySelector('.cart-btn-text');

    addToCartBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const inCart = icon.classList.contains('bi-cart-check-fill');
        const url = inCart ? window.baseUrl + 'cart/remove' : window.baseUrl + 'cart/add';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                game_id: window.gameId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (inCart) {
                    icon.classList.remove('bi-cart-check-fill');
                    icon.classList.add('bi-cart-plus');
                    textSpan.textContent = 'Añadir al carrito';
                } else {
                    icon.classList.remove('bi-cart-plus');
                    icon.classList.add('bi-cart-check-fill');
                    textSpan.textContent = 'En el carrito';
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

//! agregar/quitar un juego del carrito en la seccion de ofertas (home)

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.oferta-button.add-to-cart-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = btn.getAttribute('data-game-id');
            const icon = btn.querySelector('i');
            const textSpan = btn.querySelector('.cart-btn-text');
            const inCart = icon.classList.contains('bi-cart-check-fill');
            const url = inCart ? window.baseUrl + 'cart/remove' : window.baseUrl + 'cart/add';

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
                    if (inCart) {
                        icon.classList.remove('bi-cart-check-fill');
                        icon.classList.add('bi-cart-plus');
                        textSpan.textContent = 'Añadir al carrito';
                    } else {
                        icon.classList.remove('bi-cart-plus');
                        icon.classList.add('bi-cart-check-fill');
                        textSpan.textContent = 'En el carrito';
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

//! agregar/quitar un juego del carrito de la seccion ofertas

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.buy-now-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = btn.getAttribute('data-game-id');
            const icon = btn.querySelector('i');
            const textSpan = btn.querySelector('.cart-btn-text');
            const inCart = icon.classList.contains('bi-cart-fill');
            const url = inCart ? window.baseUrl + 'cart/remove' : window.baseUrl + 'cart/add';

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
                    if (inCart) {
                        icon.classList.remove('bi-cart-fill');
                        icon.classList.add('bi-cart');
                        textSpan.textContent = 'Añadir al carrito';
                    } else {
                        icon.classList.remove('bi-cart');
                        icon.classList.add('bi-cart-fill');
                        textSpan.textContent = 'En el carrito';
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

//! agregar/quitar un juego del carrito de la seccion de proximos lanzamientos del home

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.notify-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = btn.getAttribute('data-game-id');
            const icon = btn.querySelector('i');
            const textSpan = btn.querySelector('.cart-btn-text');
            const inCart = icon.classList.contains('bi-cart-fill');
            const url = inCart ? window.baseUrl + 'cart/remove' : window.baseUrl + 'cart/add';

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
                    if (inCart) {
                        icon.classList.remove('bi-cart-fill');
                        icon.classList.add('bi-cart');
                        textSpan.textContent = 'Reservar';
                    } else {
                        icon.classList.remove('bi-cart');
                        icon.classList.add('bi-cart-fill');
                        textSpan.textContent = 'En el carrito';
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

//! agregar/quitar un juego del carrito de la seccion de proximos lanzamientos 

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.upcoming-preorder-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = btn.getAttribute('data-game-id');
            const icon = btn.querySelector('i');
            const textSpan = btn.querySelector('.cart-btn-text');
            const inCart = icon.classList.contains('bi-cart-fill');
            const url = inCart ? window.baseUrl + 'cart/remove' : window.baseUrl + 'cart/add';

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
                    if (inCart) {
                        icon.classList.remove('bi-cart-fill');
                        icon.classList.add('bi-cart');
                        textSpan.textContent = 'Reservar Ahora';
                    } else {
                        icon.classList.remove('bi-cart');
                        icon.classList.add('bi-cart-fill');
                        textSpan.textContent = 'En el carrito';
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

//! agregar/quitar un juego del carrito de la seccion de juegos

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn2.btn-primary2[data-game-id]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = btn.getAttribute('data-game-id');
            const icon = btn.querySelector('i');
            const textSpan = btn.querySelector('.cart-btn-text');
            const inCart = icon.classList.contains('bi-cart-fill');
            const url = inCart ? window.baseUrl + 'cart/remove' : window.baseUrl + 'cart/add';

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
                    if (inCart) {
                        icon.classList.remove('bi-cart-fill');
                        icon.classList.add('bi-cart');
                        textSpan.textContent = 'Añadir al carrito';
                    } else {
                        icon.classList.remove('bi-cart');
                        icon.classList.add('bi-cart-fill');
                        textSpan.textContent = 'En el carrito';
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

//! agregar/quitar un juego de la seccion de deseados del usuario

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart-btn-profile').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = btn.getAttribute('data-game-id');
            const icon = btn.querySelector('i');
            const textSpan = btn.querySelector('.cart-btn-text');
            const inCart = icon.classList.contains('bi-cart-check-fill');
            const url = inCart ? window.baseUrl + 'cart/remove' : window.baseUrl + 'cart/add';

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
                    if (inCart) {
                        icon.classList.remove('bi-cart-check-fill');
                        icon.classList.add('bi-cart-plus');
                        textSpan.textContent = 'Añadir al carrito';
                    } else {
                        icon.classList.remove('bi-cart-plus');
                        icon.classList.add('bi-cart-check-fill');
                        textSpan.textContent = 'En el carrito';
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

//! quitar un juego de la seccion carrito

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

//! verifica que haya elementos en el carrito para redirigir a la seccion de pago

document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (!checkoutBtn) return;

    checkoutBtn.addEventListener('click', function(e) {
        // Verifica si hay productos en el carrito
        const itemsCount = parseInt(document.querySelector('.items-count').textContent, 10);
        if (itemsCount === 0) {
            e.preventDefault();
            alert('Tu carrito está vacío.');
            return false;
        }
        // Redirige a la página de pago
        window.location.href = window.baseUrl + 'pago';
    });
});