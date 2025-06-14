<!-- Juegos en Oferta -->
<section class="games-section">
    <div class="home-section-header">
        <h2 class="home-section-title">
            <svg class="section-icon" viewBox="0 0 24 24">
                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
            </svg>
            Ofertas Especiales
        </h2>
        <a href="<?= base_url('ofertas') ?>" class="view-all">Ver todos</a>
    </div>

    <div class="games-grid">
        <?php foreach ($juegosOferta as $juego): ?>
            <div class="home-game-card sale">
                <div class="game-badge sale">-<?= $juego['discount'] ?>%</div>
                <a href="<?= base_url('juego/' . $juego['game_id']) ?>">
                    <div class="game-image">
                        <img src="<?= $juego['card_image_url'] ?>" alt="<?= esc($juego['title']) ?>">
                        <div class="game-hover">
                            <div class="game-timer">
                                <i class="bi bi-clock"></i> <?= $juego['time_left'] ?>
                            </div>
                            <button class="quick-view">Añadir al carrito</button>
                        </div>
                    </div>
                    <div class="game-info">
                        <h3><?= esc($juego['title']) ?></h3>
                        <div class="game-price">
                            <span class="discounted-price">$<?= $juego['discounted_price'] ?></span>
                            <span class="original-price">$<?= $juego['price'] ?></span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>