<?php

/*
 * --------------------------------------------------------------------
 * CodeIgniter Front Controller
 * --------------------------------------------------------------------
 *
 * This is the front controller for the CodeIgniter application.
 * It loads the bootstrap file and starts the framework.
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 * --------------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 * --------------------------------------------------------------------
 */

require realpath(FCPATH . '../app/Config/Paths.php') ?: FCPATH . '../app/Config/Paths.php';

require realpath(FCPATH . '../system/Boot.php') ?: FCPATH . '../system/Boot.php';
