<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JuegosModel;
use App\Models\CategoriaModel;
use App\Models\JuegoCategoriaModel;
use App\Models\GaleriaModel;
use App\Models\RequisitosModel;
use App\Models\ReviewModel;
use App\Models\UsuarioModel;

class UserProfile extends BaseController
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
}
