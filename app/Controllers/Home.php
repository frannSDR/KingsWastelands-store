<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $juegosModel = new \App\Models\JuegosModel();
        $categoriaModel = new \App\Models\CategoriaModel();
        $itemDeseadosModel = new \App\Models\WishlistItemModel();
        $cartModel = new \App\Models\CartModel();
        $cartItemModel = new \App\Models\CartItemModel();


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

        // obtenemos los juegos en el carrito del usuario
        $enCarritoIds = [];
        if (session()->has('user_id')) {
            $userId = session('user_id');
            $cart = $cartModel->where('user_id', $userId)->first();
            if ($cart) {
                $cartItems = $cartItemModel
                    ->where('cart_id', $cart['cart_id'])
                    ->findAll();
                $enCarritoIds = array_column($cartItems, 'game_id');
            }
        }

        // verificamos si un juego se encuentra en el carrito
        foreach ($juegosEnOferta as &$juego) {
            $juego['enCarrito'] = in_array($juego['game_id'], $enCarritoIds);
        }

        foreach ($proxLanzamientos as &$juego) {
            $juego['enCarrito'] = in_array($juego['game_id'], $enCarritoIds);
        }

        unset($juego);


        $data = [
            'enCarritoIds' => $enCarritoIds ?? [],
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

    public function new_pass(): string
    {
        $data['titulo'] = "Registrarse";
        return view('../Views/plantillas/header_view', $data) . view('../Views/content/nueva-pass') . view('../Views/plantillas/footer_view');
    }
}
