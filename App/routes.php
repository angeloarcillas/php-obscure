<?php
$router->get('/','PagesController@index');

$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
$router->get('/users/:int', 'UserController@edit');
$router->put('/users/:int', 'UserController@update');
$router->delete('/users/:int', 'UserController@delete');

$router->get('/404', fn() => view('error.404'));