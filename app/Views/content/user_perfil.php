<section class="user-panel" style="margin-top: 50px;">

    <aside class="user-sidebar">
        <div class="user-profile">
            <!-- Foto de perfil del usuario -->
            <img src="<?php echo base_url('assets/uploads/profile_imgs/' . session('user_img')) ?>" alt="User Avatar" class="user-avatar" id="userCurrentProfileImage" height="120" width="120">
            <h3 class="user-username"><?= session('nickname') ?></h3>
            <span class="user-role">
                Miembro desde: <?= date('M Y', strtotime($usuario['created_at'])) ?>
            </span>

            <!-- boton para cambiar imagen -->
            <a class="change-profile-link" id="userChangeProfileBtn" style="text-decoration: none; margin-right: 5px;">
                <i class="bi bi-camera-fill"></i> Cambiar imagen
            </a>

            <!-- formulario oculto para subir imagen -->
            <form id="userProfileImageForm" action="<?= base_url('user-profile/subir-foto') ?>" method="post" enctype="multipart/form-data" style="display: none;">
                <?= csrf_field() ?>
                <input type="file" name="profile_image" id="userProfileImageInput" accept="image/jpeg,image/png">
            </form>
        </div>

        <nav class="user-menu">
            <ul>
                <li class="menu-item active" data-section="perfil">
                    <i class="bi bi-person-fill"></i>
                    <span>Mi Perfil</span>
                </li>
                <li class="menu-item" data-section="deseados">
                    <i class="bi bi-heart-fill"></i>
                    <span>Lista de Deseados</span>
                </li>
                <li class="menu-item" data-section="compras">
                    <i class="bi bi-receipt"></i>
                    <span>Mis Compras</span>
                </li>
            </ul>
        </nav>

        <!-- logout -->
        <div class="user-logout">
            <form action="<?= base_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button class="logout-btn" type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <!-- Contenido principal -->
    <main class="user-content">

        <!-- Sección de Perfil -->
        <div id="perfil-section" class="content-section active">
            <div class="main-user-profile">
                <?= view('content/partials/main-user-profile', ['usuario' => $usuario ?? []]) ?>
            </div>
        </div>

        <!-- Sección de Compras -->
        <div id="compras-section" class="content-section">
            <div class="compras-user-profile">
                <?= view('content/partials/compras-user-profile', ['compras' => $compras ?? []]) ?>
            </div>
        </div>

        <!-- Sección de Lista de Deseados -->
        <div id="deseados-section" class="content-section">
            <div class="wishlist-user-profile">
                <?= view('content/partials/wishlist-user-profile', ['deseados' => $deseados ?? []]) ?>
            </div>
        </div>
    </main>
</section>