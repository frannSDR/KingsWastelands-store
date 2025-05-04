<!-- header del carrito -->
<header class="checkout-header">
    <div class="cart-container">
        <div class="checkout-steps">
            <div class="step active">
                <span>1</span>
                <p>Carrito</p>
            </div>
            <div class="step">
                <span>2</span>
                <p>Pago</p>
            </div>
        </div>
    </div>
</header>

<!-- contenedor principal -->
<main class="checkout-container">
    <div class="cart-container">
        <h1>Carrito de Compras</h1>

        <div class="checkout-grid">
            <!-- seccion de productos -->
            <section class="cart-products">
                <div class="cart-header2">
                    <h2>Productos ( <span class="items-count">0</span> )</h2>
                </div>

                <div class="cart-items-list">
                    <!-- aca se van a cargar los items por js -->
                    <div class="empty-cart-message2">
                        <i class="bi bi-cart-x"></i>
                        <p>Tu carrito está vacío</p>
                        <a class="continue-shopping2">Seguir comprando</a>
                    </div>
                </div>
            </section>

            <!-- resumen de compra -->
            <aside class="order-summary">
                <div class="summary-card">
                    <h2>Resumen de Compra</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="subtotal">$0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Envío</span>
                            <span class="shipping">$0.00</span>
                        </div>
                        <div class="summary-row discount">
                            <span>Descuento</span>
                            <span class="discount-amount">-$0.00</span>
                        </div>
                        <div class="promo-code">
                            <input type="text" placeholder="Código promocional">
                            <button class="apply-btn">Aplicar</button>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span class="total-price2">$0.00</span>
                        </div>
                    </div>
                    <button class="checkout-btn">Proceder al Pago</button>

                    <div class="secure-checkout">
                        <i class="bi bi-shield-lock"></i>
                        <span>Compra segura</span>
                    </div>
                </div>
                <!-- soporte y ayuda -->
                <div class="support-info">
                    <h3>¿Necesitas ayuda?</h3>
                    <p><i class="bi bi-telephone"></i> +54 379 4148344</p>
                    <p><i class="bi bi-envelope"></i> kings&wastelands@gmail.com</p>
                </div>
            </aside>
        </div>
    </div>
</main>