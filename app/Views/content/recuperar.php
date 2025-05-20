<section class="auth-section recovery-page" style="margin-top: 25px;">
    <div class="auth-container">
        <div class="auth-form-container">
            <form action="procesar_recuperacion.php" method="POST" class="auth-form">
                <div class="recovery-logo">
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <h1 class="auth-title">Recuperar Contraseña</h1>
                <div class="recovery-steps">
                    <div class="recovery-step active">1</div>
                    <div class="recovery-step">2</div>
                </div>
                <p class="recovery-subtitle">Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña.</p>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Email registrado" required>
                    <i class='bx bxs-envelope'></i>
                </div>

                <button type="submit" class="auth-btn">Enviar Enlace</button>

                <div class="auth-switch">
                    <p>¿Recordaste tu contraseña? <a href="<?php echo base_url('login') ?>">Inicia Sesión</a></p>
                </div>
            </form>
        </div>

        <div class="auth-hero">
            <div class="hero-content">
                <h2>¿Problemas para acceder?</h2>
                <p>No te preocupes, estamos aquí para ayudarte a recuperar el acceso a tu cuenta.</p>
                <div class="hero-image">
                    <img src="https://i.ibb.co/k2xD4KP6/recuperar.gif" alt="Personaje de videojuego con llave">
                </div>
            </div>
        </div>
    </div>
</section>