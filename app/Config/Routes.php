<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Authentication Routes (keep existing)
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// *** STEP 6: ADD UNIFIED DASHBOARD ROUTE ***
$routes->get('dashboard', 'Auth::dashboard');

// Announcements route - redirects to dashboard for all users
$routes->get('announcements', 'Auth::dashboard');

// Admin routes (keep existing for backward compatibility)
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/courses', 'Admin::courses');

// Enrollment route
$routes->post('/course/enroll', 'Course::enroll');
// Course create route
$routes->post('/course/create', 'Course::create');

// Materials routes
$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/materials/upload/(:num)', 'Materials::upload/$1');
$routes->post('/materials/upload/(:num)', 'Materials::upload/$1');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');
$routes->get('/course/(:num)/materials', 'Materials::courseMaterials/$1');