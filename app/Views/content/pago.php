<header class="checkout-header">
    <div class="cart-container">
        <div class="checkout-steps">
            <div class="step">
                <span>1</span>
                <p>Carrito</p>
            </div>
            <div class="step active">
                <span>2</span>
                <p>Pago</p>
            </div>
        </div>
    </div>
</header>

<main class="payment-container">
    <div class="cart-container">
        <h1 class="pago-titulo">Información de Pago</h1>

        <div class="payment-grid">
            <!-- Formulario de pago -->
            <section class="payment-form">
                <div class="form-section">
                    <h2>Datos de Contacto</h2>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" placeholder="tucorreo@ejemplo.com">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefono</label>
                        <input type="tel" id="phone" placeholder="+52 55 1234 5678">
                    </div>
                </div>

                <div class="form-section">
                    <h2>Información de Envío</h2>
                    <div class="form-group">
                        <label for="fullname">Nombre Completo</label>
                        <input type="text" id="fullname" placeholder="Ej: Nicolas Moyano">
                    </div>
                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" id="address" placeholder="Calle, Nro. Altura, Piso, Dpto.">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">Ciudad</label>
                            <input type="text" id="city" placeholder="Corrientes">
                        </div>
                        <div class="form-group">
                            <label for="zip">Código Postal</label>
                            <input type="text" id="zip" placeholder="3400">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country">País</label>
                        <select id="country">
                            <option value="mx">Argentina</option>
                            <option value="us">Chile</option>
                            <option value="es">España</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Método de Pago</h2>
                    <div class="form-group">
                        <label for="cardname">Nombre en la Tarjeta</label>
                        <input type="text" id="cardname" placeholder="Ej: Nicolas N. Moyano">
                    </div>
                    <div class="form-group">
                        <label for="cardnumber">Número de Tarjeta</label>
                        <input type="text" id="cardnumber" placeholder="1234 5678 9121 8172">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry">Fecha de Expiración</label>
                            <input type="text" id="expiry" placeholder="MM/AA">
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" placeholder="912">
                        </div>
                    </div>
                </div>

                <button class="finalBtn">Pagar Ahora</button>
            </section>

            <!-- Resumen de orden -->
            <aside class="order-summary">
                <div class="summary-card">
                    <h2>Resumen de Orden</h2>

                    <div class="cart-items-container" id="cart-items">
                        <div class="empty-message" style="display:none;">
                            <i class="bi bi-cart-x"></i>
                            <p>Carrito vacío</p>
                        </div>
                    </div>

                    <div class="summary-details">
                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="summary-item">
                            <span>Envío</span>
                            <span>$0.00</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span id="total">$0.00</span>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <h2>¿Necesitas ayuda?</h2>
                    <p><i class="bi bi-headset"></i> Soporte 24/7</p>
                    <p><i class="bi bi-envelope"></i> kings&wastelands@gmail.com</p>
                </div>
            </aside>
        </div>
    </div>
</main>