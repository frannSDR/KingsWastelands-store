<!-- seccion de usuarios -->
<div class="section-header">
    <h2><i class="bi bi-people-fill"></i> Gestión de Usuarios</h2>
    <div class="header-actions">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="user-search" placeholder="Buscar usuarios...">
        </div>
    </div>
</div>

<!-- paginacion header -->
<div id="pagination-container" class="pagination">
    <?php
    // mostrar numeros de pagina
    $start = max(1, $currentUserPage - 2);
    $end = min($totalUserPages, $currentUserPage + 2);
    $baseUrl = base_url('/perfil/admin-usuarios');
    ?>
    <?php if ($start > 1): ?>
        <button class="user-pagination-button <?= 1 == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="user-pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="user-pagination-button <?= $i == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalUserPages): ?>
        <?php if ($end < $totalUserPages - 1): ?>
            <span class="user-pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="user-pagination-button <?= $totalUserPages == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $totalUserPages ?>"><?= $totalUserPages ?></a>
        </button>
    <?php endif; ?>
</div>

<div class="admin-table-container">
    <table class="users-admin-table">
        <thead>
            <tr>
                <th>ID </th>
                <th>Avatar</th>
                <th>Email </th>
                <th>Nickname</th>
                <th>Fecha Registro </th>
                <th>Último Login </th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['user_id'] ?></td>
                    <td>
                        <img src="https://via.placeholder.com/40" alt="Avatar" class="user-avatar">
                    </td>
                    <td><?= esc($usuario['email']) ?></td>
                    <td><?= esc($usuario['nickname']) ?></td>
                    <td><?= $usuario['created_at'] ?></td>
                    <td><?= $usuario['last_login'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-edit" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn-icon btn-ban" title="Banear">
                                <i class="bi bi-slash-circle"></i>
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

<!-- paginacion footer -->
<div id="pagination-container" class="pagination">
    <?php
    // mostrar numeros de pagina
    $start = max(1, $currentUserPage - 2);
    $end = min($totalUserPages, $currentUserPage + 2);
    $baseUrl = base_url('/perfil/admin-users');
    ?>
    <?php if ($start > 1): ?>
        <button class="user-pagination-button <?= 1 == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="user-pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="user-pagination-button <?= $i == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalUserPages): ?>
        <?php if ($end < $totalUserPages - 1): ?>
            <span class="pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="user-pagination-button <?= $totalUserPages == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?page=<?= $totalUserPages ?>"><?= $totalUserPages ?></a>
        </button>
    <?php endif; ?>
</div>