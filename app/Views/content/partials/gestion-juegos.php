<!-- Menu Lateral de la seccion perfil -->
<div class="section-header">
    <h2><i class="bi bi-controller"></i> Gestión de Juegos</h2>
    <div class="header-actions">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="user-search" placeholder="Buscar juegos...">
        </div>
        <button class="btn btn-primary" id="addGameBtn">
            <i class="bi bi-plus"></i> Agregar juego
        </button>
    </div>
</div>

<!-- paginacion header -->
<div id="pagination-container" class="pagination">
    <?php
    // mostrar numeros de pagina
    $start = max(1, $currentPage - 2);
    $end = min($totalPages, $currentPage + 2);
    $baseUrl = base_url('/perfil/admin-juegos');
    ?>
    <?php if ($start > 1): ?>
        <button class="pagination-button <?= 1 == $currentPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="pagination-button <?= $i == $currentPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
        <?php if ($end < $totalPages - 1): ?>
            <span class="pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="pagination-button <?= $totalPages == $currentPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $totalPages ?>"><?= $totalPages ?></a>
        </button>
    <?php endif; ?>
</div>

<!-- Listado de juegos existentes -->
<div id="adminTable" class="admin-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Precio</th>
                <th>Fecha de lanzamiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($juegos as $juego): ?>
                <tr>
                    <td><?= $juego['game_id'] ?></td>
                    <td><?= esc($juego['title']) ?></td>
                    <td>$<?= $juego['price'] ?></td>
                    <td><?= $juego['release_date'] ?? 'nn' ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-edit" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn-icon btn-danger" title="Eliminar">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Formulario para agregar juegos (oculto inicialmente) -->
