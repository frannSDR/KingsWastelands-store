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

    public function all_games()
    {
        //! JUEGOS

        $gamesPage = $this->request->getVar('games_page') ?? 1;
        $gamesPerPage = 15;
        $gameFilter = $this->request->getVar('game_filter') ?? 'title';
        $gameDirection = $this->request->getVar('game_direction') ?? 'asc';
        $gameDirection = strtoupper($gameDirection) === 'DESC' ? 'DESC' : 'ASC';

        $gamesOrderBy = match ($gameFilter) {
            'title' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // Obtenemos todos los juegos paginados
        $juegos = $this->juegosModel
            ->select('game_id, title, price, release_date, card_image_url, is_active, rating, about, youtube_trailer_id')
            ->orderBy($gamesOrderBy, $gameDirection)
            ->paginate($gamesPerPage, 'games', $gamesPage);

        $gamesTotal = $this->juegosModel->countAll();
        $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);

        //! CATEGORIAS

        $catPage = $this->request->getVar('cat_page') ?? 1;
        $catPerPage = 10;
        $catFilter = $this->request->getVar('cat_filter') ?? 'category_id';
        $catDirection = $this->request->getVar('cat_direction') ?? 'asc';
        $catDirection = strtoupper($catDirection) === 'DESC' ? 'DESC' : 'ASC';

        $catOrderBy = match ($catFilter) {
            'name_cat' => 'name_cat',
            'slug' => 'slug',
            default => 'category_id'
        };

        $categorias = $this->categoriaModel
            ->select('categorias.category_id, categorias.name_cat, categorias.slug, COUNT(juego_categorias.game_id) as juegos_count')
            ->join('juego_categorias', 'juego_categorias.category_id = categorias.category_id', 'left')
            ->groupBy('categorias.category_id')
            ->orderBy($catOrderBy, $catDirection)
            ->paginate($catPerPage, 'categories', $catPage);

        $catTotal = $this->categoriaModel->countAll();
        $catTotalPages = ceil($catTotal / $catPerPage);

        $gameIds = array_column($juegos, 'game_id');
        $categoriasPorJuego = [];
        if (!empty($gameIds)) {
            $cats = $this->juegoCategoriaModel
                ->select('juego_categorias.game_id, categorias.name_cat, categorias.slug')
                ->join('categorias', 'categorias.category_id = juego_categorias.category_id')
                ->whereIn('juego_categorias.game_id', $gameIds)
                ->findAll();

            foreach ($cats as $cat) {
                $categoriasPorJuego[$cat['game_id']][] = [
                    'name_cat' => $cat['name_cat'],
                    'slug' => $cat['slug']
                ];
            }
        }
        foreach ($juegos as &$juego) {
            $juego['categorias'] = $categoriasPorJuego[$juego['game_id']] ?? [];
        }

        unset($juego);

        $data = [
            'juegos' => $juegos,
            'currentGamesPage' => $gamesPage,
            'totalGamesPages' => $gamesTotalPages,
            'currentGameFilter' => $gameFilter,
            'currentDirection' => strtolower($gameDirection),
            'gamesPager' => $this->juegosModel->pager,
            'categorias' => $categorias,
            'currentCatPage' => $catPage,
            'totalCatPages' => $catTotalPages,
            'catPager' => $this->categoriaModel->pager,
            'currentCatFilter' => $catFilter,
            'categoriaActual' => 'todos',
            'pager' => $this->juegosModel->pager,
            'currentCatDirection' => strtolower($catDirection)
        ];

        return view('../Views/plantillas/header_view')
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/games', $data)
            . view('../Views/plantillas/footer_view');
    }

    public function categoria($slug = 'todos')
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 10;

        $filter = $this->request->getVar('filter') ?? 'rating';
        $direction = $this->request->getVar('direction') ?? 'desc';
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        $orderBy = match ($filter) {
            'alphabetic' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        $builder = $this->juegosModel
            ->select('juegos.game_id, juegos.title, juegos.price, juegos.card_image_url, juegos.youtube_trailer_id, juegos.about, juegos.rating, juegos.release_date, juegos.developer');

        if ($slug !== 'todos') {
            $categoria = $this->categoriaModel->where('slug', $slug)->first();
            if (!$categoria) {
                return redirect()->to('/')->with('error-msg', 'La categoría no existe');
            }
            $builder->join('juego_categorias', 'juego_categorias.game_id = juegos.game_id')
                ->where('juego_categorias.category_id', $categoria['category_id']);
        }

        $juegos = $builder->orderBy($orderBy, $direction)
            ->paginate($perPage, 'default', $page);

        // asociamos las categorias a cada juego
        $gameIds = array_column($juegos, 'game_id');
        $categoriasPorJuego = [];
        if (!empty($gameIds)) {
            $cats = $this->juegoCategoriaModel
                ->select('juego_categorias.game_id, categorias.name_cat, categorias.slug')
                ->join('categorias', 'categorias.category_id = juego_categorias.category_id')
                ->whereIn('juego_categorias.game_id', $gameIds)
                ->findAll();

            foreach ($cats as $cat) {
                $categoriasPorJuego[$cat['game_id']][] = [
                    'name_cat' => $cat['name_cat'],
                    'slug' => $cat['slug']
                ];
            }
        }

        foreach ($juegos as &$juego) {
            $juego['categorias'] = $categoriasPorJuego[$juego['game_id']] ?? [];
        }

        unset($juego);

        $data = [
            'juegos' => $juegos,
            'categoriaActual' => $slug,
            'pager' => $this->juegosModel->pager,
            'currentPage' => $page,
            'totalPages' => ceil($this->juegosModel->pager->getTotal('default') / $perPage),
            'currentFilter' => $filter,
            'currentDirection' => strtolower($direction),
            'categoriasPorJuego' => $categoriasPorJuego,
            'pager' => $this->juegosModel->pager,
            'orderBy' => $orderBy
        ];

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/games', $data)
            . view('../Views/plantillas/footer_view');
    }

    public function detalle($id)
    {
        // obtenemos el juego por su id
        $juego = $this->juegosModel->find($id);

        if (!$juego) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // obtenemos las imagenes de galeria del juego
        $imagenes = $this->galeriaModel
            ->select('image_url, image_order')
            ->where('game_id', $id)
            ->orderBy('image_order', 'ASC')
            ->findAll();

        // obtenemos sus categorias
        $categorias = $this->juegoCategoriaModel
            ->select('categorias.name_cat, categorias.slug')
            ->join('categorias', 'categorias.category_id = juego_categorias.category_id')
            ->where('juego_categorias.game_id', $id)
            ->findAll();

        // obtenemos los requisitos
        $requisitos = $this->requisitosModel
            ->where('game_id', $id)
            ->findAll();

        // organizamos los requisitos por tipo para facilitar el acceso en la vista
        $requisitosOrganizados = [];
        foreach ($requisitos as $req) {
            $requisitosOrganizados[$req['tipo']] = $req;
        }

        // obtenemos las reseñas
        $reviews = $this->reviewModel
            ->select('juegos_reviews.*, usuarios.nickname, usuarios.user_img')
            ->join('usuarios', 'usuarios.user_id = juegos_reviews.user_id', 'left')
            ->where('game_id', $id)
            ->where('is_approved', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // calculamos las estadisticas para las reseñas
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
                'error-msg' => 'Por favor corrige los errores en el formulario'
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
                'error-msg' => 'Ya has enviado una reseña para este juego'
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

        // usamos un trycatch para guardar la reseña
        try {
            $this->reviewModel->insert($data);
            return $this->response->setJSON([
                'success' => true,
            ]);
        } catch (\Exception) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
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
            ->select('juegos_reviews.*, usuarios.nickname, usuarios.user_img')
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

    public function votarUtil($review_id)
    {
        $user_id = session()->get('user_id');
        $is_helpful = $this->request->getPost('is_helpful');
        if ($is_helpful === null) {
            $json = $this->request->getJSON();
            $is_helpful = $json->is_helpful ?? null;
        }

        if (!$user_id) {
            return $this->response->setJSON(['error-msg' => 'Debes iniciar sesión para poder likear']);
        }

        if ($is_helpful === null) {
            return $this->response->setJSON(['error-msg' => 'Falta el parámetro is_helpful']);
        }

        $helpfulModel = new \App\Models\ReviewHelpfulModel();

        $existe = $helpfulModel
            ->where('review_id', $review_id)
            ->where('user_id', $user_id)
            ->first();

        if ($existe) {
            if ($existe['is_helpful'] == $is_helpful) {
                // si el voto es igual, lo quitamos (elimina el registro)
                $helpfulModel->delete($existe['helpful_id']);
            } else {
                // si el voto es distinto, lo actualizamos
                $helpfulModel->update($existe['helpful_id'], ['is_helpful' => $is_helpful]);
            }
        } else {
            // inserta el nuevo voto
            $helpfulModel->insert([
                'review_id' => $review_id,
                'user_id' => $user_id,
                'is_helpful' => $is_helpful
            ]);
        }

        $likes = $helpfulModel->where('review_id', $review_id)->where('is_helpful', 1)->countAllResults();
        $dislikes = $helpfulModel->where('review_id', $review_id)->where('is_helpful', 0)->countAllResults();

        return $this->response->setJSON([
            'likes' => $likes,
            'dislikes' => $dislikes
        ]);
    }
}
