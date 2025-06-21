<!-- banner del juego -->
<div class="game-banner" style="background-image: url('<?= $juego['banner_image_url'] ?>');">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <img src="<?= $juego['logo_url'] ?>" alt="Logo de <?= esc($juego['title']) ?>" class="game-logo">
        <div class="banner-rating">
            <span class="stars"><?= str_repeat('★', floor($juego['rating'] / 2)) . str_repeat('☆', 5 - floor($juego['rating'] / 2)) ?></span>
            <span class="rating-value"><?= number_format($juego['rating'] / 2, 1) ?>/5</span>
        </div>
    </div>
</div>

<!-- conetnido principal -->
<div class="contenedor-principal">
    <div class="contenido-principal">
        <div class="game-header">
            <div class="game-cover">
                <img src="<?= $juego['cover_image_url'] ?>" alt="Portada de <?= esc($juego['title']) ?>" class="cover-image">
            </div>
            <div class="game-details">
                <div class="game-section-meta">
                    <span class="meta-item"><i class="bi bi-calendar"></i> <?= date('d M Y', strtotime($juego['release_date'])) ?></span>
                    <span class="meta-item"><i class="bi bi-people"></i> <?= esc($juego['developer']) ?></span>
                    <span class="meta-item"><i class="bi bi-tags"></i>
                        <?php foreach ($categorias as $categoria): ?>
                            <span href="/<?= $categoria['slug'] ?>"><?= $categoria['name_cat'] ?><?= !end($categorias) ? ', ' : '' ?>
                            <?php endforeach; ?>
                            </span>
                </div>
                <div class="game-description">
                    <p><?= esc($juego['about']) ?></p>
                </div>
                <div class="availability">
                    <span class="availability-tag available"><i class="bi bi-check-circle"></i> En stock</span>
                    <span class="availability-tag digital"><i class="bi bi-cloud-arrow-down"></i> Descarga digital</span>
                </div>
                <div class="pricing-section">
                    <div class="price-container">
                        <span class="current-price">$<?= number_format($juego['price'], 2) ?></span>
                        <?php if (isset($juego['discount']) && $juego['discount'] > 0): ?>
                            <span class="discount-badge">-<?= $juego['discount'] ?>%</span>
                            <span class="current-price">$<?= number_format($juego['price'] * (1 - $juego['discount'] / 100), 2) ?></span>
                        <?php endif; ?>
                    </div>
                    <button class="add-to-cart-btn">
                        <?php if ($enCarrito): ?>
                            <i class="bi bi-cart-check-fill"></i>
                            <span class="cart-btn-text">En el carrito</span>
                        <?php else: ?>
                            <i class="bi bi-cart-plus"></i>
                            <span class="cart-btn-text">Añadir al carrito</span>
                        <?php endif; ?>
                    </button>
                    <button class="game-section-add-wishlist" data-game-id="<?= $juego['game_id'] ?>">
                        <?php if (in_array($juego['game_id'], $deseados_ids)): ?>
                            <i class="bi bi-bookmark-check-fill"></i>En la lista de deseados
                        <?php else: ?>
                            <i class="bi bi-bookmark"></i>Agregar a la lista de deseados
                        <?php endif; ?>
                    </button>
                </div>
            </div>
        </div>

        <h2 class="titulo-sinopsis">Acerca de</h2>
        <div class="tab-content active" id="about">
            <div class="game-synopsis">
                <?= nl2br(esc($juego['synopsis'])) ?>
            </div>
        </div>

        <h2 class="titulo-sinopsis" style="margin-top: 30px;">Visuales</h2>
        <div class="visuales-container">
            <?php if ($juego['youtube_trailer_id']): ?>
                <div class="trailer-container">
                    <iframe
                        src="https://www.youtube.com/embed/<?= $juego['youtube_trailer_id'] ?>"
                        title="Trailer de <?= esc($juego['title']) ?>"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            <?php endif; ?>
            <div class="galeria-container">
                <?php foreach ($imagenes as $imagen): ?>
                    <div class="thumbnail">
                        <a href="<?= $imagen['image_url'] ?>" data-lightbox="img" data-title="<?= esc($imagen['alt_text'] ?? $juego['title']) ?>">
                            <img src="<?= $imagen['image_url'] ?>" alt="<?= esc($imagen['alt_text'] ?? $juego['title']) ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- seccion de requisitos -->
        <div class="requisitos-seccion">
            <h2 class="titulo-requisitos">Requisitos del Sistema</h2>

            <div class="requisitos-contenedor">
                <!-- mínimos -->
                <div class="requisitos-carta">
                    <div class="requisitos-cabecera">
                        <i class="bi bi-pc-display"></i>
                        <h3>Mínimos</h3>
                        <span class="etiqueta-requisitos">Para 720p @ 30 FPS</span>
                    </div>
                    <div class="requisitos-lista">
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">SO</span>
                            <span class="requisito-valor">Windows 10 64-bit</span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Procesador</span>
                            <span class="requisito-valor"><?= esc($requisitos['minimo']['cpu']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Memoria</span>
                            <span class="requisito-valor"><?= esc($requisitos['minimo']['ram']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Gráficos</span>
                            <span class="requisito-valor"><?= esc($requisitos['minimo']['gpu']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">DirectX</span>
                            <span class="requisito-valor">Versión 12</span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Almacenamiento</span>
                            <span class="requisito-valor"><?= esc($requisitos['minimo']['storage']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- recomendados -->
                <div class="requisitos-carta destacado">
                    <div class="requisitos-cabecera">
                        <i class="bi bi-pc-display-horizontal"></i>
                        <h3>Recomendados</h3>
                        <span class="etiqueta-requisitos">Para 1080p @ 60 FPS</span>
                    </div>
                    <div class="requisitos-lista">
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">SO</span>
                            <span class="requisito-valor">Windows 11 64-bit</span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Procesador</span>
                            <span class="requisito-valor"><?= esc($requisitos['recomendado']['cpu']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Memoria</span>
                            <span class="requisito-valor"><?= esc($requisitos['recomendado']['ram']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Gráficos</span>
                            <span class="requisito-valor"><?= esc($requisitos['recomendado']['gpu']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">DirectX</span>
                            <span class="requisito-valor">Versión 12</span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Almacenamiento</span>
                            <span class="requisito-valor"><?= esc($requisitos['recomendado']['storage']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- ultra -->
                <div class="requisitos-carta">
                    <div class="requisitos-cabecera">
                        <i class="bi bi-gpu-card"></i>
                        <h3>Ultra</h3>
                        <span class="etiqueta-requisitos">Para 4K @ 60 FPS / Ray Tracing</span>
                    </div>
                    <div class="requisitos-lista">
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">SO</span>
                            <span class="requisito-valor">Windows 11 64-bit</span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Procesador</span>
                            <span class="requisito-valor"><?= esc($requisitos['ultra']['cpu']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Memoria</span>
                            <span class="requisito-valor"><?= esc($requisitos['ultra']['ram']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Gráficos</span>
                            <span class="requisito-valor"><?= esc($requisitos['ultra']['gpu']) ?></span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">DirectX</span>
                            <span class="requisito-valor">Versión 12</span>
                        </div>
                        <div class="requisito-item">
                            <span class="requisito-etiqueta">Almacenamiento</span>
                            <span class="requisito-valor"><?= esc($requisitos['ultra']['storage']) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="notas-requisitos">
                <h4><i class="bi bi-info-circle"></i> Notas adicionales</h4>
                <ul>
                    <li>Se requiere conexión a internet para la activación y algunas funciones.</li>
                    <li>Compatibilidad con controladores recomendada: NVIDIA 516.94 / AMD 22.6.1 o superiores.</li>
                    <li>El rendimiento puede variar según la configuración del hardware y software.</li>
                    <li>Se recomienda SSD para mejores tiempos de carga.</li>
                </ul>
            </div>
        </div>

        <!-- Seccion de requisitos -->
        <div class="seccion-resenas">
            <h2 class="titulo-sinopsis">Reseñas de usuarios</h2>

            <div class="estadisticas-resenas">
                <div class="puntuacion-general">
                    <div class="puntuacion-numero"><?= number_format($stats['promedio'], 1) ?></div>
                    <div class="estrellas">
                        <?php
                        $estrellasLlenas = floor($stats['promedio']);
                        $mediaEstrella = ($stats['promedio'] - $estrellasLlenas) >= 0.5;

                        for ($i = 1; $i <= 5; $i++):
                            if ($i <= $estrellasLlenas): ?>
                                <i class="bi bi-star-fill"></i>
                            <?php elseif ($i == $estrellasLlenas + 1 && $mediaEstrella): ?>
                                <i class="bi bi-star-half"></i>
                            <?php else: ?>
                                <i class="bi bi-star"></i>
                        <?php endif;
                        endfor; ?>
                    </div>
                    <div class="total-resenas">Basado en <?= $stats['total'] ?> reseñas</div>
                </div>
                <div class="distribucion-puntuacion">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <div class="barra-puntuacion">
                            <span class="etiqueta-estrellas"><?= $i ?> <i class="bi bi-star-fill"></i></span>
                            <div class="barra-contenedor">
                                <div class="barra-progreso" style="width: <?= $stats['distribucion'][5 - $i] ?>%"></div>
                            </div>
                            <span class="porcentaje"><?= $stats['distribucion'][5 - $i] ?>%</span>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="filtros-resenas">
                <div class="selector-orden">
                    <label for="orden-resenas">Ordenar por:</label>
                    <select id="orden-resenas" name="orden-resenas">
                        <option value="recientes">Más recientes</option>
                        <option value="mejores">Mejor valoradas</option>
                    </select>
                </div>
                <div class="filtro-estrellas">
                    <span class="filtro-texto">Filtrar:</span>
                    <button class="boton-filtro activo" data-estrellas="all">Todas</button>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <button class="boton-filtro" data-estrellas="<?= $i ?>"><?= $i ?>★</button>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="lista-resenas">
                <!-- Reseña -->
                <?= view('content/partials/lista_resenas', [
                    'reviews' => $reviews,
                    'pager' => $pager ?? null,
                    'currentPage' => $currentPage ?? 1
                ]) ?>
            </div>

            <div id="formulario-resena" class="formulario-resena-container" style="display: none;">
                <div class="formulario-resena">
                    <div class="encabezado-formulario">
                        <h3>Escribe tu reseña</h3>
                        <button id="cerrar-formulario" class="boton-cerrar">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <!-- formulario para que el usuario escriba su reseña -->
                    <form id="nueva-resena">
                        <div class="grupo-formulario">
                            <label for="titulo-resena">Título de la reseña</label>
                            <input type="text" id="titulo-resena" name="titulo-resena" placeholder="Ej: ¡Una experiencia increíble!">
                            <div class="alert alert-danger error-msg" id="error-titulo-resena"></div>
                        </div>
                        <div class="grupo-formulario">
                            <label>Tu puntuación</label>
                            <div class="rating-estrellas">
                                <input type="radio" id="estrella5" name="rating" value="5">
                                <label for="estrella5" class="estrella"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrella4" name="rating" value="4">
                                <label for="estrella4" class="estrella"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrella3" name="rating" value="3">
                                <label for="estrella3" class="estrella"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrella2" name="rating" value="2">
                                <label for="estrella2" class="estrella"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="estrella1" name="rating" value="1">
                                <label for="estrella1" class="estrella"><i class="bi bi-star-fill"></i></label>
                            </div>
                            <div class="alert alert-danger error-msg" id="error-rating"></div>
                        </div>
                        <div class="grupo-formulario">
                            <label for="texto-resena">Tu reseña</label>
                            <textarea id="texto-resena" name="texto-resena" rows="5" placeholder="Comparte tus experiencias con este juego..."></textarea>
                            <div class="alert alert-danger error-msg" id="error-texto-resena"></div>
                        </div>
                        <div class="acciones-formulario">
                            <button type="button" id="cancelar-resena" class="boton-secundario">Cancelar</button>
                            <button type="submit" class="boton-primario">Enviar reseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.baseUrl = "<?= base_url() ?>";
    window.gameId = <?= esc($juego['game_id']) ?>;
    window.guardarResenaUrl = "<?= base_url('juego/' . $juego['game_id'] . '/guardar-resena') ?>";
    window.isUserLoggedIn = <?= session()->has('user_id') ? 'true' : 'false' ?>;
    window.loginUrl = "<?= base_url('login') ?>";
</script>