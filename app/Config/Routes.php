<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/ofertas', 'Juegos::ofertas');

$routes->get('/populares', 'Juegos::populares');

$routes->get('/juegos', 'Juegos::index');

$routes->get('/juego/(:num)', 'Juegos::detalle/$1');

$routes->get('/nosotros', 'Home::nosotros');

$routes->get('/accion', 'Juegos::accion');

$routes->get('/aventura', 'Juegos::aventuras');

$routes->get('/terror', 'Juegos::terror');

$routes->get('/indie', 'Juegos::indie');

$routes->get('/estrategia', 'Juegos::estrategia');

$routes->get('/comercializacion', 'Home::comercializacion');

$routes->get('/contacto', 'Home::contacto');

$routes->post('/consulta', 'Usuario::add_consulta');

$routes->get('/error_contacto', 'Home::error_contacto');

$routes->get('/terminos', 'Home::terminos');

$routes->get('/cart', 'Home::cart');

$routes->get('/pago', 'Home::pago');

$routes->get('/confirmacion', 'Home::confirmacion');

$routes->get('/login', 'Home::login');

$routes->post('/procesar_login', 'Usuario::procesar_login');

$routes->get('/register', 'Home::register');

$routes->post('/procesar_registro', 'Usuario::procesar_registro');

$routes->get('/recuperar', 'Home::recuperar');

$routes->get('/nueva-pass', 'Home::new_pass');

$routes->post('/logout', 'Usuario::logout');
