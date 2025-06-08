<div class="wishlist-container">
    <div class="wishlist-header">
        <h1 class="wishlist-title">
            <svg class="wishlist-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
            Mi Lista de Deseados
        </h1>
        <div class="wishlist-stats">
            <span class="wishlist-count">5 juegos</span>
            <span class="wishlist-total">Total: $199.95</span>
        </div>
    </div>

    <div class="wishlist-filters">
        <div class="filter-group">
            <label for="sort-by">Ordenar por:</label>
            <select id="sort-by" class="filter-select">
                <option value="recent">Recientemente añadidos</option>
                <option value="price-asc">Precio (menor a mayor)</option>
                <option value="price-desc">Precio (mayor a menor)</option>
                <option value="release">Fecha de lanzamiento</option>
                <option value="rating">Mejor valorados</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="platform-filter">Plataforma:</label>
            <select id="platform-filter" class="filter-select">
                <option value="all">Todas</option>
                <option value="pc">PC</option>
                <option value="playstation">PlayStation</option>
                <option value="xbox">Xbox</option>
                <option value="switch">Nintendo Switch</option>
            </select>
        </div>
        <button class="clear-filters">Limpiar filtros</button>
    </div>

    <div class="wishlist-grid">
        <!-- Ejemplo de juego en la lista -->
        <div class="wishlist-item">
            <div class="wishlist-item-image">
                <img src="https://via.placeholder.com/300x400" alt="Nombre del Juego">
                <div class="wishlist-item-badge">Próximamente</div>
                <button class="wishlist-remove-btn" title="Eliminar de la lista">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                    </svg>
                </button>
            </div>
            <div class="wishlist-item-info">
                <h3 class="wishlist-item-title">The Last of Us Part III</h3>
                <div class="wishlist-item-meta">
                    <span class="wishlist-item-platform pc">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
                        </svg>
                        PC
                    </span>
                    <span class="wishlist-item-release">15 Sep 2024</span>
                </div>
                <div class="wishlist-item-price">
                    <span class="current-price">$59.99</span>
                    <button class="wishlist-add-to-cart">Añadir al carrito</button>
                </div>
            </div>
        </div>

        <!-- Segundo ejemplo -->
        <div class="wishlist-item">
            <div class="wishlist-item-image">
                <img src="https://via.placeholder.com/300x400" alt="Nombre del Juego">
                <div class="wishlist-item-badge on-sale">-20%</div>
                <button class="wishlist-remove-btn" title="Eliminar de la lista">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                    </svg>
                </button>
            </div>
            <div class="wishlist-item-info">
                <h3 class="wishlist-item-title">Cyberpunk 2077: Phantom Liberty</h3>
                <div class="wishlist-item-meta">
                    <span class="wishlist-item-platform ps">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 12h6v6H9z" />
                            <path d="M22 12c0 5.52-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2s10 4.48 10 10zm-10 1.5v5c2.76 0 5-2.24 5-5h-5zm0-3v-5c-2.76 0-5 2.24-5 5h5z" />
                        </svg>
                        PS5
                    </span>
                    <span class="wishlist-item-release">Disponible</span>
                </div>
                <div class="wishlist-item-price">
                    <span class="original-price">$49.99</span>
                    <span class="current-price">$39.99</span>
                    <button class="wishlist-add-to-cart">Añadir al carrito</button>
                </div>
            </div>
        </div>

        <!-- Tercer ejemplo -->
        <div class="wishlist-item">
            <div class="wishlist-item-image">
                <img src="https://via.placeholder.com/300x400" alt="Nombre del Juego">
                <button class="wishlist-remove-btn" title="Eliminar de la lista">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                    </svg>
                </button>
            </div>
            <div class="wishlist-item-info">
                <h3 class="wishlist-item-title">Halo Infinite: Campaign</h3>
                <div class="wishlist-item-meta">
                    <span class="wishlist-item-platform xbox">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 11.5v1c0 .83.67 1.5 1.5 1.5h13c.83 0 1.5-.67 1.5-1.5v-1c0-.83-.67-1.5-1.5-1.5h-13c-.83 0-1.5.67-1.5 1.5z" />
                            <path d="M17.5 15H19v1.5c0 .83-.67 1.5-1.5 1.5h-11c-.83 0-1.5-.67-1.5-1.5V15h1.5c.83 0 1.5.67 1.5 1.5v1c0 .83.67 1.5 1.5 1.5h5c.83 0 1.5-.67 1.5-1.5v-1c0-.83.67-1.5 1.5-1.5z" />
                        </svg>
                        Xbox Series X
                    </span>
                    <span class="wishlist-item-release">Disponible</span>
                </div>
                <div class="wishlist-item-price">
                    <span class="current-price">$29.99</span>
                    <button class="wishlist-add-to-cart">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    <div class="wishlist-empty-state" style="display: none;">
        <svg class="empty-icon" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
        </svg>
        <h2>Tu lista de deseados está vacía</h2>
        <p>Explora nuestro catálogo y añade tus juegos favoritos</p>
        <a href="<?= base_url('todos') ?>" class="browse-games-btn">Explorar juegos</a>
    </div>
</div>