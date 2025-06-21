<!-- foreach para cada reseña -->
<?php foreach ($reviews as $review): ?>
    <?php
    $likes = model('ReviewHelpfulModel')
        ->where('review_id', $review['review_id'])
        ->where('is_helpful', 1)
        ->countAllResults();

    $dislikes = model('ReviewHelpfulModel')
        ->where('review_id', $review['review_id'])
        ->where('is_helpful', 0)
        ->countAllResults();
    ?>
    <?php if (session('error-msg')): ?>
        <div class="alert alert-danger">
            <?= session('error-msg') ?>
        </div>
    <?php endif; ?>
    <div class="resena-usuario">
        <div class="encabezado-resena">
            <div class="info-usuario">
                <img src="<?php echo base_url('assets/uploads/profile_imgs/' . $review['user_img']) ?>" alt="Avatar de usuario" class="avatar-usuario">
                <div class="detalles-usuario">
                    <div class="nombre-usuario"><?= esc($review['nickname']) ?></div>
                    <div class="info-compra"><i class="bi bi-patch-check-fill"></i> Compra verificada</div>
                </div>
            </div>
            <div class="valoracion-fecha">
                <div class="estrellas-usuario">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?>"></i>
                    <?php endfor; ?>
                </div>
                <div class="fecha-resena"><?= date('d M Y', strtotime($review['created_at'])) ?></div>
            </div>
        </div>
        <div class="contenido-resena">
            <?php if (!empty($review['review_text'])): ?>
                <h3 class="titulo-resena"><?= esc($review['review_title'] ?? 'Sin título') ?></h3>
                <p><?= nl2br(esc($review['review_text'])) ?></p>
            <?php endif; ?>
            <div class="controles-resena">
                <div class="utilidad-resena" data-review-id="<?= $review['review_id'] ?>">
                    <span>¿Te ha resultado útil?</span>
                    <button class="boton-utilidad like">Sí (<?= $likes ?>)</button>
                    <button class="boton-utilidad dislike">No (<?= $dislikes ?>)</button>
                </div>
                <?php if (session()->get('is_admin') == 1): ?>
                    <button class="boton-reportar">Eliminar</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- paginacion -->
<?php if ($pager && $pager->hasMore()): ?>
    <div class="paginacion-resenas">
        <?= $pager->links('reviews', 'default_full') ?>
    </div>
<?php endif; ?>
<!-- seccion para poder escribir las reseñas -->
<div class="escribir-resena">
    <h3>¿Has jugado este juego?</h3>
    <?php if (session()->has('user_id')): ?>
        <button class="boton-escribir-resena">Escribe tu reseña</button>
    <?php else: ?>
        <a href="<?= base_url('login') ?>" class="boton-escribir-resena" style="text-decoration:none;">Inicia sesión para reseñar</a>
    <?php endif; ?>
</div>
<?php if (empty($reviews)): ?>
    <div class="sin-resenas">
        <p>Este juego aún no tiene reseñas. ¡Sé el primero en opinar!</p>
    </div>
<?php endif; ?>