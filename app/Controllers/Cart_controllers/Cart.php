<?php

namespace App\Controllers\Cart_controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\JuegosModel;
use App\Models\ComprasModel;
use App\Models\DetalleCompraModel;
use App\Models\CategoriaModel;

class Cart extends BaseController
{
    protected $cartModel;
    protected $cartItemModel;
    protected $juegosModel;
    protected $compraModel;
    protected $detalleModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->compraModel = new ComprasModel();
        $this->detalleModel = new DetalleCompraModel();
        $this->categoriaModel = new CategoriaModel();
    }

    // Mostrar el carrito del usuario actual
    public function carrito()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $cart = $this->cartModel->where('user_id', $userId)->first();
        $items = [];
        if ($cart) {
            $cartItems = $this->cartItemModel->where('cart_id', $cart['cart_id'])->findAll();
            foreach ($cartItems as $item) {
                $juego = $this->juegosModel->find($item['game_id']);
                if ($juego) {
                    $item['juego'] = $juego;
                }
                $items[] = $item;
            }
        }

        $data = [
            'cart' => $cart,
            'items' => $items
        ];

        return view('Views/plantillas/header_view')
            . view('Views/content/cart', $data)
            . view('Views/plantillas/footer_view');
    }

    public function pago()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $cart = $this->cartModel->where('user_id', $userId)->first();
        $items = [];
        if ($cart) {
            $cartItems = $this->cartItemModel->where('cart_id', $cart['cart_id'])->findAll();
            foreach ($cartItems as $item) {
                $juego = $this->juegosModel->find($item['game_id']);
                if ($juego) {
                    $item['juego'] = $juego;
                }
                $items[] = $item;
            }
        }

        // Si el carrito está vacío, redirige de vuelta al carrito
        if (empty($items)) {
            // Puedes agregar un mensaje flash si quieres
            session()->setFlashdata('error-msg', 'Tu carrito está vacío.');
            return redirect()->to('carrito');
        }

        $data = [
            'cart' => $cart,
            'items' => $items
        ];

        return view('Views/plantillas/header_view')
            . view('Views/content/pago', $data)
            . view('Views/plantillas/footer_view');
    }

    public function confirmacion()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Traer la última compra del usuario
        $compra = $this->compraModel
            ->where('user_id', $userId)
            ->orderBy('compra_id', 'DESC')
            ->first();

        if (!$compra) {
            return redirect()->to('/cart')->with('error', 'No se encontró ninguna compra reciente.');
        }

        // Traer los detalles de la compra (juegos)
        $detalles = $this->detalleModel->where('compra_id', $compra['compra_id'])->findAll();
        $items = [];
        foreach ($detalles as $detalle) {
            $juego = $this->juegosModel->find($detalle['game_id']);
            if ($juego) {
                $detalle['juego'] = $juego;
            }
            $items[] = $detalle;
        }

        // juegos destacados
        $categoriaDestacado = $this->categoriaModel->where('slug', 'indie')->first();
        $juegosDestacados = [];
        if ($categoriaDestacado) {
            $juegosDestacados = $this->juegosModel
                ->join('juego_categorias', 'juegos.game_id = juego_categorias.game_id')
                ->where('juego_categorias.category_id', $categoriaDestacado['category_id'])
                ->findAll(8);
        }

        $data = [
            'juegosDestacados' => $juegosDestacados,
            'compra' => $compra,
            'items'  => $items
        ];

        return view('Views/plantillas/header_view')
            . view('Views/content/confirmacion', $data)
            . view('Views/plantillas/footer_view');
    }

    // Agregar un juego al carrito
    public function add()
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Debes inciar sesion para usar esta funcion']);
        }

        $gameId = $this->request->getPost('game_id');
        if (!$gameId) {
            $json = $this->request->getJSON();
            $gameId = $json->game_id ?? null;
        }
        if (!$gameId) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'ID de juego no proporcionado']);
        }

        $cart = $this->cartModel->where('user_id', $userId)->first();
        if (!$cart) {
            $cartId = $this->cartModel->insert([
                'user_id' => $userId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ], true);
        } else {
            $cartId = $cart['cart_id'];
            $this->cartModel->update($cartId, ['updated_at' => date('Y-m-d H:i:s')]);
        }

        // Verifica si el juego ya está en el carrito
        $item = $this->cartItemModel
            ->where('cart_id', $cartId)
            ->where('game_id', $gameId)
            ->first();

        if ($item) {
            // Ya existe, no hagas nada
            return $this->response->setJSON(['success' => true]);
        } else {
            // Si no existe, lo agrega
            $this->cartItemModel->insert([
                'cart_id' => $cartId,
                'game_id' => $gameId,
                'added_at' => date('Y-m-d H:i:s')
            ]);
            return $this->response->setJSON(['success' => true]);
        }
    }

    // Quitar un juego del carrito
    public function remove()
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Debes iniciar sesion para usar esta funcion']);
        }

        $gameId = $this->request->getPost('game_id');
        if (!$gameId) {
            $json = $this->request->getJSON();
            $gameId = $json->game_id ?? null;
        }
        if (!$gameId) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'ID de juego no proporcionado']);
        }

        $cart = $this->cartModel->where('user_id', $userId)->first();
        if (!$cart) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Carrito no encontrado']);
        }

        $item = $this->cartItemModel
            ->where('cart_id', $cart['cart_id'])
            ->where('game_id', $gameId)
            ->first();

        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Juego no encontrado']);
        }

        $this->cartItemModel->delete($item['item_id']);

        return $this->response->setJSON([
            'success' => true
        ]);
    }

    // Vaciar el carrito
    public function clear()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $cart = $this->cartModel->where('user_id', $userId)->first();
        if ($cart) {
            $this->cartItemModel->where('cart_id', $cart['cart_id'])->delete();
            $this->cartModel->update($cart['cart_id'], ['updated_at' => date('Y-m-d H:i:s')]);
        }

        // Redirige de vuelta al carrito
        return redirect()->to('carrito');
    }

    public function completarCompra()
    {
        helper(['form']);

        // 1. Validar datos del formulario
        $validation = \Config\Services::validation();
        $rules = [
            'email'           => 'required|valid_email',
            'nombre_completo' => 'required',
            'dni'             => 'required',
            'direccion'       => 'required',
            'ciudad'          => 'required',
            'provincia'       => 'required',
            'pais'            => 'required',
            'codigo_postal'   => 'required',
            'telefono'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // 2. Obtener datos del carrito
        $userId = session('user_id');
        $cart = $this->cartModel->where('user_id', $userId)->first();
        if (!$cart) {
            return redirect()->to('/cart')->with('error', 'Tu carrito está vacío.');
        }
        $cartItems = $this->cartItemModel->where('cart_id', $cart['cart_id'])->findAll();
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Tu carrito está vacío.');
        }

        // 3. Calcular el total
        $total = 0;
        $itemsData = [];
        foreach ($cartItems as $item) {
            $juego = $this->juegosModel->find($item['game_id']);
            if (!$juego) continue;
            $precio = $juego['special_price'] ?? $juego['price'];
            $total += $precio;
            $itemsData[] = [
                'game_id'        => $item['game_id'],
                'precio_unitario' => $precio,
            ];
        }

        // 4. Guardar la compra
        $compraId = $this->compraModel->insert([
            'user_id'        => $userId,
            'fecha'          => date('Y-m-d H:i:s'),
            'total'          => $total,
            'email'          => $this->request->getPost('email'),
            'telefono'       => $this->request->getPost('telefono'),
            'nombre_completo' => $this->request->getPost('nombre_completo'),
            'dni'            => $this->request->getPost('dni'),
            'direccion'      => $this->request->getPost('direccion'),
            'ciudad'         => $this->request->getPost('ciudad'),
            'provincia'      => $this->request->getPost('provincia'),
            'pais'           => $this->request->getPost('pais'),
            'codigo_postal'  => $this->request->getPost('codigo_postal'),
            'metodo_pago'    => 'tarjeta_credito',
            'created_at'     => date('Y-m-d H:i:s'),
        ], true);

        // 5. Guardar los detalles de la compra
        foreach ($itemsData as $item) {
            $this->detalleModel->insert([
                'compra_id'      => $compraId,
                'game_id'        => $item['game_id'],
                'precio_unitario' => $item['precio_unitario'],
            ]);
        }

        // 6. Vaciar el carrito
        $this->cartItemModel->where('cart_id', $cart['cart_id'])->delete();

        // 7. Redirigir a la página de confirmación
        return redirect()->to('confirmacion');
    }
}
