<?php

declare(strict_types=1);

// Check if session started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use Core\Http\Request;
use Core\Http\Router;

// Load autoload & herlpers
require 'Core/helpers.php';
require 'autoload.php';

// Set configs
$config = require 'config.php';
define('CONFIG', $config);

/**
 * Init Router
 *
 * load() - set routes
 * direct() - match url then execute
 */
Router::load('App/routes.php')
    ->direct(Request::url(), Request::method());
