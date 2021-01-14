<?php

$router->get('/','PagesController@index');
$router->get('/users', 'PagesController@users');
$router->post('/register', 'UserController@store');


$router->get('/int/:int/str/:str', fn ($a, $b) => dd($b));
$router->get('/foo/:int', fn ($a) => dd($a));
$router->get('/bar/:str', fn ($a) => dd($a));


$router->get('/404', fn() => view('error.404'));