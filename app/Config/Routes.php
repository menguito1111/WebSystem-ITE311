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

// Admin routes (keep existing for backward compatibility)
$routes->get('admin/dashboard', 'Admin::dashboard');

// Enrollment route
$routes->post('/course/enroll', 'Course::enroll');
// Course create route
$routes->post('/course/create', 'Course::create');