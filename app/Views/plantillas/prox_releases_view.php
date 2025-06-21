<section class="proximos-lanzamientos">
    <div class="section-header">
        <h2>
            <svg class="section-icon" viewBox="0 0 24 24">
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                <path d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg>
            Próximos Lanzamientos
        </h2>
        <div class="countdown-badge">
            <i class="bi bi-fire"></i>
            <span id="next-release-countdown">Este año...</span>
        </div>
    </div>

    <div class="release-cards-container">
        <?php foreach ($proxLanzamientos as $juego): ?>
            <?php if ($juego['is_active'] != 0): ?>
                <?php $enCarrito = in_array($juego['game_id'], $enCarritoIds ?? []); ?>
                <div class="release-card">
                    <div class="release-image-container">
                        <img src="<?= $juego['card_image_url'] ?>" alt="Foto de <?= $juego['title'] ?>" class="release-image">
                        <div class="release-date-badge">
                            <?php
                            $dia = date('d', strtotime($juego['release_date']));
                            $mes = strtoupper(date('M', strtotime($juego['release_date'])));
                            ?>
                            <span class="release-day"><?= $dia ?></span>
                            <span class="release-month"><?= $mes ?></span>
                        </div>
                    </div>
                    <div class="release-info">
                        <a href="<?= base_url('juego/' . $juego['game_id']) ?>" style="text-decoration: none; color: white;">
                            <h3 class="release-title"><?= esc($juego['title']) ?></h3>
                        </a>
                        <div class="release-meta">
                            <span class="release-developer"><?= esc($juego['developer']) ?></span>
                        </div>
                        <div class="release-actions">
                            <button class="proxLanzamientos-wishlist-btn" data-game-id="<?= $juego['game_id'] ?>">
                                <?php if (in_array($juego['game_id'], $deseados_ids)): ?>
                                    <i class="bi bi-heart-fill"></i>Deseados
                                <?php else: ?>
                                    <i class="bi bi-heart"></i>Deseados
                                <?php endif; ?>
                            </button>
                            <button class="notify-btn" data-game-id="<?= $juego['game_id'] ?>">
                                <?php if ($enCarrito): ?>
                                    <i class="bi bi-cart-fill"></i><span class="cart-btn-text">En el carrito</span>
                                <?php else: ?>
                                    <i class="bi bi-cart"></i><span class="cart-btn-text">Reservar</span>
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>

    <div class="section-footer">
        <a href="<?= base_url('prox-lanzamientos') ?>" class="view-all-link">
            Ver todos los próximos lanzamientos
            <svg class="arrow-icon" viewBox="0 0 24 24">
                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
            </svg>
        </a>
    </div>
</section>