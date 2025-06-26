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

$routes->post('/consulta', 'User_controllers\Usuario::add_consulta');

$routes->get('/terminos', 'Home::terminos');

$routes->get('/carrito', 'Cart_controllers\Cart::carrito');

$routes->get('/pago', 'Cart_controllers\Cart::pago');

$routes->get('/confirmacion', 'Cart_controllers\Cart::confirmacion');

$routes->post('cart/completarCompra', 'Cart_controllers\Cart::completarCompra');

$routes->get('/pago', 'Home::pago');

$routes->get('/confirmacion', 'Home::confirmacion');

$routes->get('/login', 'Home::login');

$routes->post('/procesar_login', 'User_controllers\Usuario::procesar_login');

$routes->get('/register', 'Home::register');

$routes->post('/procesar_registro', 'User_controllers\Usuario::procesar_registro');

$routes->get('/recuperar', 'Home::recuperar');

$routes->get('/nueva-pass', 'Home::new_pass');

$routes->post('/logout', 'User_controllers\Usuario::logout');

$routes->get('/user-profile', 'User_controllers\UserProfile::perfil');

$routes->get('/datos_usuario', 'User_controllers\UserProfile::datos_usuario');

$routes->post('user-profile/actualizar-datos', 'User_controllers\UserProfile::actualizar_datos');

$routes->post('usuario/procesar_nueva_contrasena', 'User_controllers\Usuario::procesar_nueva_contrasena');

$routes->post('user-profile/subir-foto', 'User_controllers\UserProfile::user_subir_foto');

$routes->post('/add-to-wishlist', 'User_controllers\UserProfile::add_to_wishlist');

$routes->post('/remove-from-wishlist', 'User_controllers\UserProfile::remove_from_wishlist');

$routes->post('cart/add', 'Cart_controllers\Cart::add');

$routes->post('cart/remove', 'Cart_controllers\Cart::remove');

$routes->post('cart/update', 'Cart_controllers\Cart::update');

$routes->post('cart/clear', 'Cart_controllers\Cart::clear');

$routes->post('/juego/(:num)/guardar-resena', 'Games_controllers\Juegos::guardarResena');

$routes->post('votar-util/(:num)', 'Games_controllers\Juegos::votarUtil/$1');

$routes->get('/juego/(:num)/filtrar-resenas', 'Games_controllers\Juegos::filtrarResenas/$1');

$routes->get('/admin-section', 'Admin_controllers\Admin::admin');

$routes->post('/admin-section/subir-foto', 'Admin_controllers\Admin::subir_foto');

$routes->get('/admin-section/admin-juegos', 'Admin_controllers\Admin::admin_juegos');

$routes->get('/admin-section/admin-usuarios', 'Admin_controllers\Admin::admin_usuarios');

$routes->post('/admin-section/banear-usuario/(:num)', 'Admin_controllers\Admin::banear_usuario/$1');

$routes->post('/admin-section/desbanear-usuario/(:num)', 'Admin_controllers\Admin::desbanear_usuario/$1');

$routes->get('/admin-section/admin-categorias', 'Admin_controllers\Admin::admin_categorias');

$routes->post('/admin-section/guardar-categoria', 'Admin_controllers\Admin::agregar_categoria');

$routes->post('/admin-section/eliminar-categoria/(:num)', 'Admin_controllers\Admin::eliminar_categoria/$1');

$routes->get('/admin-section/admin-ventas', 'Admin_controllers\Admin::admin_ventas');

$routes->post('/admin-section/guardar-juego', 'Admin_controllers\Admin::subir_juego');

$routes->post('/admin-section/aplicar_descuento_juego/(:num)', 'Admin_controllers\Admin::aplicar_descuento_juego/$1');

$routes->post('/admin-section/quitar_descuento_juego/(:num)', 'Admin_controllers\Admin::quitar_descuento_juego/$1');

$routes->get('admin-section/obtener-juego/(:num)', 'Admin_controllers\Admin::obtener_juego/$1');

$routes->post('admin-section/actualizar-juego/(:num)', 'Admin_controllers\Admin::actualizar_juego/$1');

$routes->post('admin-section/desactivar-juego/(:num)', 'Admin_controllers\Admin::desactivar_juego/$1');

$routes->post('admin-section/activar-juego/(:num)', 'Admin_controllers\Admin::activar_juego/$1');

$routes->get('(:segment)', 'Games_controllers\Juegos::categoria/$1');
