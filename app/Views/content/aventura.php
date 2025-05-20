<div class="section-container">
    <!-- titulo de la categoria -->
    <div class="top-container">
        <div class="cat-title">
            <p>Aventura</p>
            <img src="https://i.ibb.co/8gJFt8Q8/aventuras.png" alt="Terror" class="cat-image">
        </div>
    </div>

    <!-- boton para filtrar -->
    <div class="filter-container">
        <button id="filterButton" class="filter-button">
            <div class="filter-label">
                <svg class="filter-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z" />
                </svg>
                Filtrar
                <span id="selectedFilterText" class="selected-filter">
                    <?=
                    match ($currentFilter ?? 'rating') {
                        'alphabetic' => 'Alfabético',
                        'release' => 'Fecha de salida',
                        'rating' => 'Calificación',
                        'price' => 'Precio',
                        default => 'Calificación'
                    }
                    ?>
                </span>
            </div>
            <svg class="arrow-icon" id="arrowIcon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 10l5 5 5-5z" />
            </svg>
        </button>
        <div class="dropdown-content" id="filterDropdown">
            <div class="dropdown-item" data-filter="alphabetic" data-direction="asc">
                <div class="label">
                    <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm3.5 9.5H9.7l2.1-2.1-1.4-1.4-4.1 4.1 4.1 4.1 1.4-1.4-2.1-2.1h5.8v-2z" />
                    </svg>
                    <span>Alfabéticamente</span>
                </div>
                <div class="direction">
                    <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                    </svg>
                    <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                    </svg>
                </div>
            </div>
            <div class="divider"></div>
            <div class="dropdown-item" data-filter="release" data-direction="asc">
                <div class="label">
                    <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                    </svg>
                    <span>Fecha de salida</span>
                </div>
                <div class="direction">
                    <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                    </svg>
                    <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                    </svg>
                </div>
            </div>
            <div class="divider"></div>
            <div class="dropdown-item" data-filter="rating" data-direction="asc">
                <div class="label">
                    <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                    </svg>
                    <span>Calificación</span>
                </div>
                <div class="direction">
                    <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                    </svg>
                    <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                    </svg>
                </div>
            </div>
            <div class="divider"></div>
            <div class="dropdown-item" data-filter="price" data-direction="asc">
                <div class="label">
                    <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                    <span>Precio</span>
                </div>
                <div class="direction">
                    <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                    </svg>
                    <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- contenedor de los videojuegos -->
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