<?php

namespace App\Controllers;

use App\Models\JuegosModel;
use App\Models\CategoriaModel;
use App\Models\JuegoCategoriaModel;
use App\Models\GaleriaModel;
use App\Models\RequisitosModel;
use App\Models\ReviewModel;

class Juegos extends BaseController
{
    protected $juegosModel;
    protected $categoriaModel;
    protected $juegoCategoriaModel;
    protected $galeriaModel;
    protected $requisitosModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->juegoCategoriaModel = new JuegoCategoriaModel();
        $this->galeriaModel = new GaleriaModel();
        $this->requisitosModel = new RequisitosModel();
        $this->reviewModel = new ReviewModel();
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
        $reviews = $this->reviewModel
            ->select('juegos_reviews.*, usuarios.nickname')
            ->join('usuarios', 'usuarios.user_id = juegos_reviews.user_id', 'left')
            ->where('game_id', $id)
            ->where('is_approved', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Calculamos las estadisticas de las reseñas
        $totalReviews = count($reviews);
        $scorePromedio = 0;
        $distribucion = [0, 0, 0, 0, 0]; // para contar las estrellitas

        if ($totalReviews > 0) {
            $sumaReviews = 0;
            foreach ($reviews as $res) {
                $sumaReviews += $res['rating'];
                $distribucion[5 - $res['rating']]++; // hacemos esto para invertir el indice para 5 estrellas = indice 0
            }
            $scorePromedio = round($sumaReviews / $totalReviews, 1);

            // calculamos los procentajes para la distribucion
            foreach ($distribucion as &$valor) {
                $valor = round(($valor / $totalReviews) * 100);
            }
        }

        $data = [
            'title' => $juego['title'],
            'juego' => $juego,
            'categorias' => $categorias,
            'imagenes' => $imagenes,
            'requisitos' => $requisitosOrganizados,
            'reviews' => $reviews,
            'stats' => [
                'total' => $totalReviews,
                'promedio' => $scorePromedio,
                'distribucion' => $distribucion
            ]
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/game-section')
            . view('../Views/plantillas/footer_view');
    }

    public function guardarResena()
    {
        // verificamos que sea una peticion AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Acceso no permitido'
            ]);
        }

        // verificamos si el usuario esta logueado
        if (!session()->has('user_id')) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'message' => 'Debes iniciar sesión para enviar una reseña',
                'redirect' => base_url('login')
            ]);
        }

        // validamos los datos
        $validation = \Config\Services::validation();
        $validation->setRules([
            'game_id' => 'required|is_not_unique[juegos.game_id]',
            'titulo-resena' => 'required|max_length[100]',
            'rating' => 'required|in_list[1,2,3,4,5]',
            'texto-resena' => 'required|min_length[10]|max_length[2000]'
        ], [
            'game_id' => [
                'required' => 'Juego no especificado',
                'is_not_unique' => 'El juego no existe'
            ],
            'titulo-resena' => [
                'required' => 'El título es obligatorio',
                'max_length' => 'El título no puede exceder los 100 caracteres'
            ],
            'rating' => [
                'required' => 'La puntuación es obligatoria',
                'in_list' => 'Puntuación no válida'
            ],
            'texto-resena' => [
                'required' => 'El texto de la reseña es obligatorio',
                'min_length' => 'La reseña debe tener al menos 10 caracteres',
                'max_length' => 'La reseña no puede exceder los 2000 caracteres'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'errors' => $validation->getErrors(),
                'message' => 'Por favor corrige los errores en el formulario'
            ]);
        }

        // verificamos si el usuario ya ha reseñado este juego
        $existingReview = $this->reviewModel
            ->where('game_id', $this->request->getPost('game_id'))
            ->where('user_id', session('user_id'))
            ->first();

        if ($existingReview) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Ya has enviado una reseña para este juego'
            ]);
        }

        // preparamos los datos para guardar
        $data = [
            'game_id' => $this->request->getPost('game_id'),
            'user_id' => session('user_id'),
            'review_title' => $this->request->getPost('titulo-resena'),
            'rating' => $this->request->getPost('rating'),
            'review_text' => $this->request->getPost('texto-resena'),
            'is_approved' => 1 // cambiamos a 0 en caso de querer moderacion previa
        ];

        // guardamos la reseña
        try {
            $this->reviewModel->insert($data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Reseña enviada con éxito'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar reseña: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Error al guardar la reseña. Por favor intenta nuevamente.'
            ]);
        }
    }


    public function filtrarResenas($gameId)
    {
        $estrellas = $this->request->getGet('estrellas');
        $orden = $this->request->getGet('orden');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 5;

        $reviewsBuilder = $this->reviewModel
            ->select('juegos_reviews.*, usuarios.nickname')
            ->join('usuarios', 'usuarios.user_id = juegos_reviews.user_id', 'left')
            ->where('game_id', $gameId);

        if ($estrellas && $estrellas !== 'all') {
            $reviewsBuilder = $reviewsBuilder->where('rating', $estrellas);
        }

        if ($orden === 'mejores') {
            $reviewsBuilder = $reviewsBuilder->orderBy('rating', 'DESC');
        } else {
            $reviewsBuilder = $reviewsBuilder->orderBy('created_at', 'DESC');
        }

        $reviews = $reviewsBuilder->paginate($perPage, 'reviews', $page);
        $pager = $this->reviewModel->pager;

        return view('content/partials/lista_resenas', [
            'reviews' => $reviews,
            'pager' => $pager,
            'currentPage' => $page
        ]);
    }
}
