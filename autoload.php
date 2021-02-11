<?php

/**
 * ! Autoloading classes for NAMESPACE only
 */
spl_autoload_register(function ($class) {
    // use OS directory separator
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);

    // set absolute path
    $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . "{$class}.php";

    // include file
    return file_exists($path) ? require_once $path : false;
});
