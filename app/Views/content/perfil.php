<section class="admin-panel" style="margin-top: 50px;">

    <aside class="admin-sidebar">
        <div class="admin-profile">
            <!-- Mostrar la imagen actual del usuario -->
            <img src="<?php echo base_url('assets/uploads/profile_imgs/' . session('user_img')) ?>" alt="Admin Avatar" class="admin-avatar" id="currentProfileImage" height="120" width="120">
            <h3 class="admin-username"><?= session('nickname') ?></h3>
            <span class="admin-role">Administrador</span>

            <!-- Botón/Enlace para cambiar imagen -->
            <a class="change-profile-link" id="changeProfileBtn" style="text-decoration: none; margin-right: 5px;">
                <i class="bi bi-camera-fill"></i> Cambiar imagen
            </a>

            <!-- Formulario oculto para subir imagen -->
            <form id="profileImageForm" action="<?= base_url('perfil/subir-foto') ?>" method="post" enctype="multipart/form-data" style="display: none;">
                <?= csrf_field() ?>
                <input type="file" name="profile_image" id="profileImageInput" accept="image/jpeg,image/png">
            </form>
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

    <!-- Contenido principal -->
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

        <!-- seccion de Categorías -->
        <div id="categorias-section" class="content-section">
            <div id="categorias-list-container">
                <?= view('content/partials/gestion-categorias', [
                    'categorias' => $categorias ?? [],
                    'currentPage' => $currentCatPage ?? 1,
                    'totalPages' => $totalCatPages ?? 1
                ]) ?>
            </div>
        </div>

        <!-- Sección de Compras -->
        <div id="compras-section" class="content-section">
            <h2><i class="bi bi-cart-check-fill"></i> Administrar Compras</h2>
            <!-- Contenido de compras -->
        </div>
    </main>
</section>