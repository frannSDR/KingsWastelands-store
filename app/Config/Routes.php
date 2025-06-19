<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/ofertas', 'Games_controllers\Juegos::ofertas');

$routes->get('/prox-lanzamientos', 'Games_controllers\Juegos::prox_lanzamientos');

$routes->get('/juego/(:num)', 'Games_controllers\Juegos::detalle/$1');

$routes->get('/nosotros', 'Home::nosotros');

$routes->get('/juegos', 'Games_controllers\Juegos::all_games');

$routes->get('/comercializacion', 'Home::comercializacion');

$routes->get('/contacto', 'Home::contacto');

$routes->post('/consulta', 'Usuario::add_consulta');

$routes->get('/error_contacto', 'Home::error_contacto');

$routes->get('/terminos', 'Home::terminos');

$routes->get('/carrito', 'Cart_controllers\Cart::index');

$routes->get('/pago', 'Home::pago');

$routes->get('/confirmacion', 'Home::confirmacion');

$routes->get('/login', 'Home::login');

$routes->post('/procesar_login', 'Usuario::procesar_login');

$routes->get('/register', 'Home::register');

$routes->post('/procesar_registro', 'Usuario::procesar_registro');

$routes->get('/recuperar', 'Home::recuperar');

$routes->get('/nueva-pass', 'Home::new_pass');

$routes->post('/logout', 'Usuario::logout');

$routes->get('/user-profile', 'User_controllers\UserProfile::perfil');

$routes->get('/datos_usuario', 'User_controllers\UserProfile::datos_usuario');

$routes->post('/perfil/actualizar-datos', 'User_controllers\UserProfile::actualizar_datos');

$routes->post('/add-to-wishlist', 'User_controllers\UserProfile::add_to_wishlist');

$routes->post('/remove-from-wishlist', 'User_controllers\UserProfile::remove_from_wishlist');

$routes->post('cart/add', 'Cart_controllers\Cart::add');

$routes->post('cart/remove', 'Cart_controllers\Cart::remove');

$routes->post('cart/update', 'Cart_controllers\Cart::update');

$routes->post('cart/clear', 'Cart_controllers\Cart::clear');

$routes->post('/juego/(:num)/guardar-resena', 'Games_controllers\Juegos::guardarResena');

$routes->post('votar-util/(:num)', 'Games_controllers\Juegos::votarUtil/$1');

$routes->get('/juego/(:num)/filtrar-resenas', 'Games_controllers\Juegos::filtrarResenas/$1');

$routes->get('/perfil', 'Admin_controllers\Admin::admin');

$routes->post('/perfil/subir-foto', 'Admin_controllers\Admin::subir_foto');

$routes->get('/perfil/admin-juegos', 'Admin_controllers\Admin::admin_juegos');

$routes->get('/perfil/admin-usuarios', 'Admin_controllers\Admin::admin_usuarios');

$routes->post('/perfil/banear-usuario/(:num)', 'Admin_controllers\Admin::banear_usuario/$1');

$routes->post('/perfil/desbanear-usuario/(:num)', 'Admin_controllers\Admin::desbanear_usuario/$1');

$routes->get('/perfil/admin-categorias', 'Admin_controllers\Admin::admin_categorias');

$routes->post('/perfil/guardar-categoria', 'Admin_controllers\Admin::agregar_categoria');

$routes->post('/perfil/eliminar-categoria/(:num)', 'Admin_controllers\Admin::eliminar_categoria/$1');

$routes->post('/perfil/guardar-juego', 'Admin_controllers\Admin::subir_juego');

$routes->post('/perfil/aplicar_descuento_juego/(:num)', 'Admin_controllers\Admin::aplicar_descuento_juego/$1');

$routes->post('/perfil/quitar_descuento_juego/(:num)', 'Admin_controllers\Admin::quitar_descuento_juego/$1');

$routes->get('perfil/obtener-juego/(:num)', 'Admin_controllers\Admin::obtener_juego/$1');

$routes->post('perfil/actualizar-juego/(:num)', 'Admin_controllers\Admin::actualizar_juego/$1');

$routes->post('perfil/desactivar-juego/(:num)', 'Admin_controllers\Admin::desactivar_juego/$1');

$routes->post('perfil/activar-juego/(:num)', 'Admin_controllers\Admin::activar_juego/$1');

$routes->get('(:segment)', 'Games_controllers\Juegos::categoria/$1');
