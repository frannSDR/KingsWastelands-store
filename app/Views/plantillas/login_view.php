<!-- login/register -->
<div class="login-container">
    <div class="container-l">

        <!-- seccion de inicio de sesion -->
        <div class="form-box login">
            <form action="">
                <h1>Inicio de Sesion</h1>
                <div class="input-box">
                    <input type="text" placeholder="Usuario" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Contraseña" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <a href="#">Olvidaste la contraseña?</a>
                </div>
                <button type="submit" class="btn">Iniciar Sesion</button>
            </form>
        </div>

        <!-- seccion de registro -->
        <div class="form-box register">
            <form action="<?= base_url('registro') ?>" method="POST">
                <h1>Registro</h1>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="nombre" placeholder="Nombre de usuario" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="repetir" placeholder="Repetir contraseña" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn">Registrarse</button>
            </form>
        </div>
        <div class="toggle-box">
            <!-- boton para registrarse -->
            <div class="toggle-panel toggle-left">
                <h1>Benvenido!</h1>
                <p>No tienes una cuenta?</p>
                <button class="btn register-btn">Registrarse</button>
            </div>

            <!-- boton para iniciar sesion -->
            <div class="toggle-panel toggle-right">
                <h1>Benvenido!</h1>
                <p>Ya tienes una cuenta?</p>
                <button class="btn login-btn">Iniciar Sesion</button>
            </div>
        </div>
    </div>
</div>

<!-- fondo para el celular -->
<div class="nav-overlay"></div>