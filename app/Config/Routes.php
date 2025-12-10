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
    	$routes->get('users', 'Admin::manageUsers');
        $routes->post('users/create', 'Admin::createUser');
        $routes->get('users/edit/(:num)', 'Admin::editUser/$1');
        $routes->post('users/update/(:num)', 'Admin::updateUser/$1');
        $routes->post('users/delete/(:num)', 'Admin::deleteUser/$1');
        $routes->post('users/change-status/(:num)', 'Admin::changeUserStatus/$1');
        $routes->post('users/change-role/(:num)', 'Admin::changeUserRole/$1');
    $routes->get('course-management', 'Admin::courseManagement');
    $routes->get('courses', 'Admin::courseManagement');
    $routes->get('manage-course/(:num)', 'Admin::manageCourse/$1');
    $routes->post('courses/create', 'Admin::createCourse');
    $routes->post('courses/update/(:num)', 'Admin::updateCourse/$1');
    $routes->post('courses/unenroll-student', 'Admin::unenrollStudent');
    $routes->get('reports', 'Admin::reports');
    $routes->get('settings', 'Admin::settings');
    $routes->get('dashboard', 'Admin::dashboard');
});

// Teacher routes (teacher only) - Protected by RoleAuth filter
$routes->group('teacher', ['filter' => 'roleAuth'], function($routes) {
    $routes->get('classes', 'Teacher::classes');
    $routes->get('materials', 'Teacher::materials');
    $routes->get('grades', 'Teacher::grades');
    $routes->get('course-enrollments/(:num)', 'Teacher::courseEnrollments/$1');
    $routes->get('create-course', 'Teacher::createCourse');
    $routes->post('store-course', 'Teacher::storeCourse');
    $routes->get('get-courses', 'Teacher::getCourses');
    $routes->get('course/(:num)', 'Teacher::manageCourse/$1');
    $routes->get('dashboard', 'Teacher::dashboard');

    // Assignment routes
    $routes->get('assignments', 'Teacher::assignments');
    $routes->get('assignments/(:num)', 'Teacher::assignments/$1');
    $routes->get('create-assignment', 'Teacher::createAssignment');
    $routes->get('create-assignment/(:num)', 'Teacher::createAssignment/$1');
    $routes->post('store-assignment', 'Teacher::storeAssignment');
    $routes->get('assignment-submissions/(:num)', 'Teacher::viewSubmissions/$1');
    $routes->post('grade-submission', 'Teacher::gradeSubmission');
    $routes->get('get-submission-details/(:num)', 'Teacher::getSubmissionDetails/$1');
});

// Student routes (student only) - Protected by RoleAuth filter
$routes->group('student', ['filter' => 'roleAuth'], function($routes) {
    $routes->get('dashboard', 'Student::dashboard');
    $routes->get('courses', 'Student::courses');
    $routes->get('grades', 'Student::grades');
    $routes->get('assignments', 'Student::assignments');

    // Assignment routes
    $routes->get('submit-assignment/(:num)', 'Student::submitAssignment/$1');
    $routes->post('store-submission', 'Student::storeSubmission');
    $routes->get('view-submission/(:num)', 'Student::viewSubmission/$1');
});

// Note: Role-based access control is handled by the RoleAuth filter
// applied to the route groups above

// Course enrollment routes
$routes->post('/course/enroll', 'Course::enroll');
$routes->post('/course/unenroll', 'Course::unenroll');
$routes->get('/course/enrolled', 'Course::getEnrolledCourses');
$routes->get('/course/available', 'Course::getAvailableCourses');

// Course search (GET for AJAX/search page and POST for form submissions)
$routes->get('/courses/search', 'Course::search');
$routes->post('/courses/search', 'Course::search');

// Materials routes
$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');

// Announcements routes
$routes->get('/announcements', 'Announcement::index');
$routes->get('/announcements/create', 'Announcement::create');
$routes->post('/announcements/store', 'Announcement::store');
$routes->get('/announcements/edit/(:num)', 'Announcement::edit/$1');
$routes->post('/announcements/update/(:num)', 'Announcement::update/$1');
$routes->post('/announcements/delete/(:num)', 'Announcement::delete/$1');
$routes->get('/announcements/search', 'Announcement::search');

// Notification routes 
$routes->get('/notifications', 'Notifications::get');
$routes->post('/notifications/mark_read/(:num)', 'Notifications::mark_as_read/$1');

// Dashboard routes are now handled within the protected route groups above
