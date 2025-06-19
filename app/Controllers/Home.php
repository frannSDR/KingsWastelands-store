<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $juegosModel = new \App\Models\JuegosModel();
        $categoriaModel = new \App\Models\CategoriaModel();
        $itemDeseadosModel = new \App\Models\WishlistItemModel();

        $deseados_ids = [];
        if (session()->has('user_id')) {
            $wishlistItems = $itemDeseadosModel
                ->where('user_id', session('user_id'))
                ->findAll();
            $deseados_ids = array_column($wishlistItems, 'game_id');
        }

        // proximos lanzamientos
        $proxLanzamientos = $juegosModel
            ->where('release_date >', date('Y-m-d'))
            ->orderBy('release_date', 'ASC')
            ->findAll(12);

        // juegos en oferta
        $juegosEnOferta = $juegosModel
            ->where('special_price_active', 1)
            ->orderBy('updated_at')
            ->findAll(12);

        // juegos populares
        $categoriaPopular = $categoriaModel->where('slug', 'indie')->first();
        $juegosPopulares = [];
        if ($categoriaPopular) {
            $juegosPopulares = $juegosModel
                ->join('juego_categorias', 'juegos.game_id = juego_categorias.game_id')
                ->where('juego_categorias.category_id', $categoriaPopular['category_id'])
                ->findAll(9);
        }

        // juegos destacados
        $categoriaDestacado = $categoriaModel->where('slug', 'destacado')->first();
        $juegosDestacados = [];
        if ($categoriaDestacado) {
            $juegosDestacados = $juegosModel
                ->join('juego_categorias', 'juegos.game_id = juego_categorias.game_id')
                ->where('juego_categorias.category_id', $categoriaDestacado['category_id'])
                ->findAll(8);
        }

        $data = [
            'juegosPopulares' => $juegosPopulares,
            'juegosDestacados' => $juegosDestacados,
            'juegosEnOferta' => $juegosEnOferta,
            'proxLanzamientos' => $proxLanzamientos,
            'deseados_ids' => $deseados_ids
        ];

        return view('plantillas/header_view')
            . view('plantillas/slider_view', $data)
            . view('plantillas/tendencias_view', $data)
            . view('plantillas/trust_view')
            . view('plantillas/ofertas_semanales_view.php')
            . view('plantillas/carousel_view')
            . view('plantillas/prox_releases_view')
            . view('plantillas/newsletter_view')
            . view('plantillas/footer_view');
    }

    public function nosotros(): string
    {
        $data['titulo'] = "Nosotros";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/content/nosotros.php') . view('../Views/plantillas/footer_view');
    }

    public function comercializacion(): string
    {
        $data['titulo'] = "Comercialización";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/content/comercializacion.php') . view('../Views/plantillas/footer_view.php');
    }

    public function contacto(): string
    {
        $data['titulo'] = "Información de Contacto";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/content/contacto.php') . view('../Views/plantillas/footer_view.php');
    }

    public function terminos(): string
    {
        $data['titulo'] = "Términos y Usos";
        return view('../Views/plantillas/header_view.php', $data) . view('../Views/content/terminos.php') . view('../Views/plantillas/footer_view.php');
    }

    public function juegos(): string
    {
        $data['titulo'] = "Juegos";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/games') . view('../Views/plantillas/footer_view');
    }

    public function cart(): string
    {
        $data['titulo'] = "Carrito de Compras";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/cart') . view('../Views/plantillas/footer_view');
    }

    public function pago(): string
    {
        $data['titulo'] = "Pago";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/pago') . view('../Views/plantillas/footer_view');
    }

    public function confirmacion(): string
    {
        $data['titulo'] = "Confirmación";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/confirmacion') . view('../Views/plantillas/footer_view');
    }

    public function login(): string
    {
        $data['titulo'] = "Iniciar Sesion";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/login') . view('../Views/plantillas/footer_view');
    }

    public function register(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/register') . view('../Views/plantillas/footer_view');
    }

    public function recuperar(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/recuperar') . view('../Views/plantillas/footer_view');
    }

    public function new_pass(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/nueva-pass') . view('../Views/plantillas/footer_view');
    }

    public function perfil(): string
    {
        $data['titulo'] = "Admin Perfil";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/perfil') . view('../Views/plantillas/footer_view');
    }

    public function perfil_user(): string
    {
        $data['titulo'] = "User Perfil";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/user_perfil') . view('../Views/plantillas/footer_view');
    }
}
