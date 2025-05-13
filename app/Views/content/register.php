<section class="auth-section register-page">
    <div class="auth-container">
        <div class="auth-form-container">
            <form action="procesar_registro.php" method="POST" class="auth-form">
                <h1 class="auth-title">Registro</h1>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>

                <div class="input-box">
                    <input type="text" name="usuario" placeholder="Nombre de usuario" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="confirmar_contraseña" placeholder="Confirmar contraseña" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="terms">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">Acepto los <a href="#">Términos y Condiciones</a></label>
                </div>

                <button type="submit" class="auth-btn">Registrarse</button>

                <div class="auth-switch">
                    <p>¿Ya tienes una cuenta? <a href="<?php echo base_url('login') ?>">Inicia Sesión</a></p>
                </div>
            </form>
        </div>

        <div class="auth-hero">
            <div class="hero-content">
                <h2>Únete a nuestra comunidad</h2>
                <p>Regístrate para acceder a ofertas exclusivas, seguimiento de tus juegos favoritos y participar en nuestra comunidad.</p>
                <div class="hero-image">
                    <img src="https://i.ibb.co/bRFJj2X2/animal-friend.gif" alt="Personajes de videojuegos">
                </div>
            </div>
        </div>
    </div>
</section>