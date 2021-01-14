<?php
$router->get('/','PagesController@index');
$router->get('/users', 'PagesController@users');
$router->post('/register', 'UserController@store');
$router->get('/update', 'UserController@update');

$router->get('/404', fn() => view('error.404'));