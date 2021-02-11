<?php
/**
 * ! Autoloading classes for NAMESPACE only
 */
spl_autoload_register(function ($class) {
    // $class = strtolower($class);
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $path = dirname(__FILE__) . DIRECTORY_SEPARATOR ."{$class}.php";
    // dd($path);
    if (file_exists($path)) {
        require  $path;
    }
});