<!-- Header del proceso de pago -->
<header class="checkout-header">
    <div class="cart-container">
        <div class="checkout-steps">
            <div class="step completed">
                <span><i class="bi bi-check"></i></span>
                <p>Carrito</p>
            </div>
            <div class="step active">
                <span>2</span>
                <p>Pago</p>
            </div>
            <div class="step">
                <span>3</span>
                <p>Confirmacion</p>
            </div>
        </div>
    </div>
</header>

<?php if (session('error-msg')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('error-msg') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Contenedor principal de pago -->
<form action="<?= base_url('cart/completarCompra') ?>" method="post" id="payment-form">
    <main class="payment-container">
        <div class="cart-container">
            <h1 class="pago-titulo">Método de Pago</h1>

            <div class="payment-grid">
                <!-- Formulario de pago -->
                <section class="payment-form">
                    <div class="form-section">
                        <h2><i class="bi bi-credit-card"></i> Información de Pago</h2>

                        <div class="payment-methods">
                            <div class="method active" data-method="credit">
                                <i class="bi bi-credit-card-2-front"></i>
                                <span>Tarjeta de Crédito</span>
                            </div>
                        </div>

                        <!-- Formulario de tarjeta de crédito (visible por defecto) -->
                        <div class="payment-method-content active" id="credit-method">
                            <div class="form-group">
                                <label for="card-number">Número de Tarjeta</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-credit-card"></i>
                                    <input type="text" id="card-number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                                <div class="card-icons">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/MasterCard_early_1990s_logo.png" alt="Mastercard">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card-name">Nombre en la Tarjeta</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-person"></i>
                                        <input type="text" id="card-name" name="card_name" placeholder="Como aparece en la tarjeta">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="card-cvv">CVV</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-lock"></i>
                                        <input type="text" id="card-cvv" name="card_cvv" placeholder="123" maxlength="4">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card-expiry">Fecha de Expiración</label>
                                    <div class="input-with-icon">
                                        <i class="bi bi-calendar"></i>
                                        <input type="text" id="card-expiry" name="card_expiry" placeholder="MM/AA" maxlength="5">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2><i class="bi bi-geo-alt"></i> Dirección de Facturación</h2>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="billing-name">Nombre Completo</label>
                                    <input type="text" id="billing-name" name="nombre_completo" placeholder="John Carmack">
                                </div>

                                <div class="form-group">
                                    <label for="billing-dni">DNI del Comprador</label>
                                    <input type="text" id="billing-dni" name="dni" placeholder="33412512">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="billing-address">Dirección</label>
                                <input type="text" id="billing-address" name="direccion" placeholder="Calle y número">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="billing-city">Ciudad</label>
                                    <input type="text" id="billing-city" name="ciudad" placeholder="Ciudad">
                                </div>
                                <div class="form-group">
                                    <label for="billing-zip">Código Postal</label>
                                    <input type="text" id="billing-zip" name="codigo_postal" placeholder="Código Postal">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="billing-country">País</label>
                                    <select id="billing-country" name="pais">
                                        <option value="">Seleccione país</option>
                                        <option value="AR" selected>Argentina</option>
                                        <option value="MX">México</option>
                                        <option value="ES">España</option>
                                        <option value="CL">Chile</option>
                                        <option value="BR">Brasil</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="billing-state">Provincia/Estado</label>
                                    <input type="text" id="billing-state" name="provincia" placeholder="Corrientes...">
                                </div>
                            </div>

                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="save-address" name="save_address" checked>
                                <label for="save-address">Guardar esta dirección para futuras compras</label>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2><i class="bi bi-envelope"></i> Información de Contacto</h2>

                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-phone"></i>
                                    <input type="tel" id="phone" name="telefono" placeholder="+54 11 1234 5678">
                                </div>
                            </div>
                        </div>
                </section>

                <!-- Resumen del pedido -->
                <aside class="order-summary">
                    <div class="summary-card">
                        <h2>Resumen del Pedido</h2>

                        <div class="order-items">
                            <?php foreach ($items as $item): ?>
                                <div class="order-item">
                                    <div class="item-info">
                                        <span class="item-name"><?= esc($item['juego']['title']) ?></span>
                                        <span class="item-platform"><?= esc($item['juego']['platform'] ?? 'PC') ?></span>
                                    </div>
                                    <span class="item-price">
                                        $<?= number_format($item['juego']['special_price'] ?? $item['juego']['price'], 2) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php
                        $subtotal = 0;
                        foreach ($items as $item) {
                            $precio = $item['juego']['special_price'] ?? $item['juego']['price'];
                            $subtotal += $precio;
                        }
                        ?>

                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Subtotal (<?= count($items) ?> productos)</span>
                                <span class="subtotal">$<?= number_format($subtotal, 2) ?></span>
                            </div>
                            <div class="summary-total">
                                <span>Total</span>
                                <span class="total-price">$<?= number_format($subtotal, 2) ?></span>
                            </div>
                        </div>

                        <div class="secure-checkout">
                            <i class="bi bi-shield-lock"></i>
                            <span>Compra 100% segura - Pagos cifrados</span>
                        </div>
                    </div>

                    <div class="support-info">
                        <h3><i class="bi bi-headset"></i> Soporte 24/7</h3>
                        <p>¿Necesitas ayuda con tu compra?</p>
                        <p><i class="bi bi-whatsapp"></i> +54 9 3794 148344</p>
                        <p><i class="bi bi-envelope"></i> kings&wastelands@gmail.com</p>
                    </div>

                    <button type="submit" class="finalBtn" id="complete-purchase">
                        <i class="bi bi-lock"></i> Completar Compra
                    </button>
                </aside>
            </div>
        </div>
    </main>
</form>