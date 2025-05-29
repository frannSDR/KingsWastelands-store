<?php

namespace App\Controllers;

use App\Models\JuegosModel;
use App\Models\CategoriaModel;
use App\Models\JuegoCategoriaModel;
use App\Models\GaleriaModel;
use App\Models\RequisitosModel;
use App\Models\ReviewModel;
use App\Models\UsuarioModel;

class Admin extends BaseController
{
    protected $juegosModel;
    protected $categoriaModel;
    protected $juegoCategoriaModel;
    protected $galeriaModel;
    protected $requisitosModel;
    protected $reviewModel;
    protected $usuariosModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->juegoCategoriaModel = new JuegoCategoriaModel();
        $this->galeriaModel = new GaleriaModel();
        $this->requisitosModel = new RequisitosModel();
        $this->reviewModel = new ReviewModel();
        $this->usuariosModel = new UsuarioModel();
    }

    public function admin()
    {

        $session = session();

        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('mensaje', 'Acceso no autorizado');
        }

        //! JUEGOS

        $gamesPage = $this->request->getVar('page') ?? 1; // obtenemos la pagina actual y la cantidad de juegos por paginasi no se especifica la pagina, se usa la 1
        $gamesPerPage = 20; // 25 es la cantidad de juegos que mostramos por pagina
        $gameFilter = $this->request->getVar('filter') ?? 'title'; // obtenenemos los parametros de filtrado, filtramos por titulo
        $gameDirection = $this->request->getVar('direction') ?? 'asc';
        $gameDirection = strtoupper($gameDirection) === 'DESC' ? 'DESC' : 'ASC'; // validamos la direccion y filtramos por el orden ascendente

        // dependiendo del filtro, ordenamos por la columna correspondiente, como filtramos por el titulo, lo hacemos alfabeticamente
        $gamesOrderBy = match ($gameFilter) {
            'title' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // obtenemos todos los juegos, solo los campos necesarios, aplicamos el orden y paginacion
        $juegos = $this->juegosModel
            ->select('game_id, title, price, release_date, card_image_url, logo_url')
            ->orderBy($gamesOrderBy, $gameDirection)
            ->paginate($gamesPerPage, 'default', $gamesPage);

        // contamos el total de juegos y calculamos el total de paginas
        $gamesTotal = $this->juegosModel->countAll();
        $gamesTotalPages = ceil($gamesTotal / $gamesPerPage); // usamos ceil para redondear hacia arriba

        //! USUARIOS

        $userPage = $this->request->getVar('page') ?? 1; // Obtener la página actual, por defecto es 1
        $userPerPage = 10; // Número de usuarios por página
        $userFilter = $this->request->getVar('filter') ?? 'user_id';
        $userDirection = $this->request->getVar('direction') ?? 'asc';
        $userDirection = strtoupper($userDirection) === 'DESC' ? 'DESC' : 'ASC';

        $userOrderBy = match ($userFilter) {
            'email' => 'email',
            'nickname' => 'nickname',
            'created_at' => 'created_at',
            'last_login' => 'last_login',
            default => 'user_id'
        };

        $usuarios = $this->usuariosModel
            ->select('user_id, email, nickname, created_at, last_login, is_active')
            ->orderBy($userOrderBy, $userDirection)
            ->paginate($userPerPage, 'default', $userPage);

        $userTotal = $this->usuariosModel->countAll();
        $userTotalPages = ceil($userTotal / $userPerPage);

        //! CATEGORIAS

        $catPage = $this->request->getVar('page') ?? 1; // Obtener la página actual, por defecto es 1
        $catPerPage = 10; // Número de categorías por página
        $catFilter = $this->request->getVar('filter') ?? 'category_id';
        $catDirection = $this->request->getVar('direction') ?? 'asc';
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
            ->paginate($catPerPage, 'default', $catPage);

        $catTotal = $this->categoriaModel->countAll();
        $catTotalPages = ceil($catTotal / $catPerPage);

        // preparamos los datos para la vista en la pagina
        $data = [
            // Juegos
            'juegos' => $juegos,
            'currentGamesPage' => $gamesPage,
            'totalGamesPages' => $gamesTotalPages,
            'currentGameFilter' => $gameFilter,
            'currentDirection' => strtolower($gameDirection),
            'pager' => $this->juegosModel->pager,
            // Usuarios
            'usuarios' => $usuarios,
            'currentUserPage' => $userPage,
            'totalUserPages' => $userTotalPages,
            'userPager' => $this->usuariosModel->pager,
            'currentUserFilter' => $userFilter,
            'currentUserDirection' => strtolower($userDirection),
            // Categorias
            'categorias' => $categorias,
            'currentCatPage' => $catPage,
            'totalCatPages' => $catTotalPages,
            'catPager' => $this->categoriaModel->pager,
            'currentCatFilter' => $catFilter,
            'currentCatDirection' => strtolower($catDirection)
        ];

        return view('../Views/plantillas/header_view',)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/perfil', $data)
            . view('../Views/plantillas/footer_view');
    }

    public function admin_juegos()
    {
        // Obtenemos la página actual y la cantidad de juegos por página
        $gamesPage = $this->request->getVar('page') ?? 1;
        $gamesPerPage = 20;

        // Obtenemos los parámetros de filtrado
        $gameFilter = $this->request->getVar('filter') ?? 'alphabetic';
        $gameDirection = $this->request->getVar('direction') ?? 'asc';

        // Validamos la dirección
        $gameDirection = strtoupper($gameDirection) === 'DESC' ? 'DESC' : 'ASC';

        // Dependiendo del filtro, ordenamos por la columna correspondiente
        $gamesOrderBy = match ($gameFilter) {
            'title' => 'title',
            'alphabetic' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // Obtenemos todos los juegos, aplicamos orden y paginación
        $juegos = $this->juegosModel
            ->select('game_id, title, price, release_date, card_image_url, logo_url')
            ->orderBy($gamesOrderBy, $gameDirection)
            ->paginate($gamesPerPage, 'default', $gamesPage);

        // Contamos el total de juegos y calculamos el total de páginas
        $gamesTotal = $this->juegosModel->countAll();
        $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);

        $dataGames = [
            'juegos' => $juegos,
            'currentGamesPage' => $gamesPage,
            'totalGamesPages' => $gamesTotalPages,
            'currentGameFilter' => $gameFilter,
            'currentDirection' => strtolower($gameDirection),
            'pager' => $this->juegosModel->pager
        ];

        if ($this->request->isAJAX()) {
            return view('content/partials/gestion-juegos', $dataGames);
        } else {
            return view('../Views/plantillas/header_view', $dataGames)
                . view('../Views/plantillas/side_cart')
                . view('../Views/content/perfil', $dataGames)
                . view('../Views/plantillas/footer_view');
        }
    }

    public function admin_usuarios()
    {
        $userPage = $this->request->getVar('page') ?? 1; // Obtener la página actual, por defecto es 1
        $userPerPage = 10; // Número de usuarios por página

        $userFilter = $this->request->getVar('filter') ?? 'user_id';
        $userDirection = $this->request->getVar('direction') ?? 'asc';

        $userDirection = strtoupper($userDirection) === 'DESC' ? 'DESC' : 'ASC';

        $userOrderBy = match ($userFilter) {
            'email' => 'email',
            'nickname' => 'nickname',
            'created_at' => 'created_at',
            'last_login' => 'last_login',
            default => 'user_id'
        };

        $usuarios = $this->usuariosModel
            ->select('user_id, email, nickname, created_at, last_login, is_active')
            ->orderBy($userOrderBy, $userDirection)
            ->paginate($userPerPage, 'default', $userPage);

        $userTotal = $this->usuariosModel->countAll();
        $userTotalPages = ceil($userTotal / $userPerPage);

        $dataUsers = [
            'title' => 'Gestión de Usuarios',
            'section_title' => 'Usuarios',
            'usuarios' => $usuarios,
            'currentUserPage' => $userPage,
            'totalUserPages' => $userTotalPages,
            'userPager' => $this->usuariosModel->pager,
            'currentUserFilter' => $userFilter,
            'currentUserDirection' => strtolower($userDirection)
        ];

        if ($this->request->isAJAX()) {
            return view('content/partials/gestion-usuarios', $dataUsers);
        } else {
            return view('../Views/plantillas/header_view.php', $dataUsers)
                . view('../Views/plantillas/side_cart.php')
                . view('../Views/content/perfil.php', $dataUsers)
                . view('../Views/plantillas/footer_view.php');
        }
    }

    public function admin_categorias()
    {
        $catPage = $this->request->getVar('page') ?? 1; // Obtener la página actual, por defecto es 1
        $catPerPage = 10; // Número de categorías por página

        $catFilter = $this->request->getVar('filter') ?? 'category_id';
        $catDirection = $this->request->getVar('direction') ?? 'asc';

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
            ->paginate($catPerPage, 'default', $catPage);

        $catTotal = $this->categoriaModel->countAll();
        $catTotalPages = ceil($catTotal / $catPerPage);

        $dataCat = [
            'title' => 'Gestión de Categorías',
            'section_title' => 'Categorías',
            'categorias' => $categorias,
            'currentCatPage' => $catPage,
            'totalCatPages' => $catTotalPages,
            'catPager' => $this->categoriaModel->pager,
            'currentCatFilter' => $catFilter,
            'currentCatDirection' => strtolower($catDirection)
        ];

        if ($this->request->isAJAX()) {
            return view('content/partials/gestion-categorias', $dataCat);
        } else {
            return view('../Views/plantillas/header_view.php')
                . view('../Views/plantillas/side_cart.php')
                . view('../Views/content/perfil.php', $dataCat)
                . view('../Views/plantillas/footer_view.php');
        }
    }
}
