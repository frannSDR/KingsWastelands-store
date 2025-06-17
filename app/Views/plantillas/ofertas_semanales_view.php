<section class="ofertas-section">
    <div class="ofertas-header">
        <h2 class="ofertas-title"><i class="ofertas-icon bi bi-tag-fill"></i>Ofertas Especiales</h2>
        <div class="ofertas-timer">
            <i class="bi bi-clock"></i>
            <span class="timer-text">La oferta termina en: <span id="countdown">23:59:59</span></span>
        </div>
    </div>

    <div class="ofertas-grid">

        <!-- Ejemplo de juego en oferta -->
        <?php foreach ($juegosEnOferta as $juego): ?>
            <div class="oferta-card">
                <div class="oferta-badge"><?= round(100 - ($juego['special_price'] / $juego['price']) * 100) ?>%</div>
                <div class="oferta-ribbon">MEJOR OFERTA</div>
                <img src="<?= $juego['card_image_url'] ?>" alt="Foto de <?= $juego['title'] ?>" class="oferta-image">

                <div class="oferta-content">
                    <h3 class="oferta-title"><?= esc($juego['title']) ?></h3>
                    <div class="oferta-prices">
                        <span class="original-price">$<?= $juego['price'] ?></span>
                        <span class="current-price">$<?= $juego['special_price'] ?></span>
                    </div>
                    <div class="oferta-meta">
                        <span class="oferta-rating">
                            <i class="bi bi-star-fill"></i>
                            <?= $juego['rating'] ?>
                        </span>
                        <span class="oferta-tag">RPG</span>
                    </div>
                    <button class="oferta-button">
                        <i class="bi bi-cart"></i>
                        Añadir al carrito
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="ofertas-footer">
        <a href="<?= base_url('ofertas') ?>" class="ver-todas-btn">
            Ver todas las ofertas
            <i class="bi bi-chevron-right"></i>
        </a>
    </div>
</section>