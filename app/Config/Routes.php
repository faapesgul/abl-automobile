<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('v1', static function ($routes) {
    $routes->get('customers', 'Customers::index');
    $routes->get('automobiles', 'Automobile::index');

    $routes->post('orders', 'Orders::create');
    $routes->get('orders/(:num)', 'Orders::getOrderById/$1');
});
