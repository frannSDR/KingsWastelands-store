<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $titulo ?? '' ?></title>
  <link href="<?= base_url('assets/css/bootstrap/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/lightbox/lightbox.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/home.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/header.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/login-register.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/cart.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/comercializacion.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/footer.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/games.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/game-section.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/quienes-somos.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/reglas-terminos.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/contacto.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/admin.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/user_perfil.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/mensajes.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/ofertas.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/prox-lanzamientos.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/destacados.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/pago.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/components/confirmacion.css') ?>" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/9984108ce5.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
  <header>
    <!-- logo de la pagina  -->
    <h1><a class="logo" href="<?php echo base_url('/') ?>"><img class="logo_img" src="<?= base_url('assets/img/dslogo.png') ?>" alt="logo"></a></h1>

    <!-- navbar de la pagina -->
    <nav>
      <ul class="nav_links">
        <li><a href="<?php echo base_url('ofertas') ?>">Ofertas</a></li>
        <li><a href="<?php echo base_url('prox-lanzamientos') ?>">Reservas</a></li>
        <li><a href="<?php echo base_url('juegos') ?>">Juegos</a></li>
        <li><a href="<?php echo base_url('nosotros') ?>">Quienes somos</a></li>
        <?php if (!session()->get('is_active')): ?>
          <li><a href="<?php echo base_url('login') ?>">Iniciar Sesion</a></li>
          <li><a href="<?php echo base_url('register') ?>">Registrarse</a></li>
        <?php else: ?>
          <?php if (session()->get('is_admin') == 1): ?>
            <li><a href="<?php echo base_url('admin-section') ?>">Admin</a></li>
          <?php endif; ?>
          <li><span style="color: #ccc; font-weight: 500; font-size: 14px;">Hola, <?= esc(session()->get('nickname')) ?></span></li>
          <li>
            <form action="<?= base_url('logout') ?>" method="post">
              <?= csrf_field() ?>
              <button class="logout-btn" type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
            </form>
          </li>
        <?php endif; ?>

        <!-- opciones que solo aparecen en el menu hamburguesa(responsive) -->
        <li class="mobile-only mobile-cart"><a href="<?php echo base_url('carrito') ?>">Mi Carrito <i class="bi bi-cart"></i></li>
        <li class="mobile-only mobile-cart"><a href="<?php echo base_url('user-profile') ?>">Perfil <i class="bi bi-person-circle"></i></li>
      </ul>
    </nav>

    <!-- Contenedor para los elementos de la derecha -->
    <div class="right-header">
      <div class="home-header-action">
        <a href="<?php echo base_url('carrito') ?>" class="cart-icon desktop-only"><i class="bi bi-cart"></i></a>
        <a href="<?php echo base_url('user-profile') ?>" class="login-icon desktop-only"><i class="bi bi-person-circle"></i></a>
      </div>

      <!-- menu hamburguesa responsive -->
      <div class="menu-toggle">
        <i class="bi bi-list"></i>
      </div>
    </div>
  </header>
  <div class="nav-overlay"></div>