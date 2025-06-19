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
                <p>Confirmación</p>
            </div>
        </div>
    </div>
</header>

<!-- Contenedor principal de pago -->
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
                        <div class="method" data-method="paypal">
                            <i class="bi bi-paypal"></i>
                            <span>PayPal</span>
                        </div>
                        <div class="method" data-method="crypto">
                            <i class="bi bi-currency-bitcoin"></i>
                            <span>Criptomonedas</span>
                        </div>
                    </div>

                    <!-- Formulario de tarjeta de crédito (visible por defecto) -->
                    <div class="payment-method-content active" id="credit-method">
                        <div class="form-group">
                            <label for="card-number">Número de Tarjeta</label>
                            <div class="input-with-icon">
                                <i class="bi bi-credit-card"></i>
                                <input type="text" id="card-number" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>
                            <div class="card-icons">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg" alt="Visa">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg" alt="Mastercard">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg" alt="Apple Pay">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="card-name">Nombre en la Tarjeta</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-person"></i>
                                    <input type="text" id="card-name" placeholder="Como aparece en la tarjeta">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card-cvv">CVV</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-lock"></i>
                                    <input type="text" id="card-cvv" placeholder="123" maxlength="4">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="card-expiry">Fecha de Expiración</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-calendar"></i>
                                    <input type="text" id="card-expiry" placeholder="MM/AA" maxlength="5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card-installments">Cuotas</label>
                                <select id="card-installments">
                                    <option value="">Seleccione cuotas</option>
                                    <option value="1">1 cuota de $99.97</option>
                                    <option value="3">3 cuotas de $33.32</option>
                                    <option value="6">6 cuotas de $16.66</option>
                                    <option value="12">12 cuotas de $8.33</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Método PayPal (oculto por defecto) -->
                    <div class="payment-method-content" id="paypal-method">
                        <div class="paypal-info">
                            <i class="bi bi-paypal"></i>
                            <p>Serás redirigido a PayPal para completar tu pago de manera segura.</p>
                            <button class="paypal-btn">Pagar con PayPal</button>
                        </div>
                    </div>

                    <!-- Método Criptomonedas (oculto por defecto) -->
                    <div class="payment-method-content" id="crypto-method">
                        <div class="crypto-info">
                            <i class="bi bi-currency-bitcoin"></i>
                            <p>Selecciona tu criptomoneda preferida para completar el pago.</p>
                            <div class="crypto-options">
                                <div class="crypto-option">
                                    <img src="https://cryptologos.cc/logos/bitcoin-btc-logo.png" alt="Bitcoin">
                                    <span>Bitcoin</span>
                                </div>
                                <div class="crypto-option">
                                    <img src="https://cryptologos.cc/logos/ethereum-eth-logo.png" alt="Ethereum">
                                    <span>Ethereum</span>
                                </div>
                                <div class="crypto-option">
                                    <img src="https://cryptologos.cc/logos/usd-coin-usdc-logo.png" alt="USDC">
                                    <span>USDC</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="bi bi-geo-alt"></i> Dirección de Facturación</h2>

                    <div class="form-group">
                        <label for="billing-address">Dirección</label>
                        <input type="text" id="billing-address" placeholder="Calle y número">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="billing-city">Ciudad</label>
                            <input type="text" id="billing-city" placeholder="Ciudad">
                        </div>
                        <div class="form-group">
                            <label for="billing-zip">Código Postal</label>
                            <input type="text" id="billing-zip" placeholder="Código Postal">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="billing-country">País</label>
                            <select id="billing-country">
                                <option value="">Seleccione país</option>
                                <option value="AR" selected>Argentina</option>
                                <option value="MX">México</option>
                                <option value="ES">España</option>
                                <option value="US">Estados Unidos</option>
                                <option value="CO">Colombia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="billing-state">Provincia/Estado</label>
                            <select id="billing-state">
                                <option value="">Seleccione provincia</option>
                                <option value="BA">Buenos Aires</option>
                                <option value="CBA">Córdoba</option>
                                <option value="SF">Santa Fe</option>
                                <option value="MZ">Mendoza</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="save-address" checked>
                        <label for="save-address">Guardar esta dirección para futuras compras</label>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="bi bi-envelope"></i> Información de Contacto</h2>

                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-with-icon">
                            <i class="bi bi-envelope"></i>
                            <input type="email" id="email" placeholder="tucorreo@ejemplo.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <div class="input-with-icon">
                            <i class="bi bi-phone"></i>
                            <input type="tel" id="phone" placeholder="+54 11 1234 5678">
                        </div>
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="receive-offers" checked>
                        <label for="receive-offers">Recibir ofertas especiales y novedades</label>
                    </div>
                </div>
            </section>

            <!-- Resumen del pedido -->
            <aside class="order-summary">
                <div class="summary-card">
                    <h2>Resumen del Pedido</h2>

                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-info">
                                <span class="item-name">Cyberpunk 2077: Phantom Liberty</span>
                                <span class="item-platform">PC</span>
                            </div>
                            <span class="item-price">$39.99</span>
                        </div>

                        <div class="order-item">
                            <div class="item-info">
                                <span class="item-name">Elden Ring</span>
                                <span class="item-platform">PS5</span>
                            </div>
                            <span class="item-price">$34.99 × 2</span>
                        </div>

                        <div class="order-item">
                            <div class="item-info">
                                <span class="item-name">God of War: Ragnarök</span>
                                <span class="item-platform">PS5</span>
                            </div>
                            <span class="item-price">$49.99</span>
                        </div>
                    </div>

                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal (3 productos)</span>
                            <span class="subtotal">$124.97</span>
                        </div>
                        <div class="summary-row">
                            <span>Envío</span>
                            <span class="shipping">$0.00</span>
                        </div>
                        <div class="summary-row discount">
                            <span>Descuento</span>
                            <span class="discount-amount">-$25.00</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span class="total-price">$99.97</span>
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

                <button class="finalBtn" id="complete-purchase">
                    <i class="bi bi-lock"></i> Completar Compra
                </button>
            </aside>
        </div>
    </div>
</main>