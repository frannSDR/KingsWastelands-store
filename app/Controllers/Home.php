<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $juegosModel = new \App\Models\JuegosModel();
        $categoriaModel = new \App\Models\CategoriaModel();

        // Juegos en oferta
        $categoriaOfertas = $categoriaModel->where('slug', 'ofertas')->first();
        $juegosOferta = [];
        if ($categoriaOfertas) {
            $juegosOferta = $juegosModel
                ->join('juego_categorias', 'juegos.game_id = juego_categorias.game_id')
                ->where('juego_categorias.category_id', $categoriaOfertas['category_id'])
                ->findAll(9);
        }

        // Juegos populares
        $categoriaPopular = $categoriaModel->where('slug', 'popular')->first();
        $juegosPopulares = [];
        if ($categoriaPopular) {
            $juegosPopulares = $juegosModel
                ->join('juego_categorias', 'juegos.game_id = juego_categorias.game_id')
                ->where('juego_categorias.category_id', $categoriaPopular['category_id'])
                ->findAll(9);
        }

        $data = [
            'juegosOferta' => $juegosOferta,
            'juegosPopulares' => $juegosPopulares
        ];

        // Puedes agregar más secciones si quieres (por ejemplo, próximos lanzamientos)

        return view('plantillas/header_view')
            . view('plantillas/side_cart')
            . view('plantillas/slider_view', $data)
            . view('plantillas/tendencias_view', $data)
            . view('plantillas/carousel_view')
            . view('plantillas/trust_view')
            . view('plantillas/newsletter_view')
            . view('plantillas/footer_view');
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

    public function juegos(): string
    {
        $data['titulo'] = "Juegos";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/games') . view('../Views/plantillas/footer_view');
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

    public function perfil_user(): string
    {
        $data['titulo'] = "User Perfil";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/user_perfil') . view('../Views/plantillas/footer_view');
    }

    public function wishlist(): string
    {
        $data['titulo'] = "Wishlist";
        return view('../Views/plantillas/header_view', $data) . view('../Views/plantillas/side_cart') . view('../Views/content/whishlist') . view('../Views/plantillas/footer_view');
    }
}
