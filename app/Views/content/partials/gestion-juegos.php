<!-- Menu Lateral de la seccion perfil -->
<div class="section-header">
    <h2><i class="bi bi-controller"></i> Gestión de Juegos</h2>
    <div class="header-actions">
        <button class="btn btn-primary" id="addGameBtn">
            <i class="bi bi-plus"></i> Agregar juego
        </button>
    </div>
</div>

<!-- paginacion header -->
<div id="gamesPagination-container" class="games-pagination">
    <?php
    $start = max(1, $currentGamesPage - 2);
    $end = min($totalGamesPages, $currentGamesPage + 2);
    $baseUrl = base_url('/admin-section/admin-juegos');
    ?>
    <?php if ($start > 1): ?>
        <button class="games-pagination-button <?= 1 == $currentGamesPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?games_page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="games-pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="games-pagination-button <?= $i == $currentGamesPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?games_page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalGamesPages): ?>
        <?php if ($end < $totalGamesPages - 1): ?>
            <span class="games-pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="games-pagination-button <?= $totalGamesPages == $currentGamesPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?games_page=<?= $totalGamesPages ?>"><?= $totalGamesPages ?></a>
        </button>
    <?php endif; ?>
</div>

<?php if ($errors = session('error-msg')): ?>
    <?php foreach ((array)$errors as $msg): ?>
        <div class="alert alert-danger"><?= esc($msg) ?></div>
    <?php endforeach; ?>
<?php elseif (session('exito-msg')): ?>
    <div class="alert alert-success">
        <?= session('exito-msg') ?>
    </div>
<?php endif; ?>

<!-- Listado de juegos existentes -->
<div id="adminTable" class="admin-table-container">
    <table class="games-admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th></th>
                <th>Título</th>
                <th>Precio Original</th>
                <th>% Descuento</th>
                <th>Precio Oferta</th>
                <th>Fecha de lanzamiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($juegos as $juego): ?>
                <tr>
                    <td><?= $juego['game_id'] ?></td>
                    <td><img src="<?= $juego['logo_url'] ?>" alt="Logo de <?= esc($juego['title']) ?>" class="game-admin-logo"></td>
                    <td><?= esc($juego['title']) ?></td>
                    <td>$<?= number_format($juego['price'], 2) ?></td>
                    <?php if ($juego['special_price_active'] == 1): ?>
                        <td><?= round(100 - ($juego['special_price'] / $juego['price']) * 100) ?>%</td>
                        <td>
                            <span style="color:var(--color-principal);font-weight:bold;">
                                $<?= number_format($juego['special_price'], 2) ?>
                            </span>
                        </td>
                    <?php else: ?>
                        <td>n/a</td>
                        <td>S/Descuento</td>
                    <?php endif; ?>
                    <td><span style="color:rgb(211, 179, 0);"><?= $juego['release_date'] ?? 'nn' ?></span></td>
                    <td>
                        <div class="action-buttons">
                            <?php if ($juego['special_price_active'] == 0): ?>
                                <button data-game-id="<?= $juego['game_id'] ?>" data-action-url="<?= base_url('perfil/aplicar_descuento_juego/' . $juego['game_id']) ?>" class="btn-icon btn-special btn-special-game" title="Aplicar Descuento">
                                    <i class="bi bi-tag"></i>
                                </button>
                            <?php elseif ($juego['special_price_active'] == 1): ?>
                                <form method="post" action="<?= base_url('perfil/quitar_descuento_juego/' . $juego['game_id']) ?>" style="display:inline;">
                                    <button type="submit" class="btn-icon btn-no-special"><i class="bi bi-tag-fill" title="Quitar Descuento"></i></button>
                                </form>
                            <?php endif; ?>
                            <button data-id="<?= $juego['game_id'] ?>" class="btn-icon btn-edit btn-edit-game" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <?php if (!$juego['is_active'] == 0): ?>
                                <button data-id="<?= $juego['game_id'] ?>" class="btn-icon btn-ban btn-ban-game" title="Desactivar">
                                    <i class="bi bi-slash-circle"></i>
                                </button>
                            <?php elseif (!$juego['is_active'] == 1): ?>
                                <button data-id="<?= $juego['game_id'] ?>" class="btn-icon btn-active btn-active-game" title="Activar">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- modal de descuento -->
