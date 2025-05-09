<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Registro extends Controller
{
    public function index()
    {
        $request = service('request');

        if ($request->getMethod() === 'post') {
            $email = $request->getPost('email');
            $nombre = $request->getPost('nombre');
            $contraseña = $request->getPost('contraseña');
            $repetir = $request->getPost('repetir');

            // Validar que las contraseñas coincidan
            if ($contraseña !== $repetir) {
                return $this->response->setBody("Las contraseñas no coinciden.");
            }

            // Hashear la contraseña
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

            // Conectar a la base de datos
            $db = \Config\Database::connect();

            // Verificar si el email ya está registrado
            $query = $db->table('usuarios')->where('email', $email)->get();

            if ($query->getNumRows() > 0) {
                return $this->response->setBody("Este correo ya está registrado.");
            }

            // Insertar el nuevo usuario
            $data = [
                'nombre' => $nombre,
                'email' => $email,
                'contraseña' => $contraseña_hash,
            ];

            if ($db->table('usuarios')->insert($data)) {
                return $this->response->setBody("Registro exitoso. Ya puedes iniciar sesión.");
            } else {
                return $this->response->setBody("Error al registrar el usuario.");
            }
        }

        return $this->response->setBody("Método no permitido.");
    }
}
