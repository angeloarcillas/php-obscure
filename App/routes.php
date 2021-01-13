<?php

$router->get('/','PagesController@index');
$router->get('/users', 'PagesController@users');

$router->post('/register', 'UserController@store');