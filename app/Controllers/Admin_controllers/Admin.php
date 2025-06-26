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
use App\Models\ComprasModel;
use App\Models\DetalleCompraModel;

class Admin extends BaseController
{
    protected $juegosModel;
    protected $categoriaModel;
    protected $juegoCategoriaModel;
    protected $galeriaModel;
    protected $requisitosModel;
    protected $reviewModel;
    protected $usuariosModel;
    protected $comprasModel;
    protected $detalleModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->juegoCategoriaModel = new JuegoCategoriaModel();
        $this->galeriaModel = new GaleriaModel();
        $this->requisitosModel = new RequisitosModel();
        $this->reviewModel = new ReviewModel();
        $this->usuariosModel = new UsuarioModel();
        $this->comprasModel = new ComprasModel();
        $this->detalleModel = new DetalleCompraModel();
    }

    public function admin()
    {

        $session = session();

        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('error-msg', 'Acceso no autorizado');
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
            ->select('game_id, title, price, special_price, special_price_active, release_date, card_image_url, logo_url, is_active')
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
            ->select('user_id, user_img, email, nickname, created_at, last_login, is_active')
            ->orderBy($userOrderBy, $userDirection)
            ->paginate($userPerPage, 'users', $userPage);

        $userTotal = $this->usuariosModel->countAll();
        $userTotalPages = ceil($userTotal / $userPerPage);

        //! CATEGORIAS

        $catPage = $this->request->getVar('cat_page') ?? 1; // Obtener la página actual, por defecto es 1
        $catPerPage = 20; // Número de categorías por página
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

        $ventasPage = $this->request->getVar('ventas_page') ?? 1;
        $ventasPerPage = 10;

        $compras = $this->comprasModel
            ->orderBy('compra_id', 'DESC')
            ->paginate($ventasPerPage, 'ventas', $ventasPage);

        $ventasTotal = $this->comprasModel->countAll();
        $ventasTotalPages = ceil($ventasTotal / $ventasPerPage);

        $comprasData = [];
        foreach ($compras as $compra) {
            $usuario = $this->usuariosModel->find($compra['user_id']);
            $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
            $productos = [];
            foreach ($detalles as $detalle) {
                $juego = $this->juegosModel->find($detalle['game_id']);
                if ($juego) {
                    $productos[] = [
                        'nombre' => $juego['title'],
                        'precio_unitario' => $detalle['precio_unitario'],
                        'imagen' => $juego['cover_image_url'] ?? '',
                        'platform' => $juego['platform'] ?? '',
                        'sku' => $juego['sku'] ?? '',
                        'cantidad' => 1
                    ];
                }
            }
            $comprasData[] = [
                'compra_id' => $compra['compra_id'],
                'fecha' => $compra['fecha'],
                'nombre_completo' => $compra['nombre_completo'],
                'email' => $compra['email'],
                'telefono' => $compra['telefono'],
                'user_id' => $compra['user_id'],
                'user_nickname' => $usuario['nickname'] ?? '',
                'user_email' => $usuario['email'] ?? '',
                'total' => $compra['total'],
                'metodo_pago' => $compra['metodo_pago'] ?? '',
                'productos' => $productos,
                'estado' => 'Completada',
            ];
        }

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
            'currentCatDirection' => strtolower($catDirection),
            // Ventas
            'compras' => $comprasData,
            'currentVentasPage' => $ventasPage,
            'totalVentasPages' => $ventasTotalPages,
        ];

        return view('../Views/plantillas/header_view')
            . view('../Views/content/admin-section', $data)
            . view('../Views/plantillas/footer_view');
    }

    public function subir_foto()
    {
        // verificar si se envio un archivo
        if (!$this->validate([
            'profile_image' => [
                'uploaded[profile_image]',
                'mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                'max_size[profile_image,2048]', // 2MB máximo
            ]
        ])) {
            return redirect()->back()->with('error-msg', $this->validator->getErrors());
        }

        $file = $this->request->getFile('profile_image');

        // verificar si el archivo es válido y no se movió por error
        if (!$file->isValid()) {
            return redirect()->back()->with('error-msg', $file->getErrorString());
        }

        // generamos un nombre unico para cada imagen asi evitamos problemas de coincidencia
        $newName = $file->getRandomName();

        // verificamos que la carpeta exista, si no existe, se crea una automaticamente y mueve las imagenes ahi
        $path = FCPATH . 'assets/uploads/profile_imgs';

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        // movemos el archivo a la carpeta deseada (en este caso public/assets/uploads/profile_images)
        $file->move(FCPATH . 'assets/uploads/profile_imgs', $newName);

        // obtenenemos el ID del usuario actual de la sesion
        $userId = session()->get('user_id');

        // actualizamos la base de datos con el nombre del archivo
        $userModel = $this->usuariosModel;
        $userModel->update($userId, ['user_img' => $newName]);
        session()->set('user_img', $newName);

        return redirect()->to(base_url('/admin-section'))->with('exito-msg', 'Foto de perfil actualizada');
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
            ->select('user_id, user_img, email, nickname, created_at, last_login, is_active')
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
            // Si no es AJAX, mostrar la vista completa del admin enfocada en usuarios
            // Cargar datos básicos de las otras secciones
            $gamesPage = 1;
            $gamesPerPage = 20;
            $juegos = $this->juegosModel
                ->select('game_id, title, price, special_price, special_price_active, release_date, card_image_url, logo_url, is_active')
                ->orderBy('title', 'ASC')
                ->paginate($gamesPerPage, 'games', $gamesPage);
            $gamesTotal = $this->juegosModel->countAll();
            $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);

            $categorias = $this->categoriaModel->findAll();

            $catPage = 1;
            $catPerPage = 20;
            $categoriasForCat = $this->categoriaModel
                ->select('categorias.category_id, categorias.name_cat, categorias.slug, COUNT(juego_categorias.game_id) as juegos_count')
                ->join('juego_categorias', 'juego_categorias.category_id = categorias.category_id', 'left')
                ->groupBy('categorias.category_id')
                ->orderBy('category_id', 'ASC')
                ->paginate($catPerPage, 'categories', $catPage);
            $catTotal = $this->categoriaModel->countAll();
            $catTotalPages = ceil($catTotal / $catPerPage);

            $ventasPage = 1;
            $ventasPerPage = 10;
            $compras = $this->comprasModel
                ->orderBy('compra_id', 'DESC')
                ->paginate($ventasPerPage, 'ventas', $ventasPage);
            $ventasTotal = $this->comprasModel->countAll();
            $ventasTotalPages = ceil($ventasTotal / $ventasPerPage);

            $comprasData = [];
            foreach ($compras as $compra) {
                $usuario = $this->usuariosModel->find($compra['user_id']);
                $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
                $productos = [];
                foreach ($detalles as $detalle) {
                    $juego = $this->juegosModel->find($detalle['game_id']);
                    if ($juego) {
                        $productos[] = [
                            'nombre' => $juego['title'],
                            'precio_unitario' => $detalle['precio_unitario'],
                            'imagen' => $juego['cover_image_url'] ?? '',
                            'platform' => $juego['platform'] ?? '',
                            'sku' => $juego['sku'] ?? '',
                            'cantidad' => 1
                        ];
                    }
                }
                $comprasData[] = [
                    'compra_id' => $compra['compra_id'],
                    'fecha' => $compra['fecha'],
                    'nombre_completo' => $compra['nombre_completo'],
                    'email' => $compra['email'],
                    'telefono' => $compra['telefono'],
                    'user_id' => $compra['user_id'],
                    'user_nickname' => $usuario['nickname'] ?? '',
                    'user_email' => $usuario['email'] ?? '',
                    'total' => $compra['total'],
                    'metodo_pago' => $compra['metodo_pago'] ?? '',
                    'productos' => $productos,
                    'estado' => 'Completada',
                ];
            }

            $completeData = [
                // Juegos
                'juegos' => $juegos,
                'currentGamesPage' => $gamesPage,
                'totalGamesPages' => $gamesTotalPages,
                'currentGameFilter' => 'title',
                'currentDirection' => 'asc',
                'gamesPager' => $this->juegosModel->pager,
                'categorias' => $categorias,
                // Usuarios (datos completos)
                'usuarios' => $dataUsers['usuarios'],
                'currentUserPage' => $dataUsers['currentUserPage'],
                'totalUserPages' => $dataUsers['totalUserPages'],
                'userPager' => $dataUsers['userPager'],
                'currentUserFilter' => $dataUsers['currentUserFilter'],
                'currentUserDirection' => $dataUsers['currentUserDirection'],
                // Categorias
                'currentCatPage' => $catPage,
                'totalCatPages' => $catTotalPages,
                'catPager' => $this->categoriaModel->pager,
                'currentCatFilter' => 'category_id',
                'currentCatDirection' => 'asc',
                // Ventas
                'compras' => $comprasData,
                'currentVentasPage' => $ventasPage,
                'totalVentasPages' => $ventasTotalPages,
            ];

            // Sobrescribir categorias con la data específica para categorías después
            $completeData['categorias'] = $categoriasForCat;

            return view('../Views/plantillas/header_view')
                . view('../Views/content/admin-section', $completeData)
                . view('../Views/plantillas/footer_view');
        }
    }

    public function banear_usuario($id = null)
    {
        $this->usuariosModel->update($id, ['is_active' => 0]);
        return redirect()->to(base_url('/admin-section/admin-usuarios'))->with('exito-msg', 'Usuario baneado correctamente');
    }

    public function desbanear_usuario($id = null)
    {
        $this->usuariosModel->update($id, ['is_active' => 1]);
        return redirect()->to(base_url('/admin-section/admin-usuarios'))->with('exito-msg', 'Usuario desbaneado correctamente');
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
            ->select('game_id, title, price, special_price, special_price_active, release_date, card_image_url, logo_url, is_active')
            ->orderBy($gamesOrderBy, $gameDirection)
            ->paginate($gamesPerPage, 'games', $gamesPage);

        $categorias = $this->categoriaModel
            ->select('category_id, name_cat, slug')
            ->findAll();

        // Contamos el total de juegos y calculamos el total de páginas
        $gamesTotal = $this->juegosModel->countAll();
        $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);
        $gamePager = $this->juegosModel->pager;

        $dataGames = [
            'juegos' => $juegos,
            'currentGamesPage' => $gamesPage,
            'totalGamesPages' => $gamesTotalPages,
            'currentGameFilter' => $gameFilter,
            'currentDirection' => strtolower($gameDirection),
            'categorias' => $categorias,
            'gamesPager' => $gamePager
        ];

        if ($this->request->isAJAX()) {
            return view('content/partials/gestion-juegos', $dataGames);
        } else {
            // Si no es AJAX, mostrar la vista completa del admin enfocada en juegos
            // Cargar datos básicos de las otras secciones
            $userPage = 1;
            $userPerPage = 10;
            $usuarios = $this->usuariosModel
                ->select('user_id, user_img, email, nickname, created_at, last_login, is_active')
                ->orderBy('user_id', 'ASC')
                ->paginate($userPerPage, 'users', $userPage);
            $userTotal = $this->usuariosModel->countAll();
            $userTotalPages = ceil($userTotal / $userPerPage);

            $catPage = 1;
            $catPerPage = 20;
            $categoriasForCat = $this->categoriaModel
                ->select('categorias.category_id, categorias.name_cat, categorias.slug, COUNT(juego_categorias.game_id) as juegos_count')
                ->join('juego_categorias', 'juego_categorias.category_id = categorias.category_id', 'left')
                ->groupBy('categorias.category_id')
                ->orderBy('category_id', 'ASC')
                ->paginate($catPerPage, 'categories', $catPage);
            $catTotal = $this->categoriaModel->countAll();
            $catTotalPages = ceil($catTotal / $catPerPage);

            $ventasPage = 1;
            $ventasPerPage = 10;
            $compras = $this->comprasModel
                ->orderBy('compra_id', 'DESC')
                ->paginate($ventasPerPage, 'ventas', $ventasPage);
            $ventasTotal = $this->comprasModel->countAll();
            $ventasTotalPages = ceil($ventasTotal / $ventasPerPage);

            $comprasData = [];
            foreach ($compras as $compra) {
                $usuario = $this->usuariosModel->find($compra['user_id']);
                $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
                $productos = [];
                foreach ($detalles as $detalle) {
                    $juego = $this->juegosModel->find($detalle['game_id']);
                    if ($juego) {
                        $productos[] = [
                            'nombre' => $juego['title'],
                            'precio_unitario' => $detalle['precio_unitario'],
                            'imagen' => $juego['cover_image_url'] ?? '',
                            'platform' => $juego['platform'] ?? '',
                            'sku' => $juego['sku'] ?? '',
                            'cantidad' => 1
                        ];
                    }
                }
                $comprasData[] = [
                    'compra_id' => $compra['compra_id'],
                    'fecha' => $compra['fecha'],
                    'nombre_completo' => $compra['nombre_completo'],
                    'email' => $compra['email'],
                    'telefono' => $compra['telefono'],
                    'user_id' => $compra['user_id'],
                    'user_nickname' => $usuario['nickname'] ?? '',
                    'user_email' => $usuario['email'] ?? '',
                    'total' => $compra['total'],
                    'metodo_pago' => $compra['metodo_pago'] ?? '',
                    'productos' => $productos,
                    'estado' => 'Completada',
                ];
            }

            $completeData = [
                // Juegos (datos completos)
                'juegos' => $dataGames['juegos'],
                'currentGamesPage' => $dataGames['currentGamesPage'],
                'totalGamesPages' => $dataGames['totalGamesPages'],
                'currentGameFilter' => $dataGames['currentGameFilter'],
                'currentDirection' => $dataGames['currentDirection'],
                'gamesPager' => $dataGames['gamesPager'],
                'categorias' => $dataGames['categorias'],
                // Usuarios
                'usuarios' => $usuarios,
                'currentUserPage' => $userPage,
                'totalUserPages' => $userTotalPages,
                'userPager' => $this->usuariosModel->pager,
                'currentUserFilter' => 'user_id',
                'currentUserDirection' => 'asc',
                // Categorias
                'currentCatPage' => $catPage,
                'totalCatPages' => $catTotalPages,
                'catPager' => $this->categoriaModel->pager,
                'currentCatFilter' => 'category_id',
                'currentCatDirection' => 'asc',
                // Ventas
                'compras' => $comprasData,
                'currentVentasPage' => $ventasPage,
                'totalVentasPages' => $ventasTotalPages,
            ];

            // Sobrescribir categorias con la data específica para categorías después
            $completeData['categorias'] = $categoriasForCat;

            return view('../Views/plantillas/header_view')
                . view('../Views/content/admin-section', $completeData)
                . view('../Views/plantillas/footer_view');
        }
    }

    public function subir_juego()
    {
        $session = session();

        // seguridad: solo admin
        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('error-msg', 'Acceso no autorizado');
        }

        // Validación básica
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'price' => 'required|numeric',
            'release_date' => 'valid_date',
            'developer' => 'required',
            'about' => 'required',
            'synopsis' => 'required',
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
            return redirect()->back()->withInput()->with('error-msg', $validation->getErrors());
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

        return redirect()->to(base_url('/admin-section'))->with('exito-msg', 'Juego subido correctamente');
    }

    public function obtener_juego($id = null)
    {

        // obtenemos el id del juego correspondiente que queremos editar
        $juego = $this->juegosModel->find($id);
        if (!$juego) {
            return $this->response->setJSON(['success' => false]);
        }

        // obtenemos las categorias
        $categorias = $this->juegoCategoriaModel
            ->where('game_id', $id)
            ->findAll();
        $categoriaIds = array_map(fn($cat) => (int)$cat['category_id'], $categorias);

        // obtenemos las imagenes adicionales
        $imagenes = $this->galeriaModel
            ->where('game_id', $id)
            ->findAll();
        $imagenesUrls = array_map(fn($img) => $img['image_url'], $imagenes);

        // obtenemos los requisitos
        $requisitos = $this->requisitosModel
            ->where('game_id', $id)
            ->findAll();
        $reqs = [
            'minimo' => null,
            'recomendado' => null,
            'ultra' => null
        ];

        foreach ($requisitos as $req) {
            if ($req['tipo'] === 'minimo') {
                $reqs['minimo'] = [
                    'cpu' => $req['cpu'],
                    'ram' => $req['ram'],
                    'gpu' => $req['gpu'],
                    'storage' => $req['storage'],
                ];
            }
            if ($req['tipo'] === 'recomendado') {
                $reqs['recomendado'] = [
                    'cpu' => $req['cpu'],
                    'ram' => $req['ram'],
                    'gpu' => $req['gpu'],
                    'storage' => $req['storage'],
                ];
            }
            if ($req['tipo'] === 'ultra') {
                $reqs['ultra'] = [
                    'cpu' => $req['cpu'],
                    'ram' => $req['ram'],
                    'gpu' => $req['gpu'],
                    'storage' => $req['storage'],
                ];
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'juego' => $juego,
            'categories' => $categoriaIds,
            'additional_images' => $imagenesUrls,
            'requisitos' => $reqs
        ]);
    }

    public function actualizar_juego($id = null)
    {
        $validation = \Config\Services::validation();

        // Validación igual que en subir_juego
        $validation->setRules([
            'title' => 'required',
            'price' => 'required|numeric',
            'release_date' => 'valid_date',
            'developer' => 'required',
            'about' => 'required',
            'synopsis' => 'required',
            'game_rating' => 'numeric',
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

        return redirect()->to(base_url('/admin-section'))->with('exito-msg', 'Juego actualizado correctamente');
    }

    public function desactivar_juego($id = null)
    {
        $this->juegosModel->update($id, ['is_active' => 0]);
        return redirect()->to(base_url('/admin-section'))->with('exito-msg', 'Juego desactivado correctamente');
    }

    public function activar_juego($id = null)
    {
        $this->juegosModel->update($id, ['is_active' => 1]);
        return redirect()->to(base_url('/admin-section'))->with('exito-msg', 'Juego activado correctamente');
    }

    public function admin_categorias()
    {
        $catPage = $this->request->getVar('cat_page') ?? 1; // Obtener la página actual, por defecto es 1
        $catPerPage = 20; // Número de categorías por página

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
            // Si no es AJAX, mostrar la vista completa del admin enfocada en categorías
            // Cargar datos básicos de las otras secciones
            $gamesPage = 1;
            $gamesPerPage = 20;
            $juegos = $this->juegosModel
                ->select('game_id, title, price, special_price, special_price_active, release_date, card_image_url, logo_url, is_active')
                ->orderBy('title', 'ASC')
                ->paginate($gamesPerPage, 'games', $gamesPage);
            $gamesTotal = $this->juegosModel->countAll();
            $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);

            $categoriasForGames = $this->categoriaModel->findAll();

            $userPage = 1;
            $userPerPage = 10;
            $usuarios = $this->usuariosModel
                ->select('user_id, user_img, email, nickname, created_at, last_login, is_active')
                ->orderBy('user_id', 'ASC')
                ->paginate($userPerPage, 'users', $userPage);
            $userTotal = $this->usuariosModel->countAll();
            $userTotalPages = ceil($userTotal / $userPerPage);

            $ventasPage = 1;
            $ventasPerPage = 10;
            $compras = $this->comprasModel
                ->orderBy('compra_id', 'DESC')
                ->paginate($ventasPerPage, 'ventas', $ventasPage);
            $ventasTotal = $this->comprasModel->countAll();
            $ventasTotalPages = ceil($ventasTotal / $ventasPerPage);

            $comprasData = [];
            foreach ($compras as $compra) {
                $usuario = $this->usuariosModel->find($compra['user_id']);
                $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
                $productos = [];
                foreach ($detalles as $detalle) {
                    $juego = $this->juegosModel->find($detalle['game_id']);
                    if ($juego) {
                        $productos[] = [
                            'nombre' => $juego['title'],
                            'precio_unitario' => $detalle['precio_unitario'],
                            'imagen' => $juego['cover_image_url'] ?? '',
                            'platform' => $juego['platform'] ?? '',
                            'sku' => $juego['sku'] ?? '',
                            'cantidad' => 1
                        ];
                    }
                }
                $comprasData[] = [
                    'compra_id' => $compra['compra_id'],
                    'fecha' => $compra['fecha'],
                    'nombre_completo' => $compra['nombre_completo'],
                    'email' => $compra['email'],
                    'telefono' => $compra['telefono'],
                    'user_id' => $compra['user_id'],
                    'user_nickname' => $usuario['nickname'] ?? '',
                    'user_email' => $usuario['email'] ?? '',
                    'total' => $compra['total'],
                    'metodo_pago' => $compra['metodo_pago'] ?? '',
                    'productos' => $productos,
                    'estado' => 'Completada',
                ];
            }

            $completeData = [
                // Juegos
                'juegos' => $juegos,
                'currentGamesPage' => $gamesPage,
                'totalGamesPages' => $gamesTotalPages,
                'currentGameFilter' => 'title',
                'currentDirection' => 'asc',
                'gamesPager' => $this->juegosModel->pager,
                'categorias' => $categoriasForGames,
                // Usuarios
                'usuarios' => $usuarios,
                'currentUserPage' => $userPage,
                'totalUserPages' => $userTotalPages,
                'userPager' => $this->usuariosModel->pager,
                'currentUserFilter' => 'user_id',
                'currentUserDirection' => 'asc',
                // Categorias (datos completos)
                'currentCatPage' => $dataCat['currentCatPage'],
                'totalCatPages' => $dataCat['totalCatPages'],
                'catPager' => $dataCat['catPager'],
                'currentCatFilter' => $dataCat['currentCatFilter'],
                'currentCatDirection' => $dataCat['currentCatDirection'],
                // Ventas
                'compras' => $comprasData,
                'currentVentasPage' => $ventasPage,
                'totalVentasPages' => $ventasTotalPages,
            ];

            // Agregar las categorías específicas después para evitar conflictos
            $completeData['categorias'] = $dataCat['categorias'];

            return view('../Views/plantillas/header_view')
                . view('../Views/content/admin-section', $completeData)
                . view('../Views/plantillas/footer_view');
        }
    }

    public function eliminar_categoria($id = null)
    {
        $this->categoriaModel->delete($id);
        return redirect()->to(base_url('/admin-section/admin-categorias'))->with('exito-msg', 'Categoría borrada correctamente');
    }

    public function agregar_categoria()
    {
        $session = session();

        // seguridad: solo admin
        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('error-msg', 'Acceso no autorizado');
        }

        // validacion basica
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name_cat' => 'required',
            'slug' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $catData = [
            'name_cat' => $this->request->getPost('name_cat'),
            'slug' => $this->request->getPost('slug')
        ];

        $this->categoriaModel->insert($catData);

        return redirect()->to(base_url('/admin-section'))->with('exito-msg', 'Categoria añadida correctamente');
    }

    public function admin_ventas()
    {
        $session = session();
        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('error-msg', 'Acceso no autorizado');
        }

        $ventasPage = $this->request->getVar('ventas_page') ?? 1;
        $ventasPerPage = 10;

        // Paginación de compras
        $compras = $this->comprasModel
            ->orderBy('compra_id', 'DESC')
            ->paginate($ventasPerPage, 'ventas', $ventasPage);

        $ventasTotal = $this->comprasModel->countAll();
        $ventasTotalPages = ceil($ventasTotal / $ventasPerPage);

        $comprasData = [];
        foreach ($compras as $compra) {
            $usuario = $this->usuariosModel->find($compra['user_id']);
            $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
            $productos = [];
            foreach ($detalles as $detalle) {
                $juego = $this->juegosModel->find($detalle['game_id']);
                if ($juego) {
                    $productos[] = [
                        'nombre' => $juego['title'],
                        'precio_unitario' => $detalle['precio_unitario'],
                        'imagen' => $juego['cover_image_url'] ?? '',
                        'platform' => $juego['platform'] ?? '',
                        'sku' => $juego['sku'] ?? '',
                        'cantidad' => 1
                    ];
                }
            }

            $comprasData[] = [
                'compra_id' => $compra['compra_id'],
                'fecha' => $compra['fecha'],
                'nombre_completo' => $compra['nombre_completo'],
                'email' => $compra['email'],
                'telefono' => $compra['telefono'],
                'user_id' => $compra['user_id'],
                'user_nickname' => $usuario['nickname'] ?? '',
                'user_email' => $usuario['email'] ?? '',
                'total' => $compra['total'],
                'metodo_pago' => $compra['metodo_pago'] ?? '',
                'productos' => $productos,
                'estado' => 'Completada',
            ];
        }

        $data = [
            'compras' => $comprasData,
            'currentVentasPage' => $ventasPage,
            'totalVentasPages' => $ventasTotalPages,
        ];

        // Si es AJAX, solo la tabla
        if ($this->request->isAJAX()) {
            return view('content/partials/gestion-ordenes', $data);
        } else {
            // Si no es AJAX, mostrar la vista completa del admin con datos de ventas
            // Necesitamos cargar los datos de las otras secciones también
            $gamesPage = 1;
            $gamesPerPage = 20;
            $juegos = $this->juegosModel
                ->select('game_id, title, price, special_price, special_price_active, release_date, card_image_url, logo_url, is_active')
                ->orderBy('title', 'ASC')
                ->paginate($gamesPerPage, 'games', $gamesPage);
            $gamesTotal = $this->juegosModel->countAll();
            $gamesTotalPages = ceil($gamesTotal / $gamesPerPage);

            $userPage = 1;
            $userPerPage = 10;
            $usuarios = $this->usuariosModel
                ->select('user_id, user_img, email, nickname, created_at, last_login, is_active')
                ->orderBy('user_id', 'ASC')
                ->paginate($userPerPage, 'users', $userPage);
            $userTotal = $this->usuariosModel->countAll();
            $userTotalPages = ceil($userTotal / $userPerPage);

            $catPage = 1;
            $catPerPage = 20;
            $categorias = $this->categoriaModel
                ->select('categorias.category_id, categorias.name_cat, categorias.slug, COUNT(juego_categorias.game_id) as juegos_count')
                ->join('juego_categorias', 'juego_categorias.category_id = categorias.category_id', 'left')
                ->groupBy('categorias.category_id')
                ->orderBy('category_id', 'ASC')
                ->paginate($catPerPage, 'categories', $catPage);
            $catTotal = $this->categoriaModel->countAll();
            $catTotalPages = ceil($catTotal / $catPerPage);

            $completeData = [
                // Juegos
                'juegos' => $juegos,
                'currentGamesPage' => $gamesPage,
                'totalGamesPages' => $gamesTotalPages,
                'currentGameFilter' => 'title',
                'currentDirection' => 'asc',
                'gamesPager' => $this->juegosModel->pager,
                // Usuarios
                'usuarios' => $usuarios,
                'currentUserPage' => $userPage,
                'totalUserPages' => $userTotalPages,
                'userPager' => $this->usuariosModel->pager,
                'currentUserFilter' => 'user_id',
                'currentUserDirection' => 'asc',
                // Categorias
                'categorias' => $categorias,
                'currentCatPage' => $catPage,
                'totalCatPages' => $catTotalPages,
                'catPager' => $this->categoriaModel->pager,
                'currentCatFilter' => 'category_id',
                'currentCatDirection' => 'asc',
                // Ventas
                'compras' => $data['compras'],
                'currentVentasPage' => $data['currentVentasPage'],
                'totalVentasPages' => $data['totalVentasPages'],
            ];

            return view('../Views/plantillas/header_view')
                . view('../Views/content/admin-section', $completeData)
                . view('../Views/plantillas/footer_view');
        }
    }

    public function aplicar_descuento_juego($game_id = null)
    {
        $session = session();
        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('error-msg', 'Acceso no autorizado');
        }

        $porcentaje = $this->request->getPost('porcentaje');
        if (!$porcentaje || !is_numeric($porcentaje) || $porcentaje <= 0 || $porcentaje >= 100) {
            return redirect()->back()->with('error-msg', 'Porcentaje inválido');
        }

        $juego = $this->juegosModel->find($game_id);
        if (!$juego) {
            return redirect()->back()->with('error-msg', 'Juego no encontrado');
        }

        $special_price = round($juego['price'] * (1 - ($porcentaje / 100)), 2);

        $this->juegosModel->update($game_id, [
            'special_price' => $special_price,
            'special_price_active' => 1
        ]);

        return redirect()->back()->with('exito-msg', 'Descuento aplicado correctamente');
    }

    public function quitar_descuento_juego($game_id = null)
    {
        $session = session();
        if (!$session->has('user_id') || $session->get('is_admin') != 1) {
            return redirect()->to(base_url('/'))->with('error-msg', 'Acceso no autorizado');
        }

        $juego = $this->juegosModel->find($game_id);
        if (!$juego) {
            return redirect()->back()->with('error-msg', 'Juego no encontrado');
        }

        $this->juegosModel->update($game_id, [
            'special_price' => null,
            'special_price_active' => 0
        ]);

        return redirect()->back()->with('exito-msg', 'Descuento quitado correctamente');
    }
}
