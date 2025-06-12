<div class="section-header">
    <h2><i class="bi bi-tags-fill"></i> Gestión de Categorías</h2>
    <div class="header-actions">
        <button class="btn btn-primary" id="add-category-btn">
            <i class="bi bi-plus-lg"></i> Nueva Categoría
        </button>
    </div>
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

<!-- Formulario para agregar una categoria (oculto inicialmente) -->
<div id="category-form-container" class="form-container" style="display: none;">
    <form id="category-form" action="<?= base_url('/perfil/guardar-categoria') ?>" method="post">
        <div class="form-group">
            <label for="category-name">Nombre*</label>
            <input type="text" id="category-name" name="name_cat" required placeholder="Ej: RPG">
        </div>

        <div class="form-group">
            <label for="category-slug">Slug*</label>
            <input type="text" id="category-slug" name="slug" required placeholder="Ej: juegos-rpg">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <span id="category-submit-text">Guardar</span>
            </button>
        </div>
    </form>
</div>

<!-- Tabla de categorías -->
<div class="admin-table-container">
    <table class="category-admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Slug</th>
                <th>Juegos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['category_id'] ?></td>
                    <td><?= esc($categoria['name_cat']) ?></td>
                    <td><?= esc($categoria['slug']) ?></td>
                    <td><?= $categoria['juegos_count'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <button data-id="<?= $categoria['category_id'] ?>" class="btn-icon btn-danger btn-del-cat" title="Eliminar">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>