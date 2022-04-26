<?php

$prefix = '/api.v1';

$router->get($prefix.'/', function () use ($router) {
    Json::set('message', 'BEP BEP WELCOME TO API RSPON');
    return response()->json(Json::get(), 200);
});

$router->get($prefix.'/user', ['uses' => 'User\UserV1BrowseController@get', 'middleware' => ['LogActivity:User.View','ArrQuery']]);
$router->get($prefix.'/user/{query:.+}', ['uses' => 'User\UserV1BrowseController@get', 'middleware' => ['LogActivity:User.View','ArrQuery']]);
