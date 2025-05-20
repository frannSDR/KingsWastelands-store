<div class="section-container">
    <div class="trending-title" style="margin-top: 30px;">
        <p><?= $section_title ?? 'Juegos' ?></p>
    </div>
    <div class="games-container">
        <?php foreach ($juegos as $juego): ?>
            <div class="game-card">
                <div class="media-container">
                    <img src="<?= $juego['card_image_url'] ?>" alt="<?= esc($juego['title']) ?>" class="game-image">
                    <?php if (!empty($juego['youtube_trailer_id'])): ?>
                        <div class="game-trailer">
                            <iframe
                                src="https://www.youtube.com/embed/<?= $juego['youtube_trailer_id'] ?>&amp;start=10&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="game-info">
                    <div class="game-title"><?= esc($juego['title']) ?></div>
                    <div class="game-price">$<?= number_format($juego['price'], 2) ?></div>
                </div>
                <a href="<?= base_url('juego/' . $juego['game_id']) ?>" class="stretched-link"></a>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Paginación funcional -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>" style="text-decoration: none;" class="pagination-button">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
            </a>
        <?php endif; ?>

        <?php
        // Mostrar números de página
        $start = max(1, $currentPage - 2);
        $end = min($totalPages, $currentPage + 2);

        if ($start > 1): ?>
            <button class="pagination-button <?= 1 == $currentPage ? 'active' : '' ?>">
                <a href="?page=1">1</a>
            </button>
            <?php if ($start > 2): ?>
                <span class="pagination-ellipsis">...</span>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <button class="pagination-button <?= $i == $currentPage ? 'active' : '' ?>">
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            </button>
        <?php endfor; ?>

        <?php if ($end < $totalPages): ?>
            <?php if ($end < $totalPages - 1): ?>
                <span class="pagination-ellipsis">...</span>
            <?php endif; ?>
            <button class="pagination-button <?= $totalPages == $currentPage ? 'active' : '' ?>">
                <a href="?page=<?= $totalPages ?>"><?= $totalPages ?></a>
            </button>
        <?php endif; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>" style="text-decoration: none;" class="pagination-button">
                <i class="fa-solid fa-chevron-right fa-xs"></i>
            </a>
        <?php endif; ?>
    </div>
</div>