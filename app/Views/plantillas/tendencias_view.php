<section class="destacados-section">
    <div class="destacados-header">
        <h2>
            <svg class="destacados-icon" viewBox="0 0 24 24">
                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2z" />
            </svg>
            Juegos Destacados
        </h2>
        <p class="destacados-subtitle">Selección exclusiva de nuestros editores</p>
    </div>

    <div class="destacados-carousel">
        <?php foreach ($juegosDestacados as $juego): ?>
            <?php if (strtotime($juego['release_date']) < time()): ?>
                <div class="destacado-card featured">
                    <div class="destacado-badge">EDITOR'S CHOICE</div>
                    <div class="destacado-media">
                        <img src="<?= $juego['banner_image_url'] ?>" alt="Banner de <?= $juego['title'] ?>" class="destacado-image">
                        <button class="play-trailer-btn">
                            <svg viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                            Ver tráiler
                        </button>
                    </div>
                    <div class="destacado-content">
                        <div class="destacado-meta">
                            <span class="destacado-rating"><?= $juego['rating'] ?></span>
                            <span class="destacado-category">Souls-like RPG</span>
                        </div>
                        <h3 class="destacado-title"><?= esc($juego['title']) ?></h3>
                        <p class="destacado-description"><?= esc($juego['about']) ?></p>
                        <div class="destacado-footer">
                            <div class="destacado-platforms">
                                <span class="platform-badge pc">PC</span>
                            </div>
                            <button class="destacado-cta">
                                <i class="bi bi-chevron-double-right"></i>Disponible
                            </button>

                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="destacado-card">
                    <div class="destacado-media">
                        <img src="<?= $juego['banner_image_url'] ?>" alt="Banner de <?= $juego['title'] ?>" class="destacado-image">
                        <button class="play-trailer-btn">
                            <svg viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                            Ver tráiler
                        </button>
                    </div>
                    <div class="destacado-content">
                        <div class="destacado-meta">
                            <span class="destacado-category">JRPG</span>
                        </div>
                        <h3 class="destacado-title"><?= esc($juego['title']) ?></h3>
                        <p class="destacado-description"><?= esc($juego['about']) ?></p>
                        <div class="destacado-footer">
                            <div class="destacado-platforms">
                                <span class="platform-badge pc">PC</span>
                            </div>
                            <button class="destacado-cta preorder">
                                <svg viewBox="0 0 24 24">
                                    <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z" />
                                </svg>
                                Preordenar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="destacados-nav">
        <button class="nav-btn prev" aria-label="Anterior">
            <svg viewBox="0 0 24 24">
                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z" />
            </svg>
        </button>
        <div class="nav-dots"></div>
        <button class="nav-btn next" aria-label="Siguiente">
            <svg viewBox="0 0 24 24">
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z" />
            </svg>
        </button>
    </div>
</section>