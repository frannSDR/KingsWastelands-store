<!-- carrito -->
<div class="cart-sidebar">
    <div class="cart-header">
        <h2>Carrito de Compras</h2>
        <button class="close-cart"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="cart-items">
        <!-- los items del carrito se añaden aca de manera dinamica por el js -->
    </div>

    <!-- footer del carrito -->
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total</span>
            <span class="total-price">$60</span>
        </div>
        <button class="buy-now-btn">Comprar</button>
    </div>

    <!-- mensaje de carrito vacio -->
    <div class="empty-cart-message">
        <i class="bi bi-cart-x"></i>
        <p>Tu carrito esta vacio</p>
        <a href="<?php echo base_url('/populares') ?>" class="continue-shopping">Seguir comprando</a>
    </div>
</div>

<!-- fondo del carrito de compras -->
<div class="cart-overlay"></div>