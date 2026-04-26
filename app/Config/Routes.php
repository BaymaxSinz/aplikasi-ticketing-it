<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login/process', 'Auth::process');
$routes->get('logout', 'Auth::logout');


$routes->get('dashboard', 'dashboard::index');

$routes->get('categories', 'Category::index');
$routes->post('categories/save', 'Category::save');
$routes->get('categories/delete/(:num)', 'Category::delete/$1');

$routes->get('tickets', 'Ticket::index');
$routes->get('tickets/create', 'Ticket::create');
$routes->post('tickets/store', 'Ticket::store');
$routes->get('tickets/edit/(:num)', 'Ticket::edit/$1');
$routes->post('tickets/update', 'Ticket::update');
$routes->get('tickets/delete/(:num)', 'Ticket::delete/$1');

$routes->get('tickets/detail/(:num)', 'Ticket::detail/$1');
$routes->get('tickets/take/(:num)', 'Ticket::take/$1');
$routes->post('tickets/update-status', 'Ticket::updateStatus');

$routes->get('tickets/export', 'Ticket::export');

$routes->get('users', 'User::index');
$routes->post('users/save', 'User::save');
$routes->get('users/delete/(:num)', 'User::delete/$1');

$routes->post('tickets/assign', 'Ticket::assign');



