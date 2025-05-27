<section class="admin-panel" style="margin-top: 50px;">

    <!-- Barra lateral de navegación -->
    <aside class="admin-sidebar">
        <div class="admin-profile">
            <img src="https://i.ibb.co/tTSsBgtP/sif.gif" alt="Admin Avatar" class="admin-avatar">
            <h3 class="admin-username"><?= session('nickname') ?></h3>
            <span class="admin-role">Administrador</span>
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
        <!-- seccion de usuarios (activa por defecto) -->
        <div id="usuarios-section" class="content-section active">
            <div id="usuarios-list-container">
                <?= view('content/partials/gestion-usuarios', [
                    'usuarios' => $usuarios ?? [],
                    'currentPage' => $currentPage ?? 1,
                    'totalPages' => $totalPages ?? 1
                ]) ?>
            </div>
        </div>

        <!-- Sección de Juegos (incluye el formulario que ya creamos) -->
        <div id="juegos-section" class="content-section">
            <div id="games-list-container">
                <?= view('content/partials/gestion-juegos', [
                    'juegos' => $juegos ?? [],
                    'currentPage' => $currentPage ?? 1,
                    'totalPages' => $totalPages ?? 1
                ]) ?>
            </div>
        </div>

        <!-- Sección de Categorías -->
        <div id="categorias-section" class="content-section">
            <div id="categorias-list-container">
                <?= view('content/partials/gestion-categorias', [
                    'categorias' => $categorias ?? [],
                    'currentPage' => $currentPage ?? 1,
                    'totalPages' => $totalPages ?? 1
                ]) ?>
            </div>

            <!-- Sección de Compras -->
            <div id="compras-section" class="content-section">
                <h2><i class="bi bi-cart-check-fill"></i> Administrar Compras</h2>
                <!-- Contenido de compras -->
            </div>
    </main>
</section>