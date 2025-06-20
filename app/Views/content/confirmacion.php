<!-- Header del proceso de confirmación -->
<header class="checkout-header">
    <div class="cart-container">
        <div class="checkout-steps">
            <div class="step completed">
                <span><i class="bi bi-check"></i></span>
                <p>Carrito</p>
            </div>
            <div class="step completed">
                <span><i class="bi bi-check"></i></span>
                <p>Pago</p>
            </div>
            <div class="step active">
                <span>3</span>
                <p>Confirmación</p>
            </div>
        </div>
    </div>
</header>

<!-- Contenedor principal de confirmación -->
<main class="confirmation-container">
    <div class="cart-container">
        <div class="confirmation-card">
            <div class="confirmation-header">
                <div class="confirmation-icon success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h1>¡Compra realizada con éxito!</h1>
                <p class="confirmation-subtitle">
                    Tu pedido #KW<?= date('Y') ?>-<?= $compra['compra_id'] ?> ha sido confirmado
                </p>
            </div>

            <div class="confirmation-grid">
                <!-- Resumen del pedido -->
                <section class="order-details">
                    <h2><i class="bi bi-receipt"></i> Detalles del Pedido</h2>

                    <div class="detail-section">
                        <h3>Información de la Compra</h3>
                        <div class="detail-row">
                            <span class="detail-label">Número de Pedido:</span>
                            <span class="detail-value">KW<?= date('Y') ?>-<?= $compra['compra_id'] ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Fecha:</span>
                            <span class="detail-value"><?= date('d M Y - H:i', strtotime($compra['fecha'])) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Método de Pago:</span>
                            <span class="detail-value"><?= esc($compra['metodo_pago']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total:</span>
                            <span class="detail-value highlight">$<?= number_format($compra['total'], 2) ?></span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3>Productos</h3>
                        <div class="confirmation-items">
                            <?php foreach ($items as $item): ?>
                                <div class="confirmation-item">
                                    <div class="item-image">
                                        <img src="<?= esc($item['juego']['card_image_url'] ?? 'https://via.placeholder.com/80') ?>" alt="Portada del juego">
                                    </div>
                                    <div class="item-info">
                                        <h4><?= esc($item['juego']['title']) ?></h4>
                                        <span class="item-platform"><?= esc($item['juego']['platform'] ?? 'PC') ?></span>
                                        <span class="item-price">$<?= number_format($item['precio_unitario'], 2) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3>Información de Entrega</h3>
                        <div class="detail-row">
                            <span class="detail-label">Correo electrónico:</span>
                            <span class="detail-value"><?= esc($compra['email']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Método de entrega:</span>
                            <span class="detail-value">Descarga digital</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Claves de producto:</span>
                            <span class="detail-value">Disponibles en tu biblioteca</span>
                        </div>
                    </div>
                </section>

                <!-- Acciones y soporte -->
                <aside class="confirmation-actions">
                    <div class="action-card">
                        <h2><i class="bi bi-download"></i> Acceso Inmediato</h2>
                        <p>Tus juegos están disponibles para descargar ahora en tu biblioteca.</p>
                        <button class="action-btn primary">
                            <i class="bi bi-collection-play"></i> Ir a Mi Biblioteca
                        </button>
                    </div>

                    <div class="action-card">
                        <h2><i class="bi bi-receipt"></i> Recibo de Compra</h2>
                        <p>Hemos enviado un correo con los detalles de tu compra a <?= esc($compra['email']) ?>.</p>
                        <button class="action-btn secondary">
                            <i class="bi bi-envelope"></i> Reenviar Recibo
                        </button>
                        <button class="action-btn secondary">
                            <i class="bi bi-printer"></i> Imprimir Recibo
                        </button>
                    </div>

                    <div class="action-card support">
                        <h2><i class="bi bi-headset"></i> ¿Necesitas ayuda?</h2>
                        <p>Nuestro equipo de soporte está disponible 24/7 para ayudarte con cualquier problema.</p>
                        <div class="support-methods">
                            <a href="#" class="support-link">
                                <i class="bi bi-whatsapp"></i> Chat con Soporte
                            </a>
                            <a href="#" class="support-link">
                                <i class="bi bi-envelope"></i> Enviar Email
                            </a>
                            <a href="#" class="support-link">
                                <i class="bi bi-telephone"></i> Llamar +54 379 4148344
                            </a>
                        </div>
                    </div>

                    <div class="recommendations">
                        <h3>¿Qué tal si agregas estos juegos a tu colección?</h3>
                        <div class="recommended-games">
                            <div class="game">
                                <img src="https://via.placeholder.com/100/333333/7B68EE?text=Game+Cover" alt="Juego recomendado">
                                <span>Starfield</span>
                            </div>
                            <div class="game">
                                <img src="https://via.placeholder.com/100/333333/7B68EE?text=Game+Cover" alt="Juego recomendado">
                                <span>Spider-Man 2</span>
                            </div>
                            <div class="game">
                                <img src="https://via.placeholder.com/100/333333/7B68EE?text=Game+Cover" alt="Juego recomendado">
                                <span>Final Fantasy XVI</span>
                            </div>
                        </div>
                        <button class="action-btn outline">
                            <i class="bi bi-arrow-left"></i> Volver a la Tienda
                        </button>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</main>