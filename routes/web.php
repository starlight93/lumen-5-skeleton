<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/mail', "MailController@send");

$router->group(['prefix'=>'v1','middleware' => 'auth'], function () use ($router) {
    $router->get('/', "CrudController@index");
    $router->get('/{table}', "CrudController@index");
    $router->post('/{table}', "CrudController@index");
    $router->get('/{table}/{id}', "CrudController@index");
    $router->put('/{table}/{id}', "CrudController@index");
    $router->patch('/{table}/{id}', "CrudController@index");
    $router->delete('/{table}/{id}', "CrudController@index");
});

$router->post('/login', "UserController@login");

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/logout', "UserController@logout");
});
