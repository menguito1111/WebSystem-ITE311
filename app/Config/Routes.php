<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Dashboard (shortcut)
$routes->get('dashboard', 'Home::dashboard');
$routes->get('home/dashboard', 'Home::dashboard');

// Auth
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::store');


