<?php

namespace App\Controllers;

use App\Models\JuegosModel;
use App\Models\CategoriaModel;
use App\Models\JuegoCategoriaModel;
use App\Models\GaleriaModel;
use App\Models\RequisitosModel;

class Juegos extends BaseController
{
    protected $juegosModel;
    protected $categoriaModel;
    protected $juegoCategoriaModel;
    protected $galeriaModel;
    protected $requisitosModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->juegoCategoriaModel = new JuegoCategoriaModel();
        $this->galeriaModel = new GaleriaModel();
        $this->requisitosModel = new RequisitosModel();
    }

    public function populares()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 9;

        // Buscar la categoría "Popular" por su slug
        $categoriaPopular = $this->categoriaModel->where('slug', 'popular')->first();

        if (!$categoriaPopular) {
            // Si no existe, muestra los juegos mejor valorados como fallback
            $juegos = $this->juegosModel
                ->select('game_id, title, price, card_image_url, youtube_trailer_id')
                ->orderBy('rating', 'DESC')
                ->paginate($perPage, 'default', $page);

            $total = $this->juegosModel->countAll();
        } else {
            // Si existe la categoría, filtra por ella
            $juegos = $this->juegosModel
                ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id')
                ->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoriaPopular['category_id'])
                ->orderBy('juegos.rating', 'DESC')
                ->paginate($perPage, 'default', $page);

            // Contar total usando DB directamente para evitar problemas con soft deletes
            $db = \Config\Database::connect();
            $total = $db->table('juego_categorias')
                ->where('category_id', $categoriaPopular['category_id'])
                ->countAllResults();
        }

        $totalPages = ceil($total / $perPage);

        $data = [
            'title' => 'Juegos Populares',
            'juegos' => $juegos,
            'section_title' => 'Populares',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/populares')
            . view('../Views/plantillas/footer_view');
    }

    public function ofertas()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 9;

        // Buscar la categoría "Oferta" por su slug
        $categoriaOferta = $this->categoriaModel->where('slug', 'oferta')->first();

        if (!$categoriaOferta) {
            // Si no existe, muestra los juegos mejor valorados como fallback
            $juegos = $this->juegosModel
                ->select('game_id, title, price, card_image_url, youtube_trailer_id')
                ->orderBy('rating', 'DESC')
                ->paginate($perPage, 'default', $page);

            $total = $this->juegosModel->countAll();
        } else {
            // Si existe la categoría, filtra por ella
            $juegos = $this->juegosModel
                ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id')
                ->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoriaOferta['category_id'])
                ->orderBy('juegos.rating', 'DESC')
                ->paginate($perPage, 'default', $page);

            // Contar total usando DB directamente para evitar problemas con soft deletes
            $db = \Config\Database::connect();
            $total = $db->table('juego_categorias')
                ->where('category_id', $categoriaOferta['category_id'])
                ->countAllResults();
        }

        $totalPages = ceil($total / $perPage);

        $data = [
            'title' => 'Juegos en Oferta',
            'juegos' => $juegos,
            'section_title' => 'Ofertas',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/ofertas')
            . view('../Views/plantillas/footer_view');
    }

    public function accion()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 9;

        // Obtener parámetros de filtrado
        $filter = $this->request->getVar('filter') ?? 'rating';
        $direction = $this->request->getVar('direction') ?? 'desc';

        // Validar dirección
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        // Mapear filtros a columnas de la BD
        $orderBy = match ($filter) {
            'alphabetic' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // Buscar la categoría "Accion" por su slug
        $categoriaAccion = $this->categoriaModel->where('slug', 'accion')->first();

        $builder = $this->juegosModel
            ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id');

        if ($categoriaAccion) {
            $builder->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoriaAccion['category_id']);
        } else {
            // Si no existe la categoría, mostrar un mensaje de error
            return redirect()->to('/')->with('error', 'La categoría Acción no existe');
        }

        // Aplicar ordenamiento
        $juegos = $builder->orderBy($orderBy, $direction)
            ->paginate($perPage, 'default', $page);

        // Contar total de juegos en esta categoría
        $db = \Config\Database::connect();
        $total = $db->table('juego_categorias')
            ->where('category_id', $categoriaAccion['category_id'])
            ->countAllResults();

        $totalPages = ceil($total / $perPage);

        $data = [
            'title' => 'Juegos de Acción',
            'juegos' => $juegos,
            'section_title' => 'Acción',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager,
            'currentFilter' => $filter,
            'currentDirection' => strtolower($direction)
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/accion')
            . view('../Views/plantillas/footer_view');
    }

    public function aventuras()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 9;

        // Obtener parámetros de filtrado
        $filter = $this->request->getVar('filter') ?? 'rating';
        $direction = $this->request->getVar('direction') ?? 'desc';

        // Validar dirección
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        // Mapear filtros a columnas de la BD
        $orderBy = match ($filter) {
            'alphabetic' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // Buscar la categoría "Accion" por su slug
        $categoriaAventuras = $this->categoriaModel->where('slug', 'aventuras')->first();

        $builder = $this->juegosModel
            ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id');

        if ($categoriaAventuras) {
            $builder->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoriaAventuras['category_id']);
        } else {
            // Si no existe la categoría, mostrar un mensaje de error
            return redirect()->to('/')->with('error', 'La categoría Aventuras no existe');
        }

        // Aplicar ordenamiento
        $juegos = $builder->orderBy($orderBy, $direction)
            ->paginate($perPage, 'default', $page);

        // Contar total de juegos en esta categoría
        $db = \Config\Database::connect();
        $total = $db->table('juego_categorias')
            ->where('category_id', $categoriaAventuras['category_id'])
            ->countAllResults();

        $totalPages = ceil($total / $perPage);

        $data = [
            'title' => 'Juegos de Aventuras',
            'juegos' => $juegos,
            'section_title' => 'Aventuras',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager,
            'currentFilter' => $filter,
            'currentDirection' => strtolower($direction)
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/aventura')
            . view('../Views/plantillas/footer_view');
    }

    public function terror()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 9;

        // Obtener parámetros de filtrado
        $filter = $this->request->getVar('filter') ?? 'rating';
        $direction = $this->request->getVar('direction') ?? 'desc';

        // Validar dirección
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        // Mapear filtros a columnas de la BD
        $orderBy = match ($filter) {
            'alphabetic' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // Buscar la categoría "Accion" por su slug
        $categoriaTerror = $this->categoriaModel->where('slug', 'terror')->first();

        $builder = $this->juegosModel
            ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id');

        if ($categoriaTerror) {
            $builder->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoriaTerror['category_id']);
        } else {
            // Si no existe la categoría, mostrar un mensaje de error
            return redirect()->to('/')->with('error', 'La categoría Terror no existe');
        }

        // Aplicar ordenamiento
        $juegos = $builder->orderBy($orderBy, $direction)
            ->paginate($perPage, 'default', $page);

        // Contar total de juegos en esta categoría
        $db = \Config\Database::connect();
        $total = $db->table('juego_categorias')
            ->where('category_id', $categoriaTerror['category_id'])
            ->countAllResults();

        $totalPages = ceil($total / $perPage);

        $data = [
            'title' => 'Juegos de Terror',
            'juegos' => $juegos,
            'section_title' => 'Terror',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager,
            'currentFilter' => $filter,
            'currentDirection' => strtolower($direction)
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/terror')
            . view('../Views/plantillas/footer_view');
    }

    public function indie()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 9;

        // Obtener parámetros de filtrado
        $filter = $this->request->getVar('filter') ?? 'rating';
        $direction = $this->request->getVar('direction') ?? 'desc';

        // Validar dirección
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        // Mapear filtros a columnas de la BD
        $orderBy = match ($filter) {
            'alphabetic' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // Buscar la categoría "Accion" por su slug
        $categoriaIndies = $this->categoriaModel->where('slug', 'indie')->first();

        $builder = $this->juegosModel
            ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id');

        if ($categoriaIndies) {
            $builder->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoriaIndies['category_id']);
        } else {
            // Si no existe la categoría, mostrar un mensaje de error
            return redirect()->to('/')->with('error', 'La categoría Indies no existe');
        }

        // Aplicar ordenamiento
        $juegos = $builder->orderBy($orderBy, $direction)
            ->paginate($perPage, 'default', $page);

        // Contar total de juegos en esta categoría
        $db = \Config\Database::connect();
        $total = $db->table('juego_categorias')
            ->where('category_id', $categoriaIndies['category_id'])
            ->countAllResults();

        $totalPages = ceil($total / $perPage);

        $data = [
            'title' => 'Juegos Indies',
            'juegos' => $juegos,
            'section_title' => 'Indies',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager,
            'currentFilter' => $filter,
            'currentDirection' => strtolower($direction)
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/indie')
            . view('../Views/plantillas/footer_view');
    }

    public function estrategia()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 9;

        // Obtener parámetros de filtrado
        $filter = $this->request->getVar('filter') ?? 'rating';
        $direction = $this->request->getVar('direction') ?? 'desc';

        // Validar dirección
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        // Mapear filtros a columnas de la BD
        $orderBy = match ($filter) {
            'alphabetic' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // Buscar la categoría "Accion" por su slug
        $categoriaEstrategia = $this->categoriaModel->where('slug', 'estrategia')->first();

        $builder = $this->juegosModel
            ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id');

        if ($categoriaEstrategia) {
            $builder->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoriaEstrategia['category_id']);
        } else {
            // Si no existe la categoría, mostrar un mensaje de error
            return redirect()->to('/')->with('error', 'La categoría Aventuras no existe');
        }

        // Aplicar ordenamiento
        $juegos = $builder->orderBy($orderBy, $direction)
            ->paginate($perPage, 'default', $page);

        // Contar total de juegos en esta categoría
        $db = \Config\Database::connect();
        $total = $db->table('juego_categorias')
            ->where('category_id', $categoriaEstrategia['category_id'])
            ->countAllResults();

        $totalPages = ceil($total / $perPage);

        $data = [
            'title' => 'Juegos de Estrategia',
            'juegos' => $juegos,
            'section_title' => 'Estrategia',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager,
            'currentFilter' => $filter,
            'currentDirection' => strtolower($direction)
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/estrategia')
            . view('../Views/plantillas/footer_view');
    }

    public function detalle($id)
    {
        // Obtener el juego por ID
        $juego = $this->juegosModel->find($id);

        if (!$juego) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Obtener imágenes del juego
        $imagenes = $this->galeriaModel
            ->select('image_url, image_order')
            ->where('game_id', $id)
            ->orderBy('image_order', 'ASC')
            ->findAll();

        // Obtener categorías del juego
        $categorias = $this->juegoCategoriaModel
            ->select('categorias.name_cat, categorias.slug')
            ->join('categorias', 'categorias.category_id = juego_categorias.category_id')
            ->where('juego_categorias.game_id', $id)
            ->findAll();

        // Obtener requisitos del sistema
        $requisitos = $this->requisitosModel
            ->where('game_id', $id)
            ->findAll();

        // Organizar los requisitos por tipo para facilitar el acceso en la vista
        $requisitosOrganizados = [];
        foreach ($requisitos as $req) {
            $requisitosOrganizados[$req['tipo']] = $req;
        }

        // Obtener reseñas (todavia no)
        //$reseñas = $this->juegosModel->getReseñas($id); 

        $data = [
            'title' => $juego['title'],
            'juego' => $juego,
            'categorias' => $categorias,
            'imagenes' => $imagenes,
            'requisitos' => $requisitosOrganizados
            //'reseñas' => $reseñas
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/game-section')
            . view('../Views/plantillas/footer_view');
    }
}
