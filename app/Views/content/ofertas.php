<section class="discount-games">
    <div class="section-header">
        <div class="section-title-container">
            <h2 class="section-title">Ofertas Especiales</h2>
            <div class="timer-container">
                <span class="timer-icon">⏳</span>
                <span class="timer-text">La oferta termina en: <span id="countdown" class="timer-countdown">23:59:59</span></span>
            </div>
        </div>
        <p class="section-subtitle">Aprovecha estos descuentos por tiempo limitado</p>
    </div>

    <div class="horizontal-games-container">
        <?php foreach ($juegosEnOferta as $juego): ?>
            <?php $enCarrito = in_array($juego['game_id'], $enCarritoIds ?? []); ?>
            <div class="horizontal-game-card">
                <div class="game-content">
                    <div class="game-image-container">
                        <img src="<?= $juego['card_image_url'] ?>" alt="Portada de <?= $juego['title'] ?>" class="game-image">
                        <div class="discount-banner"><?= round(100 - ($juego['special_price'] / $juego['price']) * 100) ?>%</div>
                    </div>
                    <div class="game-details">
                        <div class="game-info">
                            <a style="text-decoration: none;" href="<?= base_url('juego/' . $juego['game_id']) ?>">
                                <h3 class="game-title"><?= esc($juego['title']) ?></h3>
                            </a>
                            <div class="game-meta">
                                <span class="platform-badge pc">PC</span>
                                <div class="game-rating">
                                    <span class="stars"><?= renderStars($juego['rating']) ?></span>
                                    <span class="score"><?= $juego['rating'] ?></span>
                                </div>
                            </div>
                            <p class="game-description"><?= esc($juego['about']) ?></p>
                        </div>
                        <div class="pricing-container">
                            <div class="price-wrapper">
                                <span class="original-price">$<?= $juego['price'] ?></span>
                                <span class="current-price">$<?= $juego['special_price'] ?></span>
                            </div>
                            <button class="buy-now-btn" data-game-id="<?= $juego['game_id'] ?>">
                                <?php if ($enCarrito): ?>
                                    <i class="bi bi-cart-fill"></i><span class="cart-btn-text">En el carrito</span>
                                <?php else: ?>
                                    <i class="bi bi-cart"></i><span class="cart-btn-text">Añadir al carrito</span>
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="game-badge best-offer">MEJOR OFERTA</div>
            </div>
        <?php endforeach; ?>
</section>

<!-- Paginación alternativa -->
<?php if (isset($currentPage) && isset($totalPages) && $totalPages > 1): ?>
    <div class="modern-pagination">
        <div class="pagination-container">
            <!-- Botón Anterior -->
            <a href="<?= $currentPage > 1 ? "?page=" . ($currentPage - 1) : '#' ?>"
                class="pagination-button <?= $currentPage == 1 ? 'disabled' : '' ?>">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z" />
                </svg>
            </a>

            <!-- Números de página -->
            <div class="pagination-numbers">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>"
                        class="pagination-number <?= $i == $currentPage ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>

            <!-- Botón Siguiente -->
            <a href="<?= $currentPage < $totalPages ? "?page=" . ($currentPage + 1) : '#' ?>"
                class="pagination-button <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z" />
                </svg>
            </a>
        </div>
    </div>
<?php endif; ?>

<?php
function renderStars($rating)
{
    $stars = $rating / 2;
    $fullStars = floor($stars);
    $emptyStars = 5 - $fullStars;
    $starsHtml = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $starsHtml .= '★';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $starsHtml .= '☆';
    }
    return $starsHtml;
}
?>