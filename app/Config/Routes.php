<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/ofertas', 'Home::ofertas');

$routes->get('/populares', 'Home::populares');

$routes->get('/nosotros', 'Home::nosotros');

$routes->get('/accion', 'Home::accion');

$routes->get('/aventura', 'Home::aventura');

$routes->get('/terror', 'Home::terror');

$routes->get('/indie', 'Home::indie');

$routes->get('/estrategia', 'Home::estrategia');

$routes->get('/comercializacion', 'Home::comercializacion');

$routes->get('/contacto', 'Home::contacto');

$routes->get('/terminos', 'Home::terminos');

$routes->get('/game_section', 'Home::game_section');

$routes->get('/game_section2', 'Home::game_section2');

$routes->get('/cart', 'Home::cart');

$routes->get('/pago', 'Home::pago');

$routes->get('/confirmacion', 'Home::confirmacion');
