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
            <div class="step">
                <span>3</span>
                <p>Confirmación</p>
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
                    <h2>Productos (<span class="items-count"><?= count($items) ?></span>)</h2>
                    <form action="<?= base_url('cart/clear') ?>" method="post" style="display:inline;">
                        <button type="submit" class="clear-cart-btn">Vaciar carrito</button>
                    </form>
                </div>

                <div class="cart-items-list">
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <div class="cart-item2">
                                <div class="item-image2">
                                    <img src="<?= $item['juego']['cover_image_url'] ?>" alt="Portada de <?= $item['juego']['title'] ?>">
                                </div>
                                <div class="item-details2">
                                    <div class="item-info">
                                        <h3><?= esc($item['juego']['title']) ?></h3>
                                        <span class="item-platform">PC</span>
                                        <div class="item-price2">
                                            <?php if ($item['juego']['special_price'] != 0): ?>
                                                <span class="discounted-price">$<?= number_format($item['juego']['special_price'], 2) ?></span>
                                            <?php else: ?>
                                                <span class="discounted-price">$<?= number_format($item['juego']['price'], 2) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <button class="remove-item2" data-game-id="<?= $item['game_id'] ?>">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="empty-cart-message2">
                    <i class="bi bi-cart-x"></i>
                    <p>Tu carrito está vacío</p>
                    <a href="#" class="continue-shopping2">Seguir comprando</a>
                </div>
            </section>

            <?php
            // Calcula el subtotal sumando el special_price si existe, si no el price
            $subtotal = 0;
            foreach ($items as $item) {
                $precio = (!empty($item['juego']['special_price']) && $item['juego']['special_price'] != 0)
                    ? $item['juego']['special_price']
                    : $item['juego']['price'];
                $subtotal += $precio;
            }
            ?>

            <!-- resumen de compra -->
            <aside class="order-summary">
                <div class="summary-card">
                    <h2>Resumen de Compra</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal (<?= count($items) ?> productos)</span>
                            <span class="subtotal">$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Envío</span>
                            <span class="shipping">$0.00</span>
                        </div>
                        <div class="summary-row discount">
                            <span>Descuento</span>
                            <span class="discount-amount">-$25.00</span>
                        </div>
                        <div class="promo-code">
                            <input type="text" placeholder="Código promocional">
                            <button class="apply-btn">Aplicar</button>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span class="total-price2">$<?= number_format($subtotal, 2) ?></span>
                        </div>
                    </div>
                    <button class="checkout-btn">Proceder al Pago</button>

                    <div class="secure-checkout">
                        <i class="bi bi-shield-lock"></i>
                        <span>Compra segura - Pago 100% protegido</span>
                    </div>
                </div>
                <!-- soporte y ayuda -->
                <div class="support-info">
                    <h3>¿Necesitas ayuda?</h3>
                    <p><i class="bi bi-telephone"></i> +54 379 4148344</p>
                    <p><i class="bi bi-envelope"></i> kings&wastelands@gmail.com</p>
                    <p><i class="bi bi-clock"></i> Soporte 24/7</p>
                </div>
            </aside>
        </div>
    </div>
</main>