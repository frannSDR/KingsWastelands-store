<section class="upcoming-games">
    <div class="upcoming-section-header">
        <div class="section-title-container">
            <h2 class="upcoming-section-title">Próximos Lanzamientos</h2>
            <div class="release-container">
                <span class="calendar-icon">📅</span>
                <span class="release-text">Próximamente en: 2025</span></span>
            </div>
        </div>
        <p class="section-subtitle">Descubre los juegos más esperados que llegarán pronto</p>
    </div>

    <div class="upcoming-horizontal-games-container">
        <?php foreach ($proxLanzamientos as $juego): ?>
            <?php if ($juego['is_active'] != 0): ?>
                <?php $enCarrito = in_array($juego['game_id'], $enCarritoIds ?? []); ?>
                <div class="horizontal-game-card">
                    <div class="upcoming-game-content">
                        <div class="upcoming-image-container">
                            <img src="<?= $juego['card_image_url'] ?>" alt="Portada de <?= $juego['title'] ?>" class="upcoming-game-image">
                            <div class="upcoming-release-banner"><?= date('d M', strtotime($juego['release_date'])) ?></div>
                        </div>
                        <div class="upcoming-game-details">
                            <div class="upcoming-game-info">
                                <a style="text-decoration: none;" href="<?= base_url('juego/' . $juego['game_id']) ?>">
                                    <h3 class="upcoming-game-title"><?= esc($juego['title']) ?></h3>
                                </a>
                                <div class="upcoming-game-meta">
                                    <span class="platform-badge pc">PC</span>
                                </div>
                                <p class="upcoming-game-description"><?= esc($juego['about']) ?></p>
                                <div class="upcoming-developer-info">
                                    <span class="upcoming-developer-label">Desarrollador:</span>
                                    <span class="upcoming-developer-name"><?= esc($juego['developer']) ?></span>
                                </div>
                                <div class="upcoming-developer-info">
                                    <span style="color: white;"><i class="bi bi-calendar3" style="color:rgb(75, 153, 255);"></i> <?= date('d M Y', strtotime($juego['release_date'])) ?></span>
                                </div>
                            </div>
                            <div class="upcoming-preorder-container">
                                <div class="upcoming-price-wrapper">
                                    <span class="upcoming-release-price">$<?= $juego['price'] ?></span>
                                </div>
                                <button class="upcoming-preorder-btn" data-game-id="<?= $juego['game_id'] ?>">
                                    <?php if ($enCarrito): ?>
                                        <i class="bi bi-cart-fill"></i><span class="cart-btn-text"> En el carrito</span>
                                    <?php else: ?>
                                        <i class="bi bi-cart"></i><span class="cart-btn-text"> Reservar Ahora</span>
                                    <?php endif; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="upcoming-game-badge">
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- paginacion -->
<?php if (isset($currentPage) && isset($totalPages) && $totalPages > 1): ?>
    <div class="modern-pagination">
        <div class="pagination-container">
            <!-- boton anterios -->
            <a href="<?= $currentPage > 1 ? "?page=" . ($currentPage - 1) : '#' ?>"
                class="pagination-button <?= $currentPage == 1 ? 'disabled' : '' ?>">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z" />
                </svg>
            </a>

            <!-- nros de página -->
            <div class="pagination-numbers">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>"
                        class="pagination-number <?= $i == $currentPage ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>

            <!-- boton siguiente -->
            <a href="<?= $currentPage < $totalPages ? "?page=" . ($currentPage + 1) : '#' ?>"
                class="pagination-button <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z" />
                </svg>
            </a>
        </div>
    </div>
<?php endif; ?>