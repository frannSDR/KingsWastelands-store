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
            <span id="next-release-countdown">Proximamente...</span>
        </div>
    </div>

    <div class="release-cards-container">
        <?php foreach ($proxLanzamientos as $juego): ?>
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
                    <h3 class="release-title"><?= esc($juego['title']) ?></h3>
                    <div class="release-meta">
                        <span class="release-developer"><?= esc($juego['developer']) ?></span>
                    </div>
                    <div class="release-actions">
                        <button class="wishlist-btn">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                            Lista de deseos
                        </button>
                        <button class="notify-btn">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                            </svg>
                            Avisarme
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="section-footer">
        <a href="<?= base_url('proximos') ?>" class="view-all-link">
            Ver todos los próximos lanzamientos
            <svg class="arrow-icon" viewBox="0 0 24 24">
                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
            </svg>
        </a>
    </div>
</section>