<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JuegosModel;
use App\Models\CategoriaModel;
use App\Models\JuegoCategoriaModel;
use App\Models\UsuarioModel;
use App\Models\WishlistModel;
use App\Models\WishlistItemModel;

class UserProfile extends BaseController
{
    protected $juegosModel;
    protected $categoriaModel;
    protected $juegoCategoriaModel;
    protected $usuariosModel;
    protected $wishlistModel;
    protected $wishlistItemModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->categoriaModel = new CategoriaModel();
        $this->juegoCategoriaModel = new JuegoCategoriaModel();
        $this->usuariosModel = new UsuarioModel();
        $this->wishlistModel = new WishlistModel();
        $this->wishlistItemModel = new WishlistItemModel();
    }

    public function perfil()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error-msg', 'Primero debes estar logueado!');
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

        return view('plantillas/header_view')
            . view('plantillas/side_cart')
            . view('content/user_perfil', [
                'usuario' => $usuario,
                'deseados' => $deseados
            ])
            . view('plantillas/footer_view');
    }

    public function datos_usuario()
    {
        $userId = session('user_id');
        if (!$userId) {
            // Si no está logueado, redirige al login
            return redirect()->to(base_url('login'))->with('error-msg', 'Primero debes estar logueado!');
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
            . view('/plantillas/side_cart')
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
            'nickname' => 'required|min_length[3]|max_length[30]',
            'email'    => 'required|valid_email'
        ], [
            'nickname' => [
                'required' => 'El nombre de usuario es obligatorio',
                'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres',
                'max_length' => 'El nombre de usuario no puede superar los 30 caracteres'
            ],
            'email' => [
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
            return redirect()->to(base_url('login'))->with('error-msg', 'Primero debes iniciar sesión.');
        }

        // 1. Obtén los items de la wishlist del usuario
        $wishlistItems = $this->wishlistItemModel
            ->where('user_id', $userId)
            ->findAll();

        $deseados = [];

        // 2. Por cada item, obtén los datos del juego
        foreach ($wishlistItems as $item) {
            $juego = $this->juegosModel
                ->select('game_id, title, price, release_date, card_image_url')
                ->find($item['game_id']);
            if ($juego) {
                $deseados[] = $juego;
            }
        }

        // 3. Pasa los juegos a la vista
        return view('content/partials/wishlist-user-profile', [
            'deseados' => $deseados
        ]);
    }

    public function add_to_wishlist()
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

        // Verifica si el usuario ya tiene una wishlist, si no, la crea
        $wishlist = $this->wishlistModel->where('user_id', $userId)->first();
        if (!$wishlist) {
            $this->wishlistModel->insert([
                'user_id' => $userId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Actualiza la fecha de actualización
            $this->wishlistModel->update($wishlist['user_id'], [
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Verifica si el juego ya está en la wishlist
        $exists = $this->wishlistItemModel
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->first();

        if ($exists) {
            return $this->response->setStatusCode(409)->setJSON(['error' => 'Este juego ya está en tu lista de deseados.']);
        }

        // Agrega el juego a la wishlist
        $this->wishlistItemModel->insert([
            'user_id' => $userId,
            'game_id' => $gameId,
            'added_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Juego agregado a tu lista de deseados.'
        ]);
    }
}
