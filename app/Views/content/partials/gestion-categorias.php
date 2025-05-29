<div class="section-header">
    <h2><i class="bi bi-tags-fill"></i> Gestión de Categorías</h2>
    <div class="header-actions">
        <button class="btn btn-primary" id="add-category-btn">
            <i class="bi bi-plus-lg"></i> Nueva Categoría
        </button>
    </div>
</div>

<!-- Formulario para agregar/editar (oculto inicialmente) -->
<div id="category-form-container" class="form-container" style="display: none;">
    <form id="category-form">
        <input type="hidden" id="category-id" name="category_id" value="">

        <div class="form-group">
            <label for="category-name">Nombre*</label>
            <input type="text" id="category-name" name="name" required placeholder="Ej: RPG">
        </div>

        <div class="form-group">
            <label for="category-slug">Slug*</label>
            <input type="text" id="category-slug" name="slug" required placeholder="Ej: juegos-rpg">
        </div>

        <div class="form-group">
            <label for="category-icon">Icono (Bootstrap Icons)</label>
            <div class="icon-selector">
                <input type="text" id="category-icon" name="icon" placeholder="Ej: bi-controller">
                <div class="icon-preview">
                    <i id="icon-preview" class="bi bi-question-circle"></i>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn btn-secondary" id="cancel-category">
                Cancelar
            </button>
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
                <th>Icono</th>
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
                    <td><i class="bi bi-dice-5"></i></td>
                    <td><?= $categoria['juegos_count'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-edit" title="Editar" data-id="1">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn-icon btn-danger" title="Eliminar" data-id="1">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal de confirmación -->
<div id="delete-category-modal" class="admin-modal">
    <div class="modal-content">
        <h3><i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación</h3>
        <p>¿Estás seguro de eliminar la categoría "<span id="category-to-delete"></span>"?</p>
        <div class="modal-actions">
            <button class="btn btn-secondary" id="cancel-delete">Cancelar</button>
            <button class="btn btn-danger" id="confirm-delete">Eliminar</button>
        </div>
    </div>
</div>