<div id="specialModal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <h2>Aplicar descuento</h2>
        <form id="specialDiscountForm" method="post">
            <label for="porcentaje">Porcentaje de descuento (%)</label>
            <input type="number" id="porcentaje" name="porcentaje" min="1" max="100" required>
            <div class="modal-actions">
                <button type="submit" class="btn-modal" style="background: var(--color-principal); color: var(--texto);">Aplicar</button>
                <button type="button" class="btn-modal-cancel" onclick="cerrarModalDescuento()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- formulario para agregar juegos (oculto inicialmente) -->
<div id="game-form-container" style="display: none;">
    <section class="upload-game-section" style="margin-top: 70px;">
        <div class="container">
            <h2 class="section-title"><i class="bi bi-upload"></i> Subir Nuevo Juego</h2>
            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form id="upload-game-form" class="game-form" action="<?= base_url('/admin-section/guardar-juego') ?>" method="post">
                <!-- Sección 1: Info Básica -->
                <fieldset class="form-section">
                    <legend><i class="bi bi-info-circle"></i> Información Principal</legend>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="game-name">Nombre del Juego*</label>
                            <input type="text" id="game-name" name="title" required placeholder="Ej: Cyberpunk 2077">
                        </div>

                        <div class="form-group">
                            <label for="game-price">Precio (USD)*</label>
                            <div class="price-input">
                                <span>$</span>
                                <input type="number" id="game-price" name="price" min="0" step="0.01" required placeholder="59.99">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="release-date">Fecha de Lanzamiento*</label>
                            <input type="date" id="release-date" name="release_date" required>
                        </div>

                        <div class="form-group">
                            <label for="developer">Desarrolladora*</label>
                            <input type="text" id="developer" name="developer" required placeholder="Ej: CD Projekt Red">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="about">Acerca del Juego (Breve descripción)*</label>
                        <input type="text" id="about" name="about" maxlength="150" required
                            placeholder="Ej: Un RPG de mundo abierto en la ciudad futurista de Night City">
                    </div>

                    <div class="form-group">
                        <label for="synopsis">Sinopsis*</label>
                        <textarea id="synopsis" name="synopsis" rows="4" required
                            placeholder="Describe la trama, características principales..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Categorías*</label>
                        <div class="categories-grid">
                            <?php foreach ($categorias as $categoria): ?>
                                <label class="category-checkbox">
                                    <input type="checkbox" name="categories[]" value="<?= $categoria['category_id'] ?>"> <?= esc($categoria['name_cat']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="rating">Valoracion*</label>
                        <div class="price-input">
                            <span><i class="bi bi-star"></i></span>
                            <input type="number" id="game-rating" name="game_rating" min="1" step="0.1" placeholder="8,5">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-section">
                    <legend><i class="bi bi-image"></i> Multimedia</legend>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="cover-url">URL Trailer*</label>
                            <input type="text" id="trailer-url" name="trailer" required placeholder="Ej: dQw4w9WgXcQ">
                        </div>

                        <div class="form-group">
                            <label for="cover-url">URL Cover*</label>
                            <input type="url" name="cover_url" required placeholder="https://ejemplo.com/cover.jpg">
                        </div>

                        <div class="form-group">
                            <label for="card-url">URL Card*</label>
                            <input type="url" name="card_url" required placeholder="https://ejemplo.com/card.jpg">
                        </div>

                        <div class="form-group">
                            <label for="banner-url">URL Banner*</label>
                            <input type="url" name="banner_url" required placeholder="https://ejemplo.com/banner.jpg">
                        </div>

                        <div class="form-group">
                            <label for="logo-url">URL Logo*</label>
                            <input type="url" name="logo_url" required placeholder="https://ejemplo.com/logo.png">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Imágenes Adicionales (4 URLs)*</label>
                        <div id="additional-images">
                            <input type="url" class="image-url" name="additional_images[]" required placeholder="https://ejemplo.com/screenshot1.jpg">
                            <input type="url" class="image-url" name="additional_images[]" required placeholder="https://ejemplo.com/screenshot2.jpg">
                            <input type="url" class="image-url" name="additional_images[]" required placeholder="https://ejemplo.com/screenshot3.jpg">
                            <input type="url" class="image-url" name="additional_images[]" required placeholder="https://ejemplo.com/screenshot4.jpg">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-section">
                    <legend><i class="bi bi-pc-display"></i> Requisitos del Sistema</legend>

                    <legend>Minimos</legend>
                    <div class="tab-content" id="minimos">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="min-cpu">CPU*</label>
                                <input type="text" id="min-cpu" name="min_cpu" required placeholder="Ej: Intel Core i7-4790K">
                            </div>
                            <div class="form-group">
                                <label for="min-ram">RAM*</label>
                                <input type="text" id="min-ram" name="min_ram" required placeholder="Ej: 8 GB">
                            </div>
                            <div class="form-group">
                                <label for="min-gpu">GPU*</label>
                                <input type="text" id="min-gpu" name="min_gpu" required placeholder="Ej: NVIDIA GTX 1650">
                            </div>
                            <div class="form-group">
                                <label for="min-storage">Almacenamiento*</label>
                                <input type="text" id="min-storage" name="min_storage" required placeholder="Ej: 70 GB SDD">
                            </div>
                        </div>
                    </div>

                    <legend>Recomendados</legend>
                    <div class="tab-content" id="recomendados">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="rec-cpu">CPU*</label>
                                <input type="text" id="rec-cpu" name="rec_cpu" required placeholder="Ej: Intel Core i7-4790K">
                            </div>
                            <div class="form-group">
                                <label for="rec-ram">RAM*</label>
                                <input type="text" id="rec-ram" name="rec_ram" required placeholder="Ej: 8 GB">
                            </div>
                            <div class="form-group">
                                <label for="rec-gpu">GPU*</label>
                                <input type="text" id="rec-gpu" name="rec_gpu" required placeholder="Ej: NVIDIA GTX 1650">
                            </div>
                            <div class="form-group">
                                <label for="rec-storage">Almacenamiento*</label>
                                <input type="text" id="rec-storage" name="rec_storage" required placeholder="Ej: 70 GB SDD">
                            </div>
                        </div>
                    </div>

                    <legend>Ultra</legend>
                    <div class="tab-content" id="ultra">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="ultra-cpu">CPU*</label>
                                <input type="text" id="ultra-cpu" name="ultra_cpu" required placeholder="Ej: Intel Core i7-4790K">
                            </div>
                            <div class="form-group">
                                <label for="ultra-ram">RAM*</label>
                                <input type="text" id="ultra-ram" name="ultra_ram" required placeholder="Ej: 8 GB">
                            </div>
                            <div class="form-group">
                                <label for="ultra-gpu">GPU*</label>
                                <input type="text" id="ultra-gpu" name="ultra_gpu" required placeholder="Ej: NVIDIA GTX 1650">
                            </div>
                            <div class="form-group">
                                <label for="ultra-storage">Almacenamiento*</label>
                                <input type="text" id="ultra-storage" name="ultra_storage" required placeholder="Ej: 70 GB SDD">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="reset" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit-game-btn">
                        <i class="bi bi-cloud-upload"></i> <span id="submit-game-btn-text">Publicar Juego</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- paginacion footer -->
<div id="gamesPagination-container" class="games-pagination">
    <?php
    $start = max(1, $currentGamesPage - 2);
    $end = min($totalGamesPages, $currentGamesPage + 2);
    $baseUrl = base_url('/admin-section/admin-juegos');
    ?>
    <?php if ($start > 1): ?>
        <button class="games-pagination-button <?= 1 == $currentGamesPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?games_page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="games-pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="games-pagination-button <?= $i == $currentGamesPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?games_page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalGamesPages): ?>
        <?php if ($end < $totalGamesPages - 1): ?>
            <span class="games-pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="games-pagination-button <?= $totalGamesPages == $currentGamesPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?games_page=<?= $totalGamesPages ?>"><?= $totalGamesPages ?></a>
        </button>
    <?php endif; ?>
</div>