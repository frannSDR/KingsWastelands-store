<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/ofertas', 'Juegos::ofertas');

$routes->get('/populares', 'Juegos::populares');

$routes->get('/juego/(:num)', 'Juegos::detalle/$1');

$routes->get('/nosotros', 'Home::nosotros');

$routes->get('/juegos', 'Juegos::all_games');

$routes->get('/comercializacion', 'Home::comercializacion');

$routes->get('/contacto', 'Home::contacto');

$routes->post('/consulta', 'Usuario::add_consulta');

$routes->get('/error_contacto', 'Home::error_contacto');

$routes->get('/terminos', 'Home::terminos');

$routes->get('/cart', 'Home::cart');

$routes->get('/wishlist', 'Home::wishlist');

$routes->get('/pago', 'Home::pago');

$routes->get('/confirmacion', 'Home::confirmacion');

$routes->get('/login', 'Home::login');

$routes->post('/procesar_login', 'Usuario::procesar_login');

$routes->get('/register', 'Home::register');

$routes->post('/procesar_registro', 'Usuario::procesar_registro');

$routes->get('/recuperar', 'Home::recuperar');

$routes->get('/nueva-pass', 'Home::new_pass');

$routes->post('/logout', 'Usuario::logout');

$routes->get('/datos_usuario', 'UserProfile::datos_usuario');

$routes->post('/perfil/actualizar-datos', 'UserProfile::actualizar_datos');

$routes->post('/juego/(:num)/guardar-resena', 'Juegos::guardarResena');

$routes->post('votar-util/(:num)', 'Juegos::votarUtil/$1');

$routes->get('/juego/(:num)/filtrar-resenas', 'Juegos::filtrarResenas/$1');

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

$routes->get('perfil/obtener-juego/(:num)', 'Admin_controllers\Admin::obtener_juego/$1');

$routes->post('perfil/actualizar-juego/(:num)', 'Admin_controllers\Admin::actualizar_juego/$1');

$routes->post('perfil/desactivar-juego/(:num)', 'Admin_controllers\Admin::desactivar_juego/$1');

$routes->post('perfil/activar-juego/(:num)', 'Admin_controllers\Admin::activar_juego/$1');

$routes->get('(:segment)', 'Juegos::categoria/$1');
