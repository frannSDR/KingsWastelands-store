<div class="all-games-container">
    <!-- menu lateral -->
    <aside class="all-games-sidebar">

        <div class="all-games-menu-title">Explorar</div>
        <ul class="all-menu-categories">
            <li><a href="<?= base_url('todos') ?>" <?= ($categoriaActual ?? '') === 'todos' ? 'class="all-active"' : '' ?>>Todos los juegos</a></li>
            <li><a href="<?= base_url('accion') ?>" <?= ($categoriaActual ?? '') === 'accion' ? 'class="all-active"' : '' ?>>Acción</a></li>
            <li><a href="<?= base_url('aventuras') ?>" <?= ($categoriaActual ?? '') === 'aventuras' ? 'class="all-active"' : '' ?>>Aventuras</a></li>
            <li><a href="<?= base_url('rpg') ?>" <?= ($categoriaActual ?? '') === 'rpg' ? 'class="all-active"' : '' ?>>RPG</a></li>
            <li><a href="<?= base_url('terror') ?>" <?= ($categoriaActual ?? '') === 'terror' ? 'class="all-active"' : '' ?>>Terror</a></li>
            <li><a href="<?= base_url('indie') ?>" <?= ($categoriaActual ?? '') === 'indie' ? 'class="all-active"' : '' ?>>Indie</a></li>
            <li><a href="<?= base_url('estrategia') ?>" <?= ($categoriaActual ?? '') === 'estrategia' ? 'class="all-active"' : '' ?>>Estrategias</a></li>
            <li><a href="<?= base_url('openworld') ?>" <?= ($categoriaActual ?? '') === 'openworld' ? 'class="all-active"' : '' ?>>Mundo Abierto</a></li>
        </ul>

        <div class="all-menu-title">Filtros</div>
        <ul class="all-menu-categories">
            <li><a href="#">En oferta</a></li>
            <li><a href="#">Nuevos lanzamientos</a></li>
            <li><a href="#">Más populares</a></li>
        </ul>

    </aside>

    <!-- main content -->
    <main class="games-main-content">
        <div class="all-games-header">
            <h1 class="games-page-title">
                <?php
                if (($categoriaActual ?? '') === 'todos') {
                    echo 'Todos los juegos';
                } else {
                    echo ucfirst($categoriaActual);
                }
                ?>
            </h1>
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
            <div class="games-search-bar">
                <input type="text" placeholder="Buscar juegos...">
                <button>Buscar</button>
            </div>
        </div>

        <!-- card de cada juego -->
        <div class="all-games-list-container" id="gamesContainer">
            <?php foreach ($juegos as $juego): ?>
                <a href="<?= base_url('juego/' . $juego['game_id']) ?>" class="all-game-card-link">
                    <div class="all-game-card">
                        <div class="all-game-image">
                            <div class="game-trailer">
                                <?php if (!empty($juego['youtube_trailer_id'])): ?>
                                    <iframe
                                        src="https://www.youtube.com/embed/<?= $juego['youtube_trailer_id'] ?>&amp;start=10&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1"
                                        title="YouTube video player"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen>
                                    </iframe>
                                <?php endif; ?>
                            </div>
                            <img src="<?= $juego['card_image_url'] ?>" alt="Foto de <?= esc($juego['title']) ?>">
                        </div>
                        <div class="all-game-info">
                            <h3 class="all-game-title"><?= esc($juego['title']) ?></h3>
                            <div class="all-game-meta">
                                <span><i class="bi bi-star-fill" style="color: #FFD700;"></i> <?= $juego['rating'] ?></span>
                                <span><i class="bi bi-calendar3" style="color:rgb(75, 153, 255);"></i> <?= date('d M Y', strtotime($juego['release_date'])) ?></span>
                            </div>
                            <div class="all-game-tags">
                                <?php if (!empty($juego['categorias'])): ?>
                                    <?php foreach ($juego['categorias'] as $index => $categoria): ?>
                                        <span class="all-game-tag" href="/<?= esc($categoria['slug']) ?>">
                                            <?= esc($categoria['name_cat']) ?><?= $index < count($juego['categorias']) - 1 ? ' ' : '' ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <p class="all-game-description"><?= esc($juego['about']) ?></p>
                            <div class="all-game-footer">
                                <div class="all-game-price">$ <?= $juego['price'] ?></div>
                                <div class="all-game-buttons">
                                    <button class="btn2 btn-primary2"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
</div>

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