<div id="game-form-container" style="display: none;">
    <section class="upload-game-section" style="margin-top: 70px;">
        <div class="container">
            <h2 class="section-title"><i class="bi bi-upload"></i> Subir Nuevo Juego</h2>

            <form id="upload-game-form" class="game-form">
                <!-- Sección 1: Info Básica -->
                <fieldset class="form-section">
                    <legend><i class="bi bi-info-circle"></i> Información Principal</legend>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="game-name">Nombre del Juego*</label>
                            <input type="text" id="game-name" required placeholder="Ej: Cyberpunk 2077">
                        </div>

                        <div class="form-group">
                            <label for="game-price">Precio (USD)*</label>
                            <div class="price-input">
                                <span>$</span>
                                <input type="number" id="game-price" min="0" step="0.01" required placeholder="59.99">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="release-date">Fecha de Lanzamiento*</label>
                            <input type="date" id="release-date" required>
                        </div>

                        <div class="form-group">
                            <label for="developer">Desarrolladora*</label>
                            <input type="text" id="developer" required placeholder="Ej: CD Projekt Red">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="about">Acerca del Juego (Breve descripción)*</label>
                        <input type="text" id="about" maxlength="150" required
                            placeholder="Ej: Un RPG de mundo abierto en la ciudad futurista de Night City">
                    </div>

                    <div class="form-group">
                        <label for="synopsis">Sinopsis*</label>
                        <textarea id="synopsis" rows="4" required
                            placeholder="Describe la trama, características principales..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Categorías*</label>
                        <div class="categories-grid">
                            <label class="category-checkbox">
                                <input type="checkbox" name="category" value="rpg"> Accion
                            </label>
                            <label class="category-checkbox">
                                <input type="checkbox" name="category" value="fps"> Aventura
                            </label>
                            <label class="category-checkbox">
                                <input type="checkbox" name="category" value="aventura"> Indie
                            </label>
                            <label class="category-checkbox">
                                <input type="checkbox" name="category" value="rpg"> Terror
                            </label>
                            <label class="category-checkbox">
                                <input type="checkbox" name="category" value="rpg"> Estrategia
                            </label>
                            <!-- Añade más categorías según necesites -->
                        </div>
                    </div>
                </fieldset>

                <!-- Sección 2: Media URLs -->
                <fieldset class="form-section">
                    <legend><i class="bi bi-image"></i> Multimedia</legend>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="cover-url">URL Cover*</label>
                            <input type="url" id="cover-url" required placeholder="https://ejemplo.com/cover.jpg">
                        </div>

                        <div class="form-group">
                            <label for="card-url">URL Card*</label>
                            <input type="url" id="card-url" required placeholder="https://ejemplo.com/card.jpg">
                        </div>

                        <div class="form-group">
                            <label for="banner-url">URL Banner*</label>
                            <input type="url" id="banner-url" required placeholder="https://ejemplo.com/banner.jpg">
                        </div>

                        <div class="form-group">
                            <label for="logo-url">URL Logo*</label>
                            <input type="url" id="logo-url" required placeholder="https://ejemplo.com/logo.png">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Imágenes Adicionales (4 URLs)*</label>
                        <div id="additional-images">
                            <input type="url" class="image-url" required placeholder="https://ejemplo.com/screenshot1.jpg">
                            <input type="url" class="image-url" required placeholder="https://ejemplo.com/screenshot2.jpg">
                            <input type="url" class="image-url" required placeholder="https://ejemplo.com/screenshot3.jpg">
                            <input type="url" class="image-url" required placeholder="https://ejemplo.com/screenshot4.jpg">
                        </div>
                    </div>
                </fieldset>

                <!-- Sección 3: Requisitos -->
                <fieldset class="form-section">
                    <legend><i class="bi bi-pc-display"></i> Requisitos del Sistema</legend>

                    <div class="requirements-tabs">
                        <button type="button" class="tab-btn active" data-tab="minimos">Mínimos</button>
                        <button type="button" class="tab-btn" data-tab="recomendados">Recomendados</button>
                        <button type="button" class="tab-btn" data-tab="ultra">Ultra</button>
                    </div>

                    <div class="tab-content active" id="minimos">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="min-cpu">CPU*</label>
                                <input type="text" id="min-cpu" required placeholder="Ej: Intel Core i7-4790K">
                            </div>

                            <div class="form-group">
                                <label for="min-ram">RAM*</label>
                                <input type="text" id="min-ram" required placeholder="Ej: 8 GB">
                            </div>

                            <div class="form-group">
                                <label for="min-gpu">GPU*</label>
                                <input type="text" id="min-gpu" required placeholder="Ej: NVIDIA GTX 1650">
                            </div>

                            <div class="form-group">
                                <label for="min-storage">Almacenamiento*</label>
                                <input type="text" id="min-storage" required placeholder="Ej: 70 GB SDD">
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="recomendados">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="min-cpu">CPU*</label>
                                <input type="text" id="min-cpu" required placeholder="Ej: Intel Core i7-4790K">
                            </div>

                            <div class="form-group">
                                <label for="min-ram">RAM*</label>
                                <input type="text" id="min-ram" required placeholder="Ej: 8 GB">
                            </div>

                            <div class="form-group">
                                <label for="min-gpu">GPU*</label>
                                <input type="text" id="min-gpu" required placeholder="Ej: NVIDIA GTX 1650">
                            </div>

                            <div class="form-group">
                                <label for="min-storage">Almacenamiento*</label>
                                <input type="text" id="min-storage" required placeholder="Ej: 70 GB SDD">
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="ultra">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="min-cpu">CPU*</label>
                                <input type="text" id="min-cpu" required placeholder="Ej: Intel Core i7-4790K">
                            </div>

                            <div class="form-group">
                                <label for="min-ram">RAM*</label>
                                <input type="text" id="min-ram" required placeholder="Ej: 8 GB">
                            </div>

                            <div class="form-group">
                                <label for="min-gpu">GPU*</label>
                                <input type="text" id="min-gpu" required placeholder="Ej: NVIDIA GTX 1650">
                            </div>

                            <div class="form-group">
                                <label for="min-storage">Almacenamiento*</label>
                                <input type="text" id="min-storage" required placeholder="Ej: 70 GB SDD">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="reset" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload"></i> Publicar Juego
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- paginacion footer -->
<div id="pagination-container" class="pagination">
    <?php
    // mostrar numeros de pagina
    $start = max(1, $currentPage - 2);
    $end = min($totalPages, $currentPage + 2);
    $baseUrl = base_url('/perfil/admin-juegos');
    ?>

    <?php if ($start > 1): ?>
        <button class="pagination-button <?= 1 == $currentPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="pagination-button <?= $i == $currentPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
        <?php if ($end < $totalPages - 1): ?>
            <span class="pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="pagination-button <?= $totalPages == $currentPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $totalPages ?>"><?= $totalPages ?></a>
        </button>
    <?php endif; ?>
</div>