<!-- Próximos Lanzamientos -->
<main class="home-container">
    <main class="home-container">
        <section class="games-section">
            <div class="home-section-header">
                <h2 class="home-section-title">
                    <svg class="section-icon" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                    </svg>
                    Próximos Lanzamientos
                </h2>
                <a href="<?= base_url('proximos') ?>" class="view-all">Ver todos</a>
            </div>

            <div class="coming-soon-container">
                <?php foreach ($juegosOferta as $juego): ?>
                    <div class="coming-soon-card">
                        <div class="coming-soon-image">
                            <img src="<?= $juego['card_image_url'] ?>" alt="<?= esc($juego['title']) ?>">
                            <div class="release-date">
                                <span class="day"><?= date('d', strtotime($juego['release_date'])) ?></span>
                                <span class="month"><?= strtoupper(date('M', strtotime($juego['release_date']))) ?></span>
                            </div>
                        </div>
                        <div class="coming-soon-info">
                            <h3><?= esc($juego['title']) ?></h3>
                            <div class="coming-soon-platforms">
                                <span class="platform pc"><i class="bi bi-pc-display"></i></span>
                                <span class="platform xbox"><i class="bi bi-xbox"></i></span>
                                <span class="platform ps"><i class="bi bi-playstation"></i></span>
                            </div>
                            <button class="wishlist-btn">
                                <i class="bi bi-heart"></i> Lista de deseos
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</main>