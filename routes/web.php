<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/mail', "MailController@send");

$router->group(['prefix'=>'v1','middleware' => ['auth']], function () use ($router) {

    $router->group(['middleware' => ['check_exist','check_role']], function () use ($router) {
        $router->get('/', "CrudController@index");
        
        $router->group(['middleware' => ['create_validation','merge_create']], function () use ($router) {
            $router->post('/{table}', "CrudController@index");
        });

        $router->group(['middleware' => ['update_validation','merge_update']], function () use ($router) {
            $router->put('/{table}/{id}', "CrudController@index");
            $router->patch('/{table}/{id}', "CrudController@index");
        });

        $router->group(['middleware' => ['delete_validation']], function () use ($router) {
            $router->delete('/{table}/{id}', "CrudController@index");
        });

        $router->group(['middleware' => ['read_validation']], function () use ($router) {
            $router->get('/{table}', "CrudController@index");
            $router->get('/{table}/{id}', "CrudController@index");
        });
    });
});

$router->post('/login', "UserController@login");
$router->post('/password-recovery', "UserController@passwordRecovery");
$router->post('/password-reset-check', "UserController@passwordResetCheck");
$router->post('/password-reset', "UserController@passwordReset");

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/logout', "UserController@logout");
});