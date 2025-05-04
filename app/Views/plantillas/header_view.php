<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $titulo ?? '' ?></title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/lightbox.css" rel="stylesheet" />
  <link href="assets/css/miestilo.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/9984108ce5.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <header>
    <!-- logo de la pagina  -->
    <h1><a class="logo" href="<?php echo base_url('/') ?>"><img class="logo_img" src="assets/img/dslogo.png" alt="logo"></a></h1>

    <!-- navbar de la pagina -->
    <nav>
      <ul class="nav_links">
        <li class="dropdown1">
          <a href="#">Categorias <i class="bi bi-chevron-down"></i></a>
          <ul class="dropdown2">
            <li><a href="<?php echo base_url('accion') ?>">Acción</a></li>
            <li><a href="<?php echo base_url('aventura') ?>">Aventura</a></li>
            <li><a href="<?php echo base_url('terror') ?>">Terror</a></li>
            <li><a href="<?php echo base_url('indie') ?>">Indie</a></li>
            <li><a href="<?php echo base_url('estrategia') ?>">Estrategia</a></li>
          </ul>
        </li>
        <li><a href="<?php echo base_url('populares') ?>">Populares</a></li>
        <li><a href="<?php echo base_url('ofertas') ?>">Ofertas</a></li>
        <li><a href="<?php echo base_url('nosotros') ?>">Quienes somos</a></li>

        <!-- opciones que solo aparecen en el menu hamburguesa(responsive) -->
        <li class="mobile-only"><a href="#" class="mobile-cart">Carrito de compras <i class="bi bi-cart"></i><span class="mobile-cart-count"></span></a></li>
      </ul>
    </nav>

    <!-- Contenedor para los elementos de la derecha -->
    <div class="right-header">
      <div class="header-action">
        <a id="cart-icon" class="cart_icon desktop-only" href="#"><i class="bi bi-cart"></i></a>
        <span class="cart-item-count desktop-only"></span>
        <a class="login_icon" href="#"><i class="bi bi-person-circle"></i></a>
      </div>

      <!-- menu hamburguesa responsive -->
      <div class="menu-toggle">
        <i class="bi bi-list"></i>
      </div>
    </div>
  </header>