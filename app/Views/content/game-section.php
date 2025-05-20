<!-- banner del juego -->
<div class="game-banner" style="background-image: url('<?= $juego['banner_image_url'] ?>');">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h1><?= esc($juego['title']) ?></h1>
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
                <div class="platform-tags">
                    <span class="platform-tag">Steam</span>
                    <span class="platform-tag">GOG</span>
                </div>
            </div>
            <div class="game-details">
                <div class="game-meta">
                    <span class="meta-item"><i class="bi bi-calendar"></i> <?= date('d M Y', strtotime($juego['release_date'])) ?></span>
                    <span class="meta-item"><i class="bi bi-people"></i> <?= esc($juego['developer']) ?></span>
                    <span class="meta-item"><i class="bi bi-tags"></i>
                        <?php foreach ($categorias as $categoria): ?>
                            <a href="/<?= $categoria['slug'] ?>"><?= $categoria['name_cat'] ?></a><?= !end($categorias) ? ', ' : '' ?>
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

                        <!-- si el juego tiene descuento se aplica (deshabilitada por ahora) -->
                        <?php if (isset($juego['discount']) && $juego['discount'] > 0): ?>
                            <span class="discount-badge">-<?= $juego['discount'] ?>%</span>
                            <span class="current-price">$<?= number_format($juego['price'] * (1 - $juego['discount'] / 100), 2) ?></span>
                        <?php endif; ?>
                    </div>
                    <button class="add-to-cart-btn">
                        <i class="bi bi-cart-plus"></i> Añadir al carrito
                    </button>
                    <button class="wishlist-btn">
                        <i class="bi bi-heart"></i> Lista de deseos
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
                    <div class="puntuacion-numero">4.8</div>
                    <div class="estrellas">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <div class="total-resenas">Basado en 843 reseñas</div>
                </div>
                <div class="distribucion-puntuacion">
                    <div class="barra-puntuacion">
                        <span class="etiqueta-estrellas">5 <i class="bi bi-star-fill"></i></span>
                        <div class="barra-contenedor">
                            <div class="barra-progreso" style="width: 75%"></div>
                        </div>
                        <span class="porcentaje">75%</span>
                    </div>
                    <div class="barra-puntuacion">
                        <span class="etiqueta-estrellas">4 <i class="bi bi-star-fill"></i></span>
                        <div class="barra-contenedor">
                            <div class="barra-progreso" style="width: 18%"></div>
                        </div>
                        <span class="porcentaje">18%</span>
                    </div>
                    <div class="barra-puntuacion">
                        <span class="etiqueta-estrellas">3 <i class="bi bi-star-fill"></i></span>
                        <div class="barra-contenedor">
                            <div class="barra-progreso" style="width: 5%"></div>
                        </div>
                        <span class="porcentaje">5%</span>
                    </div>
                    <div class="barra-puntuacion">
                        <span class="etiqueta-estrellas">2 <i class="bi bi-star-fill"></i></span>
                        <div class="barra-contenedor">
                            <div class="barra-progreso" style="width: 1%"></div>
                        </div>
                        <span class="porcentaje">1%</span>
                    </div>
                    <div class="barra-puntuacion">
                        <span class="etiqueta-estrellas">1 <i class="bi bi-star-fill"></i></span>
                        <div class="barra-contenedor">
                            <div class="barra-progreso" style="width: 1%"></div>
                        </div>
                        <span class="porcentaje">1%</span>
                    </div>
                </div>
            </div>

            <div class="filtros-resenas">
                <div class="selector-orden">
                    <label for="orden-resenas">Ordenar por:</label>
                    <select id="orden-resenas" name="orden-resenas">
                        <option value="recientes">Más recientes</option>
                        <option value="mejores">Mejor valoradas</option>
                        <option value="criticas">Más críticas</option>
                    </select>
                </div>
                <div class="filtro-estrellas">
                    <span class="filtro-texto">Filtrar:</span>
                    <button class="boton-filtro activo">Todas</button>
                    <button class="boton-filtro">5★</button>
                    <button class="boton-filtro">4★</button>
                    <button class="boton-filtro">3★</button>
                    <button class="boton-filtro">2★</button>
                    <button class="boton-filtro">1★</button>
                </div>
            </div>

            <div class="lista-resenas">
                <!-- Reseña 1 -->
                <div class="resena-usuario">
                    <div class="encabezado-resena">
                        <div class="info-usuario">
                            <img src="/api/placeholder/40/40" alt="Avatar de usuario" class="avatar-usuario">
                            <div class="detalles-usuario">
                                <div class="nombre-usuario">Elpe_lado23</div>
                                <div class="info-compra"><i class="bi bi-patch-check-fill"></i> Compra verificada</div>
                            </div>
                        </div>
                        <div class="valoracion-fecha">
                            <div class="estrellas-usuario">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="fecha-resena">27 abril 2025</div>
                        </div>
                    </div>
                    <div class="contenido-resena">
                        <h3 class="titulo-resena">¡Una obra maestra renovada!</h3>
                        <p>Esta remasterización es exactamente lo que los fans llevábamos años esperando. Los gráficos han sido completamente actualizados respetando el estilo artístico original, y las mejoras en la jugabilidad hacen que sea mucho más accesible para los nuevos jugadores. La iluminación dinámica y los efectos atmosféricos le dan nueva vida a Cyrodiil. Además, han solucionado muchos de los bugs clásicos que tenía el juego original.</p>
                        <div class="horas-jugadas">Horas jugadas: 47</div>
                        <div class="controles-resena">
                            <div class="utilidad-resena">
                                <span>¿Te ha resultado útil?</span>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-up"></i> Sí (34)</button>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-down"></i> No (2)</button>
                            </div>
                            <button class="boton-reportar">Reportar</button>
                        </div>
                    </div>
                </div>

                <!-- Reseña 2 -->
                <div class="resena-usuario">
                    <div class="encabezado-resena">
                        <div class="info-usuario">
                            <img src="/api/placeholder/40/40" alt="Avatar de usuario" class="avatar-usuario">
                            <div class="detalles-usuario">
                                <div class="nombre-usuario">rrshk</div>
                                <div class="info-compra"><i class="bi bi-patch-check-fill"></i> Compra verificada</div>
                            </div>
                        </div>
                        <div class="valoracion-fecha">
                            <div class="estrellas-usuario">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="fecha-resena">25 abril 2025</div>
                        </div>
                    </div>
                    <div class="contenido-resena">
                        <h3 class="titulo-resena">Muy bueno, pero con algunos detalles mejorables</h3>
                        <p>El trabajo de remasterización es impresionante en términos visuales. La interfaz de usuario modernizada y los controles revisados son un gran acierto. Mi única queja es que algunos de los sistemas más antiguos, como el de persuasión con la rueda de diálogo, podrían haberse renovado más profundamente. Aun así, es una experiencia fantástica y la nostalgia está intacta. El sistema de combate sigue siendo algo rígido comparado con los estándares actuales.</p>
                        <div class="horas-jugadas">Horas jugadas: 32</div>
                        <div class="controles-resena">
                            <div class="utilidad-resena">
                                <span>¿Te ha resultado útil?</span>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-up"></i> Sí (28)</button>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-down"></i> No (5)</button>
                            </div>
                            <button class="boton-reportar">Reportar</button>
                        </div>
                    </div>
                </div>

                <!-- Reseña 3 -->
                <div class="resena-usuario">
                    <div class="encabezado-resena">
                        <div class="info-usuario">
                            <img src="/api/placeholder/40/40" alt="Avatar de usuario" class="avatar-usuario">
                            <div class="detalles-usuario">
                                <div class="nombre-usuario">Martin_tillo</div>
                                <div class="info-compra"><i class="bi bi-patch-check-fill"></i> Compra verificada</div>
                            </div>
                        </div>
                        <div class="valoracion-fecha">
                            <div class="estrellas-usuario">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="fecha-resena">23 abril 2025</div>
                        </div>
                    </div>
                    <div class="contenido-resena">
                        <h3 class="titulo-resena">Superó todas mis expectativas</h3>
                        <p>Como veterano que jugó el Oblivion original cuando salió en 2006, tenía mis dudas sobre esta remasterización. ¡Pero vaya sorpresa! No solo han mejorado los gráficos, sino que han refinado muchos de los sistemas del juego. El equilibrio de las clases está mejor logrado, la IA de los NPCs es más inteligente, y los tiempos de carga son prácticamente inexistentes. Las misiones del Gremio de Ladrones siguen siendo mis favoritas. 100% recomendado tanto para veteranos como para nuevos jugadores.</p>
                        <div class="horas-jugadas">Horas jugadas: 78</div>
                        <div class="controles-resena">
                            <div class="utilidad-resena">
                                <span>¿Te ha resultado útil?</span>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-up"></i> Sí (52)</button>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-down"></i> No (1)</button>
                            </div>
                            <button class="boton-reportar">Reportar</button>
                        </div>
                    </div>
                </div>

                <!-- Reseña 4 -->
                <div class="resena-usuario">
                    <div class="encabezado-resena">
                        <div class="info-usuario">
                            <img src="/api/placeholder/40/40" alt="Avatar de usuario" class="avatar-usuario">
                            <div class="detalles-usuario">
                                <div class="nombre-usuario">Moya_Nico</div>
                                <div class="info-compra"><i class="bi bi-patch-check-fill"></i> Compra verificada</div>
                            </div>
                        </div>
                        <div class="valoracion-fecha">
                            <div class="estrellas-usuario">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="fecha-resena">22 abril 2025</div>
                        </div>
                    </div>
                    <div class="contenido-resena">
                        <h3 class="titulo-resena">Mejorado pero aún con problemas</h3>
                        <p>Si bien los gráficos son impresionantes y la música sigue siendo legendaria, me decepciona que algunos problemas fundamentales del diseño original no se hayan abordado. El sistema de nivelación de enemigos sigue haciendo que el juego sea más difícil a medida que subes de nivel, lo que resulta contraproducente. También he experimentado varios cuelgues en las secciones de las Puertas de Oblivion. Es una buena remasterización, pero no tan pulida como esperaba por este precio.</p>
                        <div class="horas-jugadas">Horas jugadas: 12</div>
                        <div class="controles-resena">
                            <div class="utilidad-resena">
                                <span>¿Te ha resultado útil?</span>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-up"></i> Sí (15)</button>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-down"></i> No (8)</button>
                            </div>
                            <button class="boton-reportar">Reportar</button>
                        </div>
                    </div>
                </div>

                <!-- Reseña 5 -->
                <div class="resena-usuario">
                    <div class="encabezado-resena">
                        <div class="info-usuario">
                            <img src="/api/placeholder/40/40" alt="Avatar de usuario" class="avatar-usuario">
                            <div class="detalles-usuario">
                                <div class="nombre-usuario">moriniga</div>
                                <div class="info-compra"><i class="bi bi-patch-check-fill"></i> Compra verificada</div>
                            </div>
                        </div>
                        <div class="valoracion-fecha">
                            <div class="estrellas-usuario">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <div class="fecha-resena">22 abril 2025</div>
                        </div>
                    </div>
                    <div class="contenido-resena">
                        <h3 class="titulo-resena">Mi primera experiencia con Oblivion</h3>
                        <p>Nunca jugué al original, así que esta remasterización ha sido mi primera toma de contacto con Oblivion. ¡Y qué descubrimiento! Ahora entiendo por qué este juego es tan querido. El mundo es increíblemente inmersivo, las misiones son variadas y la libertad que te da es asombrosa. Como jugadora de Skyrim, me ha sorprendido lo profundos que son algunos sistemas en comparación. Los gremios tienen líneas argumentales mucho más elaboradas. El sistema de creación de hechizos es adictivo.</p>
                        <div class="horas-jugadas">Horas jugadas: 25</div>
                        <div class="controles-resena">
                            <div class="utilidad-resena">
                                <span>¿Te ha resultado útil?</span>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-up"></i> Sí (20)</button>
                                <button class="boton-utilidad"><i class="bi bi-hand-thumbs-down"></i> No (1)</button>
                            </div>
                            <button class="boton-reportar">Reportar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="paginacion-resenas">
                <button class="boton-pagina activo">1</button>
                <button class="boton-pagina">2</button>
                <button class="boton-pagina">3</button>
                <button class="boton-pagina">4</button>
                <button class="boton-pagina">...</button>
                <button class="boton-pagina">42</button>
                <button class="boton-pagina siguiente">Siguiente <i class="bi bi-chevron-right"></i></button>
            </div>

            <div class="escribir-resena">
                <h3>¿Has jugado este juego?</h3>
                <button class="boton-escribir-resena">Escribe tu reseña</button>
            </div>
        </div>
    </div>
</div>