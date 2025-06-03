<?php

namespace App\Controllers\Admin_controllers;

use App\Controllers\BaseController;
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

        $gamesPage = $this->request->getVar('games_page') ?? 1; // obtenemos la pagina actual y la cantidad de juegos por paginasi no se especifica la pagina, se usa la 1
        $gamesPerPage = 20; // 25 es la cantidad de juegos que mostramos por pagina
        $gameFilter = $this->request->getVar('game_filter') ?? 'title'; // obtenenemos los parametros de filtrado, filtramos por titulo
        $gameDirection = $this->request->getVar('game_direction') ?? 'asc';
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
            ->paginate($gamesPerPage, 'games', $gamesPage);

        // contamos el total de juegos y calculamos el total de paginas
        $gamesTotal = $this->juegosModel->countAll();
        $gamesTotalPages = ceil($gamesTotal / $gamesPerPage); // usamos ceil para redondear hacia arriba

        //! USUARIOS

        $userPage = $this->request->getVar('user_page') ?? 1; // Obtener la página actual, por defecto es 1
        $userPerPage = 10; // Número de usuarios por página
        $userFilter = $this->request->getVar('user_filter') ?? 'user_id';
        $userDirection = $this->request->getVar('user_direction') ?? 'asc';
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
            ->paginate($userPerPage, 'users', $userPage);

        $userTotal = $this->usuariosModel->countAll();
        $userTotalPages = ceil($userTotal / $userPerPage);

        //! CATEGORIAS

        $catPage = $this->request->getVar('cat_page') ?? 1; // Obtener la página actual, por defecto es 1
        $catPerPage = 10; // Número de categorías por página
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

        // preparamos los datos para la vista en la pagina
        $data = [
            // Juegos
            'juegos' => $juegos,
            'currentGamesPage' => $gamesPage,
            'totalGamesPages' => $gamesTotalPages,
            'currentGameFilter' => $gameFilter,
            'currentDirection' => strtolower($gameDirection),
            'gamesPager' => $this->juegosModel->pager,
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

        return view('../Views/plantillas/header_view')
            . view('../Views/plantillas/side_cart')
            . view('../Views/content/perfil', $data)
            . view('../Views/plantillas/footer_view');
    }

    public function admin_usuarios()
    {
        $userPage = $this->request->getVar('user_page') ?? 1; // Obtener la página actual, por defecto es 1
        $userPerPage = 10; // Número de usuarios por página

        $userFilter = $this->request->getVar('user_filter') ?? 'user_id';
        $userDirection = $this->request->getVar('user_direction') ?? 'asc';

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
            ->paginate($userPerPage, 'users', $userPage);

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
            return redirect()->to(base_url('/perfil'));
        }
    }

    public function admin_juegos()
    {
        // Obtenemos la página actual y la cantidad de juegos por página
        $gamesPage = $this->request->getVar('games_page') ?? 1;
        $gamesPerPage = 20;

        // Obtenemos los parámetros de filtrado
        $gameFilter = $this->request->getVar('game_filter') ?? 'alphabetic';
        $gameDirection = $this->request->getVar('game_direction') ?? 'asc';

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
            ->paginate($gamesPerPage, 'games', $gamesPage);

        $categorias = $this->categoriaModel
            ->select('category_id, name_cat, slug')
            ->findAll();

        // Contamos el total de juegos y calculamos el total de páginas
        $gamesTotal = $this->juegosModel->countAll();
        $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);

        $dataGames = [
            'juegos' => $juegos,
            'currentGamesPage' => $gamesPage,
            'totalGamesPages' => $gamesTotalPages,
            'currentGameFilter' => $gameFilter,
            'currentDirection' => strtolower($gameDirection),
            'categorias' => $categorias,
            'gamesPager' => $this->juegosModel->pager
        ];

        if ($this->request->isAJAX()) {
            return view('content/partials/gestion-juegos', $dataGames);
        } else {
            return redirect()->to(base_url('/perfil'));
        }
    }

    public function subir_juego()
    {
        $session = session();

        // Seguridad: solo admin
        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('mensaje', 'Acceso no autorizado');
        }

        // Validación básica
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'price' => 'required|numeric',
            'release_date' => 'required|valid_date',
            'developer' => 'required',
            'about' => 'required',
            'synopsis' => 'required',
            'game_rating' => 'required|numeric',
            'categories' => 'required',
            'cover_url' => 'required|valid_url',
            'card_url' => 'required|valid_url',
            'banner_url' => 'required|valid_url',
            'logo_url' => 'required',
            'trailer' => 'required',
            'additional_images' => 'required',
            'min_cpu' => 'required',
            'min_ram' => 'required',
            'min_gpu' => 'required',
            'min_storage' => 'required',
            'rec_cpu' => 'required',
            'rec_ram' => 'required',
            'rec_gpu' => 'required',
            'rec_storage' => 'required',
            'ultra_cpu' => 'required',
            'ultra_ram' => 'required',
            'ultra_gpu' => 'required',
            'ultra_storage' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Guardar juego principal
        $gameData = [
            'title' => $this->request->getPost('title'),
            'price' => $this->request->getPost('price'),
            'release_date' => $this->request->getPost('release_date'),
            'developer' => $this->request->getPost('developer'),
            'rating' => $this->request->getPost('game_rating'),
            'about' => $this->request->getPost('about'),
            'synopsis' => $this->request->getPost('synopsis'),
            'youtube_trailer_id' => $this->request->getPost('trailer'),
            'cover_image_url' => $this->request->getPost('cover_url'),
            'card_image_url' => $this->request->getPost('card_url'),
            'banner_image_url' => $this->request->getPost('banner_url'),
            'logo_url' => $this->request->getPost('logo_url')
        ];

        $gameId = $this->juegosModel->insert($gameData);

        // Guardar categorías seleccionadas
        $categories = $this->request->getPost('categories');

        if (is_array($categories)) {
            foreach ($categories as $catId) {
                $this->juegoCategoriaModel->insert([
                    'game_id' => $gameId,
                    'category_id' => $catId
                ]);
            }
        }

        // Guardar imágenes adicionales
        $additionalImages = $this->request->getPost('additional_images');

        if (is_array($additionalImages)) {
            foreach ($additionalImages as $imgUrl) {
                $this->galeriaModel->insert([
                    'game_id' => $gameId,
                    'image_url' => $imgUrl
                ]);
            }
        }

        // Guardar requisitos
        $this->requisitosModel->insert([
            'game_id' => $gameId,
            'cpu' => $this->request->getPost('min_cpu'),
            'ram' => $this->request->getPost('min_ram'),
            'gpu' => $this->request->getPost('min_gpu'),
            'storage' => $this->request->getPost('min_storage'),
            'tipo' => 'minimo'
        ]);

        $this->requisitosModel->insert([
            'game_id' => $gameId,
            'cpu' => $this->request->getPost('rec_cpu'),
            'ram' => $this->request->getPost('rec_ram'),
            'gpu' => $this->request->getPost('rec_gpu'),
            'storage' => $this->request->getPost('rec_storage'),
            'tipo' => 'recomendado'
        ]);

        $this->requisitosModel->insert([
            'game_id' => $gameId,
            'cpu' => $this->request->getPost('ultra_cpu'),
            'ram' => $this->request->getPost('ultra_ram'),
            'gpu' => $this->request->getPost('ultra_gpu'),
            'storage' => $this->request->getPost('ultra_storage'),
            'tipo' => 'ultra'
        ]);

        return redirect()->to(base_url('/perfil'))->with('mensaje', 'Juego subido correctamente');
    }

    public function obtener_juego($id)
    {
        $juego = $this->juegosModel->find($id);
        if ($juego) {
            return $this->response->setJSON(['success' => true, 'juego' => $juego]);
        }
        return $this->response->setJSON(['success' => false]);
    }

    public function actualizar_juego($id)
    {
        $validation = \Config\Services::validation();

        // Validación igual que en subir_juego
        $validation->setRules([
            'title' => 'required',
            'price' => 'required|numeric',
            'release_date' => 'required|valid_date',
            'developer' => 'required',
            'about' => 'required',
            'synopsis' => 'required',
            'game_rating' => 'required|numeric',
            'categories' => 'required',
            'cover_url' => 'required|valid_url',
            'card_url' => 'required|valid_url',
            'banner_url' => 'required|valid_url',
            'logo_url' => 'required',
            'trailer' => 'required',
            'additional_images' => 'required',
            'min_cpu' => 'required',
            'min_ram' => 'required',
            'min_gpu' => 'required',
            'min_storage' => 'required',
            'rec_cpu' => 'required',
            'rec_ram' => 'required',
            'rec_gpu' => 'required',
            'rec_storage' => 'required',
            'ultra_cpu' => 'required',
            'ultra_ram' => 'required',
            'ultra_gpu' => 'required',
            'ultra_storage' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Actualizar datos principales del juego
        $gameData = [
            'title' => $this->request->getPost('title'),
            'price' => $this->request->getPost('price'),
            'release_date' => $this->request->getPost('release_date'),
            'developer' => $this->request->getPost('developer'),
            'rating' => $this->request->getPost('game_rating'),
            'about' => $this->request->getPost('about'),
            'synopsis' => $this->request->getPost('synopsis'),
            'youtube_trailer_id' => $this->request->getPost('trailer'),
            'cover_image_url' => $this->request->getPost('cover_url'),
            'card_image_url' => $this->request->getPost('card_url'),
            'banner_image_url' => $this->request->getPost('banner_url'),
            'logo_url' => $this->request->getPost('logo_url')
        ];
        $this->juegosModel->update($id, $gameData);

        // Actualizar categorías: eliminar las actuales y agregar las nuevas
        $this->juegoCategoriaModel->where('game_id', $id)->delete();
        $categories = $this->request->getPost('categories');
        if (is_array($categories)) {
            foreach ($categories as $catId) {
                $this->juegoCategoriaModel->insert([
                    'game_id' => $id,
                    'category_id' => $catId
                ]);
            }
        }

        // Actualizar imágenes adicionales: eliminar y volver a insertar
        $this->galeriaModel->where('game_id', $id)->delete();
        $additionalImages = $this->request->getPost('additional_images');
        if (is_array($additionalImages)) {
            foreach ($additionalImages as $imgUrl) {
                $this->galeriaModel->insert([
                    'game_id' => $id,
                    'image_url' => $imgUrl
                ]);
            }
        }

        // Actualizar requisitos: eliminar y volver a insertar
        $this->requisitosModel->where('game_id', $id)->delete();

        $this->requisitosModel->insert([
            'game_id' => $id,
            'cpu' => $this->request->getPost('min_cpu'),
            'ram' => $this->request->getPost('min_ram'),
            'gpu' => $this->request->getPost('min_gpu'),
            'storage' => $this->request->getPost('min_storage'),
            'tipo' => 'minimo'
        ]);
        $this->requisitosModel->insert([
            'game_id' => $id,
            'cpu' => $this->request->getPost('rec_cpu'),
            'ram' => $this->request->getPost('rec_ram'),
            'gpu' => $this->request->getPost('rec_gpu'),
            'storage' => $this->request->getPost('rec_storage'),
            'tipo' => 'recomendado'
        ]);
        $this->requisitosModel->insert([
            'game_id' => $id,
            'cpu' => $this->request->getPost('ultra_cpu'),
            'ram' => $this->request->getPost('ultra_ram'),
            'gpu' => $this->request->getPost('ultra_gpu'),
            'storage' => $this->request->getPost('ultra_storage'),
            'tipo' => 'ultra'
        ]);

        return redirect()->to(base_url('/perfil'))->with('mensaje', 'Juego actualizado correctamente');
    }

    public function admin_categorias()
    {
        $catPage = $this->request->getVar('cat_page') ?? 1; // Obtener la página actual, por defecto es 1
        $catPerPage = 10; // Número de categorías por página

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
            return redirect()->to(base_url('/perfil'));
        }
    }
}
