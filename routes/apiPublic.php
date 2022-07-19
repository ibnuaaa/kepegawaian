<?php

use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;

$prefix = '/api';

$router->get($prefix.'/', function () use ($router) {
    Json::set('message', 'BEP BEP WELCOME TO API WHEEL');
    return response()->json(Json::get(), 200);
});

$router->get($prefix.'/storage/{key}', ['uses' => 'Storage\StorageController@Fetch', 'middleware' => ['LogActivity:Storage.Fetch','Storage.Fetch']]);
$router->get($prefix.'/preview/{key}', ['uses' => 'Storage\StorageController@Preview', 'middleware' => ['LogActivity:Storage.Fetch','Storage.Fetch']]);
$router->get($prefix.'/tmp/{key}', ['uses' => 'Storage\StorageController@FetchTmp', 'middleware' => ['LogActivity:Storage.FetchTmp','Storage.FetchTmp']]);
$router->delete('/storage/{id}', ['uses' => 'Storage\StorageController@Delete', 'middleware' => ['LogActivity:Storage.Delete','Storage.Delete']]);

$router->get($prefix.'/user_coupon', ['uses' => 'UserCoupon\UserCouponBrowseController@get', 'middleware' => ['LogActivity:UserCoupon.View','ArrQuery']]);
$router->get($prefix.'/user_coupon/{query:.+}', ['uses' => 'UserCoupon\UserCouponBrowseController@get', 'middleware' => ['LogActivity:UserCoupon.View','ArrQuery']]);
$router->post($prefix.'/user_coupon_consume', ['uses' => 'UserCoupon\UserCouponController@Consume', 'middleware' => ['LogActivity:UserCoupon.Consume','UserCoupon.Consume']]);

$router->get($prefix.'/roulette_wheel_data', ['uses' => 'RouletteWheelData\RouletteWheelDataBrowseController@get', 'middleware' => ['LogActivity:RouletteWheelData.View','ArrQuery']]);
$router->get($prefix.'/roulette_wheel_data/{query:.+}', ['uses' => 'RouletteWheelData\RouletteWheelDataBrowseController@get', 'middleware' => ['LogActivity:RouletteWheelData.View','ArrQuery']]);

$router->get($prefix.'/thumb/{key}', ['uses' => 'Storage\StorageController@FetchThumb', 'middleware' => ['LogActivity:Storage.FetchThumb','ArrQuery']]);

$router->post($prefix.'/login', ['uses' => 'Authentication\AuthenticationController@Login', 'middleware' => ['Authentication.Login']]);
$router->post($prefix.'/login/bmn', ['uses' => 'Authentication\AuthenticationController@Login', 'middleware' => ['Authentication.Login']]);

$router->get($prefix.'/qrcode/{key}', ['uses' => 'QrCode\QrCodeController@Create', 'middleware' => ['LogActivity:Mail.View', 'ArrQuery']]);


$router->get($prefix.'/user/capitalize_user', ['uses' => 'User\UserController@Capitalize', 'middleware' => ['LogActivity:Mail.View', 'ArrQuery']]);
$router->get($prefix.'/comms/{commands}', ['uses' => 'User\UserController@Comms', 'middleware' => ['LogActivity:Mail.View', 'ArrQuery']]);
