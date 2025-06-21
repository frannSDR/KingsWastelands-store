<section class="auth-section recovery-page" style="margin-top: 50px;">
    <div class="auth-container">
        <div class="auth-form-container">

            <?php if (session('error-msg')): ?>
                <div class="alert alert-danger">
                    <?php
                    $errors = session('error-msg');
                    if (is_array($errors)) {
                        foreach ($errors as $e) echo $e . '<br>';
                    } else {
                        echo $errors;
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if (session('exito-msg')): ?>
                <div class="alert alert-success">
                    <?= session('exito-msg') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('usuario/procesar_nueva_contrasena') ?>" method="POST" class="auth-form">
                <div class="recovery-logo">
                    <i class='bx bxs-key'></i>
                </div>

                <h1 class="auth-title">Nueva Contraseña</h1>
                <p class="recovery-subtitle">Crea una nueva contraseña segura para tu cuenta.</p>

                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">

                <div class="input-box">
                    <input type="password" name="actual_contraseña" placeholder="Contraseña actual" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="nueva_contraseña" placeholder="Nueva contraseña" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="confirmar_contraseña" placeholder="Confirmar nueva contraseña" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="password-strength">
                    <div class="strength-meter">
                        <div class="strength-level" id="strength-level"></div>
                    </div>
                    <div class="strength-text" id="strength-text"></div>
                </div>

                <div class="password-requirements">
                    <p>La contraseña debe contener:</p>
                    <ul>
                        <li id="req-length">Mínimo 8 caracteres</li>
                        <li id="req-uppercase">1 letra mayúscula</li>
                        <li id="req-number">1 número</li>
                        <li id="req-special">1 carácter especial</li>
                    </ul>
                </div>

                <button type="submit" class="auth-btn" id="submit-btn" disabled>Actualizar Contraseña</button>
            </form>
        </div>

        <div class="auth-hero">
            <div class="hero-content">
                <h2>Seguridad primero</h2>
                <p>Crea una contraseña fuerte para proteger tu cuenta y tus datos.</p>
                <div class="hero-image">
                    <img src="https://i.ibb.co/Kxn1NS71/secure.gif" alt="Personaje de videojuego con escudo">
                </div>
            </div>
        </div>
    </div>
</section>