<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    // return $router->app->version();
});
$router->get('/mail', "MailController@send");

$router->get('/v1', "CrudController@index");
$router->get('/v1/{table}', "CrudController@index");
$router->post('/v1/{table}', "CrudController@index");
$router->get('/v1/{table}/{id}', "CrudController@index");
$router->put('/v1/{table}/{id}', "CrudController@index");
$router->patch('/v1/{table}/{id}', "CrudController@index");
$router->delete('/v1/{table}/{id}', "CrudController@index");



$router->post('/login', "UserController@login");
