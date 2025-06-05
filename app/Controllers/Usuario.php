<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ConsultaModel;
use CodeIgniter\Controller;

class Usuario extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function procesar_registro()
    {
        // validacion
        $validacion = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El email es obligatorio',
                    'valid_email' => 'Por favor ingrese un email válido',
                    'is_unique' => 'Este email ya está registrado'
                ]
            ],
            'usuario' => [
                'rules' => 'required|min_length[3]|is_unique[usuarios.nickname]',
                'errors' => [
                    'required' => 'El nombre de usuario es obligatorio',
                    'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres',
                    'is_unique' => 'Este nombre de usuario ya está en uso'
                ]
            ],
            'contraseña' => [
                'rules' => 'required|min_length[6]|regex_match[/(?=.*[A-Z])^.{6,}$/]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria',
                    'min_length' => 'La contraseña debe tener al menos 6 caracteres',
                    'regex_match' => 'La contraseña debe tener al menos una letra mayúscula'
                ]
            ],
            'confirmar_contraseña' => [
                'rules' => 'required|matches[contraseña]',
                'errors' => [
                    'required' => 'Debe confirmar la contraseña',
                    'matches' => 'Las contraseñas no coinciden'
                ]
            ]
        ]);

        if (!$validacion) {
            // Guardar los errores en flashdata
            session()->setFlashdata('validation', $this->validator);
            return redirect()->to(base_url('register'))->withInput();
        }

        // si la validación es exitosa, procesamos el registro
        $usuarioModel = new UsuarioModel();

        // preparamos los datos para guardar
        $datos = [
            'email' => $this->request->getPost('email'),
            'nickname' => $this->request->getPost('usuario'),
            'password_hash' => password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
            'is_active' => 1
        ];

        // guardamos el usuario en la base de datos
        $usuarioModel->insert($datos);

        // si la sesion es exitosa redirigimos al login con un mensaje
        session()->setFlashdata('mensaje', 'Registro exitoso. Ahora puedes iniciar sesión.');
        return redirect()->to(base_url('login'));
    }

    public function procesar_login()
    {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();
        $session = session();

        $validation->setRules([
            'usuario' => 'required',
            'contraseña' => 'required',
        ], [
            'usuario' => ['required' => 'Ingrese el nombre de usuario'],
            'contraseña' => ['required' => 'Ingrese la contraseña']
        ]);

        if (!$validation->withRequest($request)->run()) {
            $data['titulo'] = 'Login';
            $data['validation'] = $validation->getErrors();
            return view('login', $data);
        }

        $nickname = $this->request->getPost('usuario');
        $contraseña = $this->request->getPost('contraseña');

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('nickname', $nickname)->first();

        if (!$usuario) {
            return redirect()->to(base_url('login'))->with('mensaje', 'El usuario no existe.');
        }

        if ($usuario['is_active'] != 1) {
            return redirect()->to(base_url('login'))->with('mensaje', 'Tu cuenta está desactivada.');
        }

        if (!password_verify($contraseña, $usuario['password_hash'])) {
            return redirect()->to(base_url('login'))->with('mensaje', 'Usuario o contraseña incorrecta.');
        }

        // Autenticación exitosa
        $data = [
            'user_id' => $usuario['user_id'],
            'email' => $usuario['email'],
            'nickname' => $usuario['nickname'],
            'is_active' => $usuario['is_active'],
            'is_admin' => $usuario['is_admin'],
            'user_img' => $usuario['user_img'] // esto ayuda con lo anterior también
        ];

        $session->set($data);

        // Actualizar fecha de último login
        $usuarioModel->update($usuario['user_id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url($usuario['is_admin'] ? 'perfil' : '/'));
    }


    public function logout()
    {
        // destruimos la sesion
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }

    public function add_consulta()
    {

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules(
            [
                'nombre' => 'required|max_length[150]',
                'correo' => 'required|valid_email',
                'motivo' => 'required|max_length[100]',
                'consulta' => 'required|max_length[250]|min_length[10]',
            ],
            [   // errors
                'nombre' => [
                    'required' => 'El nombre es obligatorio',
                    'max_length' => 'El nombre debe tener como máximo 150 caracteres'
                ],

                'correo' => [
                    'required' => 'El correo electrónico es obligatorio',
                    'valid_email' => 'La dirección de correo debe ser válida'
                ],

                'motivo'   => [
                    "required"      => 'El motivo es obligatorio',
                    "max_length"    => 'El motivo de la consulta debe tener como máximo 100 caracteres'
                ],

                'consulta' => [
                    'required' => 'El texto de consulta es requerido',
                    'min_length' => 'La consulta debe tener como mínimo 10 caracteres',
                    'max_length' => 'La consulta debe tener como máximo 200 caracteres',
                ],
            ]
        );

        if ($validation->withRequest($request)->run()) {

            $data = [
                'nombre' => $request->getPost('nombre'),
                'mail' => $request->getPost('correo'),
                'asunto' => $request->getPost('motivo'),
                'consulta' => $request->getPost('consulta')
            ];

            $consulta = new ConsultaModel();
            $consulta->insert($data);

            return redirect()->route('contacto')->with('mensaje_consulta', 'Su consulta se envió exitosamente!');
        } else {

            $data['titulo'] = 'Error de Contacto';
            $data['validation'] = $validation->getErrors();
            return view('../Views/plantillas/header_view.php', $data) .
                view('../Views/plantillas/side_cart') .
                view('../Views/content/error_consulta.php') .
                view('../Views/plantillas/footer_view.php');
        }
    }
}
