<?php

namespace App\Controllers\User_controllers;

use App\Controllers\BaseController;
use App\Models\CartItemModel;
use App\Models\JuegosModel;
use App\Models\CategoriaModel;
use App\Models\JuegoCategoriaModel;
use App\Models\UsuarioModel;
use App\Models\WishlistModel;
use App\Models\WishlistItemModel;
use App\Models\CartModel;

class UserProfile extends BaseController
{
    protected $juegosModel;
    protected $categoriaModel;
    protected $juegoCategoriaModel;
    protected $usuariosModel;
    protected $wishlistModel;
    protected $wishlistItemModel;
    protected $cartModel;
    protected $cartItemModel;
    protected $comprasModel;
    protected $detalleModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->juegoCategoriaModel = new JuegoCategoriaModel();
        $this->usuariosModel = new UsuarioModel();
        $this->wishlistModel = new WishlistModel();
        $this->wishlistItemModel = new WishlistItemModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->comprasModel = new \App\Models\ComprasModel();
        $this->detalleModel = new \App\Models\DetalleCompraModel();
    }

    public function perfil()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('alerta-msg', 'Primero debes estar logueado!');
        }

        $usuario = $this->usuariosModel->find($userId);

        // Obtener la wishlist del usuario
        $wishlistItems = $this->wishlistItemModel
            ->where('user_id', $userId)
            ->findAll();

        $deseados = [];
        foreach ($wishlistItems as $item) {
            $juego = $this->juegosModel
                ->select('game_id, title, price, release_date, card_image_url')
                ->find($item['game_id']);
            if ($juego) {
                $deseados[] = $juego;
            }
        }

        $compras = $this->comprasModel->where('user_id', $userId)->orderBy('fecha', 'DESC')->findAll();

        $comprasData = [];
        foreach ($compras as $compra) {
            $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
            $items = [];
            $subtotal = 0;

            foreach ($detalles as $detalle) {
                $juego = $this->juegosModel->find($detalle['game_id']);
                if ($juego) {
                    $items[] = [
                        'image' => $juego['cover_image_url'] ?? '',
                        'title' => $juego['title'],
                        'price' => number_format($detalle['precio_unitario'], 2),
                    ];
                    $subtotal += floatval($detalle['precio_unitario']);
                }
            }

            $total = $compra['total'];

            $comprasData[] = [
                'order_id' => $compra['compra_id'],
                'purchase_date' => $compra['fecha'],
                'status' => strtoupper($compra['estado'] ?? 'COMPLETED'),
                'items' => $items,
                'subtotal' => $subtotal,
                'total' => $total,
            ];
        }

        return view('plantillas/header_view')
            . view('content/user_perfil', [
                'usuario' => $usuario,
                'deseados' => $deseados,
                'compras' => $comprasData
            ])
            . view('plantillas/footer_view');
    }

    public function datos_usuario()
    {
        $userId = session('user_id');
        if (!$userId) {
            // Si no está logueado, redirige al login
            return redirect()->to(base_url('login'))->with('alerta-msg', 'Primero debes estar logueado!');
        }

        // Obtén los datos del usuario
        $usuario = $this->usuariosModel
            ->select('nickname, created_at, email, user_img')
            ->find($userId);

        if (!$usuario) {
            // Si no existe el usuario, redirige o muestra error
            return redirect()->to(base_url('/'))->with('error-msg', 'Usuario no encontrado');
        }

        $data = [
            'usuario' => $usuario
        ];

        // Pasa los datos a la vista
        return view('/plantillas/header_view')
            . view('content/user_perfil', $data)
            . view('/plantillas/footer_view');
    }

    public function user_subir_foto()
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

        return redirect()->to(base_url('/user-perfil'))->with('exito-msg', 'Foto de perfil actualizada');
    }

    public function actualizar_datos()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Petición inválida']);
        }

        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'No autenticado']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nickname' => 'required|min_length[3]|max_length[30]|is_unique[usuarios.nickname]',
            'email'    => 'required|valid_email|is_unique[usuarios.email]'
        ], [
            'nickname' => [
                'is_unique' => 'El nombre de usuario ya existe',
                'required' => 'El nombre de usuario es obligatorio',
                'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres',
                'max_length' => 'El nombre de usuario no puede superar los 30 caracteres'
            ],
            'email' => [
                'is_unique' => 'El correo electrónico ya existe',
                'required' => 'El correo electrónico es obligatorio',
                'valid_email' => 'El correo electrónico no es válido'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $nickname = $this->request->getPost('nickname');
        $email = $this->request->getPost('email');

        $this->usuariosModel->update($userId, [
            'nickname' => $nickname,
            'email' => $email
        ]);

        session()->set('nickname', $nickname);
        session()->set('email', $email);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Datos actualizados correctamente.',
            'nickname' => $nickname,
            'email' => $email
        ]);
    }

    public function show_wishlist()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('alerta-msg', 'Primero debes iniciar sesión.');
        }

        $wishlistItems = $this->wishlistItemModel
            ->where('user_id', $userId)
            ->findAll();

        $deseados = [];

        foreach ($wishlistItems as $item) {
            $juego = $this->juegosModel
                ->select('game_id, title, price, release_date, card_image_url')
                ->find($item['game_id']);
            if ($juego) {
                $deseados[] = $juego;
            }
        }

        // obtenemos los juegos en el carrito del usuario
        $enCarritoIds = [];
        if (session()->has('user_id')) {
            $userId = session('user_id');
            $cart = $this->cartModel->where('user_id', $userId)->first();
            if ($cart) {
                $cartItems = $this->cartItemModel
                    ->where('cart_id', $cart['cart_id'])
                    ->findAll();
                $enCarritoIds = array_column($cartItems, 'game_id');
            }
        }

        // verificamos si un juego se encuentra en el carrito
        foreach ($deseados as &$juego) {
            $juego['enCarrito'] = in_array($juego['game_id'], $enCarritoIds);
        }

        foreach ($deseados as &$juego) {
            $juego['enCarrito'] = in_array($juego['game_id'], $enCarritoIds);
        }

        unset($juego);

        $data = [
            'deseados' => $deseados,
            'enCarritoIds' => $enCarritoIds ?? []
        ];

        return view('content/partials/wishlist-user-profile', $data);
    }

    public function add_to_wishlist()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Petición inválida']);
        }

        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Debes inicar sesión para acceder a esta función.']);
        }

        $gameId = $this->request->getPost('game_id');
        if (!$gameId) {
            $json = $this->request->getJSON();
            $gameId = $json->game_id ?? null;
        }
        if (!$gameId) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'ID de juego no proporcionado']);
        }

        // verifica si el usuario ya tiene una wishlist, si no, la crea
        $wishlist = $this->wishlistModel->where('user_id', $userId)->first();
        if (!$wishlist) {
            $this->wishlistModel->insert([
                'user_id' => $userId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // actualiza la fecha de actualización
            $this->wishlistModel->update($wishlist['user_id'], [
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // verifica si el juego ya está en la wishlist
        $exists = $this->wishlistItemModel
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->first();

        // agrega el juego a la wishlist
        $this->wishlistItemModel->insert([
            'user_id' => $userId,
            'game_id' => $gameId,
            'added_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'success' => true
        ]);
    }

    public function remove_from_wishlist()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Petición inválida']);
        }

        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'No autenticado']);
        }

        $gameId = $this->request->getPost('game_id');
        if (!$gameId) {
            $json = $this->request->getJSON();
            $gameId = $json->game_id ?? null;
        }
        if (!$gameId) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'ID de juego no proporcionado']);
        }

        // verificamos si el juego está en la wishlist
        $exists = $this->wishlistItemModel
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->first();

        // elimina el juego de la wishlist
        $this->wishlistItemModel
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->delete();

        return $this->response->setJSON([
            'success' => true,
        ]);
    }

    public function historial_compras()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('alerta-msg', 'Primero debes iniciar sesión.');
        }

        $compras = $this->comprasModel->where('user_id', $userId)->orderBy('fecha', 'DESC')->findAll();

        $comprasData = [];
        foreach ($compras as $compra) {
            $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
            $items = [];
            $subtotal = 0;

            foreach ($detalles as $detalle) {
                $juego = $this->juegosModel->find($detalle['game_id']);
                if ($juego) {
                    $items[] = [
                        'image' => $juego['cover_image_url'] ?? $juego['card_image_url'] ?? '',
                        'title' => $juego['title'],
                        'price' => number_format($detalle['precio_unitario'], 2),
                    ];
                    $subtotal += floatval($detalle['precio_unitario']);
                }
            }

            $total = $compra['total'];

            $comprasData[] = [
                'order_id' => $compra['compra_id'],
                'purchase_date' => $compra['fecha'],
                'status' => strtoupper($compra['estado'] ?? 'COMPLETED'),
                'items' => $items,
                'subtotal' => $subtotal,
                'total' => $total,
            ];
        }

        return view('content/partials/compras-user-profile', [
            'compras' => $comprasData
        ]);
    }
}
