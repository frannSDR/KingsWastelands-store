<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data['titulo'] = "Home";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/plantillas/slider_view') . view('../Views/plantillas/tendencias_view') . view('../Views/plantillas/trust_view') . view('../Views/plantillas/prox_releases_view') . view('../Views/plantillas/carousel_view') . view('../Views/plantillas/ofertas_semanales_view') . view('../Views/plantillas/newsletter_view') . view('../Views/plantillas/footer_view');
    }

    public function ofertas(): string
    {
        $data['titulo'] = "Ofertas";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/ofertas') . view('../Views/plantillas/footer_view');
    }

    public function populares(): string
    {
        $data['titulo'] = "Populares";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/populares') . view('../Views/plantillas/footer_view');
    }

    public function nosotros(): string
    {
        $data['titulo'] = "Nosotros";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/nosotros.php') . view('../Views/plantillas/footer_view');
    }

    public function comercializacion(): string
    {
        $data['titulo'] = "Comercialización";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/comercializacion.php') . view('../Views/plantillas/footer_view.php');
    }

    public function contacto(): string
    {
        $data['titulo'] = "Información de Contacto";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/contacto.php') . view('../Views/plantillas/footer_view.php');
    }

    public function error_contacto(): string
    {
        $data['titulo'] = "Error de Contacto";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/consulta_error.php') . view('../Views/plantillas/footer_view.php');
    }

    public function terminos(): string
    {
        $data['titulo'] = "Términos y Usos";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/terminos.php') . view('../Views/plantillas/footer_view.php');
    }

    public function accion(): string
    {
        $data['titulo'] = "Accion";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/accion') . view('../Views/plantillas/footer_view');
    }

    public function aventura(): string
    {
        $data['titulo'] = "Aventuras";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/aventura') . view('../Views/plantillas/footer_view');
    }

    public function terror(): string
    {
        $data['titulo'] = "Terror";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/terror') . view('../Views/plantillas/footer_view');
    }

    public function indie(): string
    {
        $data['titulo'] = "Indie";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/indie') . view('../Views/plantillas/footer_view');
    }

    public function estrategia(): string
    {
        $data['titulo'] = "Estrategia";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/estrategia') . view('../Views/plantillas/footer_view');
    }

    public function game_section(): string
    {
        $data['titulo'] = 'TEC: Oblivion Remastered';
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/game-section') . view('../Views/plantillas/footer_view');
    }

    public function cart(): string
    {
        $data['titulo'] = "Carrito de Compras";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/cart') . view('../Views/plantillas/footer_view');
    }

    public function pago(): string
    {
        $data['titulo'] = "Pago";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/pago') . view('../Views/plantillas/footer_view');
    }

    public function confirmacion(): string
    {
        $data['titulo'] = "Confirmación";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/confirmacion') . view('../Views/plantillas/footer_view');
    }

    public function login(): string
    {
        $data['titulo'] = "Iniciar Sesion";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/login') . view('../Views/plantillas/footer_view');
    }

    public function register(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/register') . view('../Views/plantillas/footer_view');
    }

    public function recuperar(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/recuperar') . view('../Views/plantillas/footer_view');
    }

    public function new_pass(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/nueva-pass') . view('../Views/plantillas/footer_view');
    }

    public function perfil(): string
    {
        $data['titulo'] = "Admin Perfil";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/perfil') . view('../Views/plantillas/footer_view');
    }
}
