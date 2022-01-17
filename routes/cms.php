<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a bre
eze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/logout', 'CMS\Authentication\AuthenticationController@Logout');

$router->get('/', 'CMS\Home\HomeController@Home');
$router->get('/coupon/new', 'CMS\Home\HomeController@NewCoupon');

$router->get('/position/paging', 'CMS\Position\PositionController@Home');
$router->get('/position', 'CMS\Position\PositionController@HomeWithPaging');
$router->get('/position/new', 'CMS\Position\PositionController@New');
$router->get('/position/{id}', 'CMS\Position\PositionController@PositionEdit');

$router->get('/golongan', 'CMS\Golongan\GolonganController@Home');
$router->get('/golongan/new', 'CMS\Golongan\GolonganController@New');
$router->get('/golongan/edit/{id}', 'CMS\Golongan\GolonganController@Edit');
$router->get('/golongan/{id}', 'CMS\Golongan\GolonganController@Detail');

$router->get('/unit_kerja', 'CMS\UnitKerja\UnitKerjaController@Home');
$router->get('/unit_kerja/new', 'CMS\UnitKerja\UnitKerjaController@New');
$router->get('/unit_kerja/edit/{id}', 'CMS\UnitKerja\UnitKerjaController@Edit');
$router->get('/unit_kerja/{id}', 'CMS\UnitKerja\UnitKerjaController@Detail');

$router->get('/pendidikan', 'CMS\Pendidikan\PendidikanController@Home');
$router->get('/pendidikan/new', 'CMS\Pendidikan\PendidikanController@New');
$router->get('/pendidikan/edit/{id}', 'CMS\Pendidikan\PendidikanController@Edit');
$router->get('/pendidikan/{id}', 'CMS\Pendidikan\PendidikanController@Detail');

$router->get('/indikator_kinerja', 'CMS\IndikatorKinerja\IndikatorKinerjaController@Home');
$router->get('/indikator_kinerja/new', 'CMS\IndikatorKinerja\IndikatorKinerjaController@New');
$router->get('/indikator_kinerja/edit/{id}', 'CMS\IndikatorKinerja\IndikatorKinerjaController@Edit');
$router->get('/indikator_kinerja/{id}', 'CMS\IndikatorKinerja\IndikatorKinerjaController@Detail');

$router->get('/user', 'CMS\User\UserController@Home');
$router->get('/user/new', 'CMS\User\UserController@New');
$router->get('/user/edit/{id}', 'CMS\User\UserController@Edit');
$router->get('/user/{id}', 'CMS\User\UserController@Detail');

$router->get('/profile', 'CMS\User\UserController@Profile');
$router->get('/profile/edit', 'CMS\User\UserController@ProfileEdit');
$router->get('/change_password', 'CMS\User\UserController@ChangePassword');

$router->get('/notifikasi', 'CMS\Notifikasi\NotifikasiController@Home');

$router->get('/audit_trail', 'CMS\AuditTrail\AuditTrailController@Home');
$router->get('/audit_trail/log_data/{id}', 'CMS\AuditTrail\AuditTrailController@LogData');
