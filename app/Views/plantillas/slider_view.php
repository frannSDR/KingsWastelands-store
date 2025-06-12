    <!-- slider -->
    <div class="slider-container">
      <?php foreach ($juegosPopulares as $juego): ?>
        <div class="slide">
          <img src="<?= $juego['banner_image_url'] ?>" alt="Foto de <?= esc($juego['title']) ?>" border="0">
          <div class="slide-content">
            <h1><?= esc($juego['title']) ?></h1>
            <p><?= esc($juego['about']) ?></p>
            <button>$<?= $juego['price'] ?></button>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- botones para controlar el slider -->
      <button class="nav-button nav-left">&#10094;</button>
      <button class="nav-button nav-right">&#10095;</button>
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