<div class="particles" id="particles"></div>
<div class="section-container">
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-header">
                <h1>Información de contacto</h1>
            </div>
            <div class="contact-info-card">
                <ul class="contact-info-list">
                    <li><span class="info-label">Nombre del titular:</span> Pedro Duarte</li>
                    <li><span class="info-label">Razón social:</span> Kings & Wastelands</li>
                    <li><span class="info-label">Domicilio legal:</span> Av. Teniente Ibáñez 1450, Corrientes, Argentina</li>
                    <li><span class="info-label">Teléfono:</span> <a href="tel:+5493415678910" class="contact-link">+54 9 3415 67-8910</a></li>
                    <li><span class="info-label">Correo electrónico:</span> <a href="mailto:contacto@kings&wastelands.com.ar" class="contact-link">contacto@kings&wastelands.com.ar</a></li>
                    <li><span class="info-label">Horario de atención:</span> Lunes a Viernes de 10:00 a 19:00 (UTC-3)</li>
                </ul>
            </div>
            <div class="contact-form-card">
                <!-- Mostrar mensaje de éxito si existe -->
                <?php if (session()->has('mensaje_consulta')): ?>
                    <div class="alert alert-success">
                        <?= session('mensaje_consulta') ?>
                    </div>
                <?php endif; ?>

                <!-- Mostrar errores de validación -->
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($validation as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form class="contact-form" action="<?= base_url('consulta') ?>" method="post">
                    <?= csrf_field() ?>

                    <h2><i class="form-icon"></i> Formulario de contacto</h2>
                    <p class="form-description">Completá el siguiente formulario y te responderemos a la brevedad:</p>

                    <div class="form-group">
                        <label for="nombre">Nombre completo:</label>
                        <input type="text" id="nombre" name="nombre" value="<?= old('nombre') ?>" required class="form-input <?= (isset($validation['nombre']) ? 'is-invalid' : '') ?>">
                        <?php if (isset($validation['nombre'])): ?>
                            <div class="invalid-feedback"><?= $validation['nombre'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo electrónico:</label>
                        <input type="email" id="correo" name="correo" value="<?= old('correo') ?>" required placeholder="nombre@gmail.com" class="form-input <?= (isset($validation['correo']) ? 'is-invalid' : '') ?>">
                        <?php if (isset($validation['correo'])): ?>
                            <div class="invalid-feedback"><?= $validation['correo'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono de contacto (opcional):</label>
                        <input type="tel" id="telefono" name="telefono" value="<?= old('telefono') ?>" placeholder="+54 9 3794..." class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="motivo">Motivo de la consulta:</label>
                        <input type="text" id="motivo" name="motivo" value="<?= old('motivo') ?>" placeholder="Ejemplo: Consulta sobre compra, problema con descarga..." required class="form-input <?= (isset($validation['motivo']) ? 'is-invalid' : '') ?>">
                        <?php if (isset($validation['motivo'])): ?>
                            <div class="invalid-feedback"><?= $validation['motivo'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="consulta">Mensaje:</label>
                        <textarea id="consulta" name="consulta" rows="5" placeholder="Escribí tu consulta aquí..." required class="form-textarea <?= (isset($validation['consulta']) ? 'is-invalid' : '') ?>"><?= old('consulta') ?></textarea>
                        <?php if (isset($validation['consulta'])): ?>
                            <div class="invalid-feedback"><?= $validation['consulta'] ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="submit-btn">Enviar consulta</button>
                </form>
            </div>
        </div>
    </section>
</div>