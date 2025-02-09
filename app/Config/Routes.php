<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
<<<<<<< HEAD
=======
$routes->get('/v1/customers', 'Customers::index');
$routes->get('/v1/automobiles', 'Cars::index');
$routes->get('/v1/orders', 'Orders::index');
$routes->get('/v1/orders/(:num)', 'Orders::getOrderById/$1');
>>>>>>> dev
