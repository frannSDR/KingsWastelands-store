<section class="auth-section login-page">
    <div class="auth-container">
        <div class="auth-form-container">
            <form action="<?php echo base_url('procesar_login') ?>" method="POST" class="auth-form">
                <h1 class="auth-title">Inicio de Sesión</h1>


                <?php if ($errors = session('error-msg')): ?>
                    <?php foreach ((array)$errors as $msg): ?>
                        <div class="alert alert-danger"><?= esc($msg) ?></div>
                    <?php endforeach; ?>
                <?php elseif (session('exito-msg')): ?>
                    <div class="alert alert-success">
                        <?= session('exito-msg') ?>
                    </div>
                <?php endif; ?>

                <div class="input-box">
                    <input type="text" name="usuario" placeholder="Nombre de Usuario" value="<?= old('usuario') ?>">
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="contraseña" placeholder="Contraseña">
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="auth-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Recuérdame</label>
                    </div>
                    <a href="<?php echo base_url('recuperar') ?>" class="forgot-link">¿Olvidaste la contraseña?</a>
                </div>

                <button type="submit" class="auth-btn">Iniciar Sesión</button>

                <div class="auth-switch">
                    <p>¿No tienes una cuenta? <a href="<?php echo base_url('register') ?>">Regístrate</a></p>
                </div>
            </form>
        </div>

        <div class="auth-hero">
            <div class="hero-content">
                <h2>Bienvenido de vuelta</h2>
                <p>Inicia sesión para acceder a tu biblioteca de juegos, listas de deseos y ofertas exclusivas.</p>
                <div class="hero-image">
                    <img src="https://i.ibb.co/9m6ZRfy3/holanda.gif" alt="Personaje de videojuego">
                </div>
            </div>
        </div>
    </div>
</section>