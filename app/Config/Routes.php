<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

// Custom routes
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');


// Authentication routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

// Dashboard route (accessible to all authenticated users)
$routes->get('/dashboard', 'Auth::dashboard');

// Admin routes (admin only) - Protected by RoleAuth filter
$routes->group('admin', ['filter' => 'roleAuth'], function($routes) {
    $routes->get('manage-users', 'Admin::manageUsers');
    $routes->get('reports', 'Admin::reports');
    $routes->get('settings', 'Admin::settings');
    $routes->get('dashboard', 'Admin::dashboard');
});

// Teacher routes (teacher only) - Protected by RoleAuth filter
$routes->group('teacher', ['filter' => 'roleAuth'], function($routes) {
    $routes->get('classes', 'Teacher::classes');
    $routes->get('materials', 'Teacher::materials');
    $routes->get('grades', 'Teacher::grades');
    $routes->get('create-course', 'Teacher::createCourse');
    $routes->post('store-course', 'Teacher::storeCourse');
    $routes->get('get-courses', 'Teacher::getCourses');
    $routes->get('course/(:num)', 'Teacher::manageCourse/$1');
    $routes->get('dashboard', 'Teacher::dashboard');
});

// Student routes (student only) - Protected by RoleAuth filter
$routes->group('student', ['filter' => 'roleAuth'], function($routes) {
    $routes->get('dashboard', 'Student::dashboard');
    $routes->get('courses', 'Student::courses');
    $routes->get('grades', 'Student::grades');
    $routes->get('assignments', 'Student::assignments');
});

// Note: Role-based access control is handled by the RoleAuth filter
// applied to the route groups above

// Course enrollment routes
$routes->post('/course/enroll', 'Course::enroll');
$routes->post('/course/unenroll', 'Course::unenroll');
$routes->get('/course/enrolled', 'Course::getEnrolledCourses');
$routes->get('/course/available', 'Course::getAvailableCourses');

// Materials routes
$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');

// Announcements route (accessible to all authenticated users)
$routes->get('/announcements', 'Announcement::index');

// Notification routes 
$routes->get('/notifications', 'Notifications::get');
$routes->post('/notifications/mark_read/(:num)', 'Notifications::mark_as_read/$1');

// Dashboard routes are now handled within the protected route groups above
