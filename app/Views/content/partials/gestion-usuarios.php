<!-- seccion de usuarios -->
<div class="section-header">
    <h2><i class="bi bi-people-fill"></i> Gestión de Usuarios</h2>
    <div class="header-actions">
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

<!-- paginacion header -->
<div id="pagination-container" class="user-pagination">
    <?php
    // mostrar numeros de pagina
    $start = max(1, $currentUserPage - 2);
    $end = min($totalUserPages, $currentUserPage + 2);
    $baseUrl = base_url('/admin-section/admin-usuarios');
    ?>
    <?php if ($start > 1): ?>
        <button class="user-pagination-button <?= 1 == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?user_page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="user-pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="user-pagination-button <?= $i == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?user_page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalUserPages): ?>
        <?php if ($end < $totalUserPages - 1): ?>
            <span class="user-pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="user-pagination-button <?= $totalUserPages == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?user_page=<?= $totalUserPages ?>"><?= $totalUserPages ?></a>
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
                        <img src="<?php echo base_url('assets/uploads/profile_imgs/' . $usuario['user_img']) ?>" alt="Avatar" class="td-user-avatar">
                    </td>
                    <td><?= esc($usuario['email']) ?></td>
                    <td><?= esc($usuario['nickname']) ?></td>
                    <td><?= $usuario['created_at'] ?></td>
                    <td><?= $usuario['last_login'] ?></td>
                    <td>
                        <div class="action-buttons">
                            <?php if (!$usuario['is_active'] == 0): ?>
                                <button data-id="<?= $usuario['user_id'] ?>" class="btn-icon btn-ban btn-ban-user" title="Banear">
                                    <i class="bi bi-ban"></i>
                                </button>
                            <?php endif; ?>
                            <?php if (!$usuario['is_active'] == 1): ?>
                                <button data-id="<?= $usuario['user_id'] ?>" class="btn-icon btn-active btn-desban-user" title="Desbanear">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- paginacion footer -->
<div id="pagination-container" class="user-pagination">
    <?php
    // mostrar numeros de pagina
    $start = max(1, $currentUserPage - 2);
    $end = min($totalUserPages, $currentUserPage + 2);
    $baseUrl = base_url('/admin-section/admin-usuarios');
    ?>
    <?php if ($start > 1): ?>
        <button class="user-pagination-button <?= 1 == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?user_page=1">1</a>
        </button>
        <?php if ($start > 2): ?>
            <span class="user-pagination-ellipsis">...</span>
        <?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <button class="user-pagination-button <?= $i == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?user_page=<?= $i ?>"><?= $i ?></a>
        </button>
    <?php endfor; ?>

    <?php if ($end < $totalUserPages): ?>
        <?php if ($end < $totalUserPages - 1): ?>
            <span class="user-pagination-ellipsis">...</span>
        <?php endif; ?>
        <button class="user-pagination-button <?= $totalUserPages == $currentUserPage ? 'active' : '' ?>">
            <a href="<?= $baseUrl ?>?user_page=<?= $totalUserPages ?>"><?= $totalUserPages ?></a>
        </button>
    <?php endif; ?>
</div>