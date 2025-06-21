<div class="section-header">
    <h2><i class="bi bi-person-fill"></i> Mi Perfil</h2>
</div>

<div class="profile-info-container">
    <?php if ($errors = session('error-msg')): ?>
        <?php foreach ((array)$errors as $msg): ?>
            <div class="alert alert-danger"><?= esc($msg) ?></div>
        <?php endforeach; ?>
    <?php elseif (session('exito-msg')): ?>
        <div class="alert alert-success"><?= session('exito-msg') ?></div>
    <?php endif; ?>
    <form action="<?= base_url('perfil/actualizar-datos') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="nickname">Nombre de usuario</label>
            <input type="text" id="nickname" name="nickname" value="<?= esc(session('nickname')) ?>" class="form-input">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="<?= esc(session('email')) ?>" class="form-input">
        </div>

        <button type="submit" class="save-btn">Guardar cambios</button>
    </form>

    <div class="security-section">
        <h3><i class="bi bi-shield-lock"></i> Seguridad</h3>
        <a href="<?= base_url('nueva-pass') ?>" class="security-link">
            <i class="bi bi-key"></i> Cambiar contraseña
        </a>
    </div>
</div>