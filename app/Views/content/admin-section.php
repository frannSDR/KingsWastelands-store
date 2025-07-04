<script>
    document.body.classList.add('admin-page');
</script>

<section class="admin-panel" style="margin-top: 50px;">

    <!-- Botón hamburguesa para abrir el menú lateral -->
    <button class="admin-sidebar-toggle" aria-label="Abrir menú">
        <i class="bi bi-list"></i>
    </button>
    <!-- Overlay para cerrar el menú al hacer click fuera -->
    <div class="admin-sidebar-overlay"></div>

    <aside class="admin-sidebar">
        <div class="admin-profile">
            <!-- mostrar la imagen actual del usuario -->
            <img src="<?php echo base_url('assets/uploads/profile_imgs/' . session('user_img')) ?>" alt="Admin Avatar" class="admin-avatar" id="currentProfileImage" height="120" width="120">
            <h3 class="admin-username"><?= session('nickname') ?></h3>
            <span class="admin-role">Administrador</span>

            <!-- boton/enlace para cambiar imagen -->
            <a class="change-profile-link" id="changeProfileBtn" style="text-decoration: none; margin-right: 5px;">
                <i class="bi bi-camera-fill"></i> Cambiar imagen
            </a>

            <!-- formulario oculto para subir imagen -->
            <form id="profileImageForm" action="<?= base_url('/admin-section/subir-foto') ?>" method="post" enctype="multipart/form-data" style="display: none;">
                <?= csrf_field() ?>
                <input type="file" name="profile_image" id="profileImageInput" accept="image/jpeg,image/png">
            </form>
            <?php if ($errors = session('error-msg')): ?>
                <?php foreach ((array)$errors as $msg): ?>
                    <div class="alert alert-danger"><?= esc($msg) ?></div>
                <?php endforeach; ?>
            <?php elseif (session('exito-msg')): ?>
                <div class="alert alert-success">
                    <?= session('exito-msg') ?>
                </div>
            <?php endif; ?>
        </div>

        <nav class="admin-menu">
            <ul>
                <li class="menu-item active" data-section="usuarios">
                    <i class="bi bi-people-fill"></i>
                    <span>Gestión de Usuarios</span>
                </li>
                <li class="menu-item" data-section="juegos">
                    <i class="bi bi-controller"></i>
                    <span>Gestión de Juegos</span>
                </li>
                <li class="menu-item" data-section="categorias">
                    <i class="bi bi-tags-fill"></i>
                    <span>Gestión de Categorías</span>
                </li>
                <li class="menu-item" data-section="compras">
                    <i class="bi bi-cart-check-fill"></i>
                    <span>Administrar Compras</span>
                </li>
            </ul>
        </nav>

        <!-- logout -->
        <div class="admin-logout">
            <form action="<?= base_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button class="logout-btn" type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <!-- contenido principal -->
    <main class="admin-content">

        <!-- seccion de usuarios -->
        <div id="usuarios-section" class="content-section active">
            <div id="usuarios-list-container">
                <?= view('content/partials/gestion-usuarios', [
                    'usuarios' => $usuarios ?? [],
                    'currentUserPage' => $userPage ?? 1,
                    'totalUserPages' => $userTotalPages ?? 1
                ]) ?>
            </div>
        </div>

        <!-- seccion de juegos -->
        <div id="juegos-section" class="content-section">
            <div id="games-list-container">
                <?= view('content/partials/gestion-juegos', [
                    'juegos' => $juegos ?? [],
                    'currentGamesPage' => $gamesPage ?? 1,
                    'totalGamesPages' => $gamesTotalPages ?? 1
                ]) ?>
            </div>
        </div>

        <!-- seccion de categorías -->
        <div id="categorias-section" class="content-section">
            <div id="categorias-list-container">
                <?= view('content/partials/gestion-categorias', [
                    'categorias' => $categorias ?? [],
                    'currentPage' => $currentCatPage ?? 1,
                    'totalPages' => $totalCatPages ?? 1
                ]) ?>
            </div>
        </div>

        <!-- Sección de compras -->
        <div id="compras-section" class="content-section">
            <div id="ventas-list-container">
                <?= view('content/partials/gestion-ordenes', [
                    'compras' => $compras ?? [],
                    'currentVentasPage' => $currentVentasPage ?? 1,
                    'totalVentasPages' => $totalVentasPages ?? 1
                ]) ?>
            </div>
        </div>
    </main>
</section>