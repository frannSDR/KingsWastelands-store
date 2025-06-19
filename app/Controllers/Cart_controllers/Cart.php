<?php

namespace App\Controllers\Cart_controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\JuegosModel;

class Cart extends BaseController
{
    protected $cartModel;
    protected $cartItemModel;
    protected $juegosModel;

    public function __construct()
    {
        $this->juegosModel = new JuegosModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    // Mostrar el carrito del usuario actual
    public function index()
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

        return view('Views/plantillas/header_view')
            . view('Views/content/cart', ['cart' => $cart, 'items' => $items])
            . view('Views/plantillas/footer_view');
    }

    // Agregar un juego al carrito
    public function add()
    {
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

        $cart = $this->cartModel->where('user_id', $userId)->first();
        if (!$cart) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Carrito no encontrado']);
        }

        $item = $this->cartItemModel
            ->where('cart_id', $cart['cart_id'])
            ->where('game_id', $gameId)
            ->first();

        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Item no encontrado']);
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
            return $this->response->setStatusCode(401)->setJSON(['error' => 'No autenticado']);
        }

        $cart = $this->cartModel->where('user_id', $userId)->first();
        if ($cart) {
            $this->cartItemModel->where('cart_id', $cart['cart_id'])->delete();
            $this->cartModel->update($cart['cart_id'], ['updated_at' => date('Y-m-d H:i:s')]);
        }

        return $this->response->setJSON([
            'success' => true
        ]);
    }
}
