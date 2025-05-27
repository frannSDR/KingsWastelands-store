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
        // JUEGOS
        $page = $this->request->getVar('page') ?? 1; // obtenemos la pagina actual y la cantidad de juegos por paginasi no se especifica la pagina, se usa la 1
        $perPage = 10; // 9 es la cantidad de juegos que mostramos por pagina
        $filter = $this->request->getVar('filter') ?? 'title'; // obtenenemos los parametros de filtrado, filtramos por titulo
        $direction = $this->request->getVar('direction') ?? 'asc';
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC'; // validamos la direccion y filtramos por el orden ascendente

        // dependiendo del filtro, ordenamos por la columna correspondiente, como filtramos por el titulo, lo hacemos alfabeticamente
        $orderBy = match ($filter) {
            'title' => 'title',
            'release' => 'release_date',
            'rating' => 'rating',
            'price' => 'price',
            default => 'rating'
        };

        // obtenemos todos los juegos, solo los campos necesarios, aplicamos el orden y paginacion
        $juegos = $this->juegosModel
            ->select('game_id, title, price, release_date, card_image_url')
            ->orderBy($orderBy, $direction)
            ->paginate($perPage, 'default', $page);

        // contamos el total de juegos y calculamos el total de paginas
        $total = $this->juegosModel->countAll();
        $totalPages = ceil($total / $perPage); // usamos ceil para redondear hacia arriba

        // USUARIOS
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

        // CATEGORIAS

        $catPage = $this->request->getVar('filter') ?? 1; // Obtener la página actual, por defecto es 1
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
            ->select('category_id, name_cat, slug')
            ->orderBy($catOrderBy, $catDirection)
            ->paginate($catPerPage, 'default', $catPage);

        $catTotal = $this->categoriaModel->countAll();
        $catTotalPages = ceil($catTotal / $catPerPage);

        // preparamos los datos para la vista en la pagina
        $data = [
            // Juegos
            'title' => 'Todos los Juegos',
            'juegos' => $juegos,
            'section_title' => 'Todos los Juegos',
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pager' => $this->juegosModel->pager,
            'currentFilter' => $filter,
            'currentDirection' => strtolower($direction),
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

        return view('../Views/plantillas/header_view', $data)
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/perfil')
            . view('../Views/plantillas/footer_view');
    }

    public function admin_juegos()
    {
        // Obtenemos la página actual y la cantidad de juegos por página
        $gamesPage = $this->request->getVar('page') ?? 1;
        $gamesPerPage = 10;

        // Obtenemos los parámetros de filtrado
        $gameFilter = $this->request->getVar('filter') ?? 'alphabetic';
        $direction = $this->request->getVar('direction') ?? 'asc';

        // Validamos la dirección
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

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
            ->select('game_id, title, price, release_date, card_image_url')
            ->orderBy($gamesOrderBy, $direction)
            ->paginate($gamesPerPage, 'default', $gamesPage);

        // Contamos el total de juegos y calculamos el total de páginas
        $gamesTotal = $this->juegosModel->countAll();
        $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);

        return view('content/partials/gestion-juegos', [
            'juegos' => $juegos,
            'currentPage' => $gamesPage,
            'totalPages' => $gamesTotalPages
        ]);
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

        return view('content/partials/gestion-usuarios', [
            'title' => 'Gestión de Usuarios',
            'usuarios' => $usuarios,
            'section_title' => 'Usuarios',
            'currentUserPage' => $userPage,
            'totalUserPages' => $userTotalPages,
            'userPager' => $this->usuariosModel->pager,
            'currentUserFilter' => $userFilter,
            'currentUserDirection' => strtolower($userDirection)
        ]);
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
            ->select('category_id, name_cat, slug')
            ->orderBy($catOrderBy, $catDirection)
            ->paginate($catPerPage, 'default', $catPage);

        $catTotal = $this->categoriaModel->countAll();
        $catTotalPages = ceil($catTotal / $catPerPage);

        return view('content/partials/gestion-categorias', [
            'title' => 'Gestión de Categorías',
            'categorias' => $categorias,
            'section_title' => 'Categorías',
            'currentCatPage' => $catPage,
            'totalCatPages' => $catTotalPages,
            'catPager' => $this->categoriaModel->pager,
            'currentCatFilter' => $catFilter,
            'currentCatDirection' => strtolower($catDirection)
        ]);
    }
}
