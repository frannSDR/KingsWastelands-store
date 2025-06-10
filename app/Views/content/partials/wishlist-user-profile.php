<div class="section-header">
    <h2><i class="bi bi-heart-fill"></i> Mi Lista de Deseados</h2>
    <div class="sort-options">
        <select class="sort-select">
            <option>Ordenar por</option>
            <option value="recent">Recientes primero</option>
            <option value="price-asc">Precio (menor a mayor)</option>
            <option value="price-desc">Precio (mayor a menor)</option>
        </select>
    </div>
</div>

<div class="wishlist-container">
    <?php if (!empty($deseados)): ?>
        <div class="wishlist-grid">
            <?php foreach ($deseados as $juego): ?>
                <div class="wishlist-item">
                    <div class="wishlist-image">
                        <img src="<?= $juego['card_image_url'] ?>" alt="<?= esc($juego['title']) ?>">
                        <button class="remove-wishlist-btn" data-game-id="<?= $juego['game_id'] ?>">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="wishlist-info">
                        <h3><?= esc($juego['title']) ?></h3>
                        <div class="wishlist-meta">
                            <span class="price">$<?= $juego['price'] ?></span>
                            <span class="release-date"><?= date('d M Y', strtotime($juego['release_date'])) ?></span>
                        </div>
                        <button class="add-to-cart-btn" data-game-id="<?= $juego['game_id'] ?>">
                            <i class="bi bi-cart-plus"></i> Añadir al carrito
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-heart"></i>
            <p>Tu lista de deseados está vacía</p>
            <a href="<?= base_url('todos') ?>" class="browse-btn">Descubrir juegos</a>
        </div>
    <?php endif; ?>
</div>