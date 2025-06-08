<main class="home-container">
    <!-- Juegos Populares -->
    <section class="games-section">
        <div class="home-section-header">
            <h2 class="home-section-title">
                <svg class="section-icon" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                Juegos Populares
            </h2>
            <a href="<?= base_url('populares') ?>" class="view-all">Ver todos</a>
        </div>

        <div class="games-carousel">
            <?php foreach ($juegosPopulares as $juego): ?>
                <div class="home-game-card">
                    <div class="game-badge popular">TOP</div>
                    <a href="<?= base_url('juego/' . $juego['game_id']) ?>">
                        <div class="game-image">
                            <img src="<?= $juego['card_image_url'] ?>" alt="<?= esc($juego['title']) ?>">
                            <div class="game-hover">
                                <div class="game-rating">
                                    <i class="bi bi-star-fill"></i> <?= $juego['rating'] ?>
                                </div>
                                <button class="quick-view">Vista Rápida</button>
                            </div>
                        </div>
                        <div class="game-info">
                            <h3><?= esc($juego['title']) ?></h3>
                            <div class="game-price">
                                <span class="original-price">$<?= $juego['price'] ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>