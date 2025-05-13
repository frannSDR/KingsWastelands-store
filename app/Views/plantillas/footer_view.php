<!-- seccion de footer de la pagina -->
<footer>
    <div class="footer-container">
        <div class="footer-main">
            <div class="footer-brand">

                <!-- logo de la tienda -->
                <a href="#top">
                    <img class="footer-logo-img" src="assets/img/dslogo.png" alt="DS Store Logo">
                </a>
                <p class="footer-slogan">Tu destino para los mejores juegos digitales</p>

                <!-- redes sociales -->
                <div class="footer-social">
                    <a href="https://www.facebook.com/?locale=es_LA" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="https://x.com/?lang=es" class="social-icon"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.instagram.com/" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="https://discord.com/" class="social-icon"><i class="bi bi-discord"></i></a>
                </div>
            </div>

            <!-- seccion de enlaces del footer -->
            <div class="footer-links-container">

                <!-- enlaces -->
                <div class="footer-links-column">
                    <h3>Enlaces</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url('comercializacion') ?>">Comercialización</a></li>
                        <li><a href="<?php echo base_url('contacto') ?>">Contacto</a></li>
                        <li><a href="<?php echo base_url('terminos') ?>">Términos y usos</a></li>
                        <li><a href="<?php echo base_url('nosotros') ?>">Nosotros</a></li>
                    </ul>
                </div>

                <!-- categorias -->
                <div class="footer-links-column">
                    <h3>Categorías</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url('accion') ?>">Acción</a></li>
                        <li><a href="<?php echo base_url('aventura') ?>">Aventura</a></li>
                        <li><a href="<?php echo base_url('indie') ?>">Indie</a></li>
                        <li><a href="<?php echo base_url('estrategia') ?>">Estrategia</a></li>
                        <li><a href="<?php echo base_url('terror') ?>">Terror</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- seccion de derechos y metodos de pago -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> K&W. Todos los derechos reservados.</p>
            <div class="footer-payment">
                <i class="bi bi-credit-card"></i>
                <i class="bi bi-paypal"></i>
                <i class="bi bi-wallet2"></i>
                <i class="bi bi-cash-coin"></i>
            </div>
        </div>
    </div>
</footer>

<!-- librerias y js -->
<script src="assets/css/bootstrap.min.css"></script>
<script src="assets/js/lightbox-plus-jquery.js"></script>
<script src="assets/js/home.js"></script>
<script src="assets/js/game-sections.js"></script>
<script src="assets/js/cart.js"></script>
<script src="assets/js/login-register.js"></script>
<script src="assets/js/new-pass.js"></script>
</body>

</html>