<?php

$prefix = '/api';

/* Users */
// getters
$router->get($prefix.'/user', ['uses' => 'User\UserBrowseController@get', 'middleware' => ['LogActivity:User.View','ArrQuery']]);
$router->get($prefix.'/user/{query:.+}', ['uses' => 'User\UserBrowseController@get', 'middleware' => ['LogActivity:User.View','ArrQuery']]);
// actions
$router->post($prefix.'/user', ['uses' => 'User\UserController@Insert', 'middleware' => ['LogActivity:User.Insert','User.Insert']]);
$router->put($prefix.'/user/change_password', ['uses' => 'User\UserController@ChangePassword', 'middleware' => ['LogActivity:User.ChangePassword','User.ChangePassword']]);
$router->put($prefix.'/user/{id}', ['uses' => 'User\UserController@Update', 'middleware' => ['LogActivity:User.Update','User.Update']]);
$router->post($prefix.'/user/reset_password', ['uses' => 'User\UserController@ResetPassword', 'middleware' => ['LogActivity:User.ResetPassword','User.ResetPassword']]);
$router->post($prefix.'/user/change_status', ['uses' => 'User\UserController@ChangeStatus', 'middleware' => ['LogActivity:User.ChangeStatus','User.ChangeStatus']]);


$router->delete($prefix.'/user/{id}', ['uses' => 'User\UserController@Delete', 'middleware' => ['LogActivity:User.Delete','User.Delete']]);
// Developer
$router->post($prefix.'/user/{id}/developer/token', ['uses' => 'User\UserController@DeveloperToken', 'middleware' => ['User.Developer.Token']]);

/* Blast Position */
// getters
$router->get($prefix.'/position', ['uses' => 'Position\PositionBrowseController@get', 'middleware' => ['LogActivity:Position.View','ArrQuery']]);
$router->get($prefix.'/position/{query:.+}', ['uses' => 'Position\PositionBrowseController@get', 'middleware' => ['LogActivity:Position.View','ArrQuery']]);


// actions
$router->post($prefix.'/position', ['uses' => 'Position\PositionController@Insert', 'middleware' => ['LogActivity:Position.Insert','Position.Insert']]);
$router->put($prefix.'/position/{id}', ['uses' => 'Position\PositionController@Update', 'middleware' => ['LogActivity:Position.Update','Position.Update']]);
$router->delete($prefix.'/position/{id}', ['uses' => 'Position\PositionController@Delete', 'middleware' => ['LogActivity:Position.Delete','Position.Delete']]);
$router->post($prefix.'/position/change_status', ['uses' => 'Position\PositionController@ChangeStatus', 'middleware' => ['LogActivity:Position.ChangeStatus','Position.ChangeStatus']]);


$router->post($prefix.'/upload', ['uses' => 'File\FileController@Upload', 'middleware' => ['LogActivity:File.Upload','File.Upload']]);

$router->post($prefix.'/storage/save', ['uses' => 'Storage\StorageController@Save', 'middleware' => ['LogActivity:File.Save','Storage.Save']]);
$router->post($prefix.'/storage/save_excel', ['uses' => 'Storage\StorageController@SaveExcel', 'middleware' => ['LogActivity:File.SaveExcel','Storage.SaveExcel']]);

// mail
$router->get($prefix.'/log_activity', ['uses' => 'LogActivity\LogActivityBrowseController@get', 'middleware' => ['LogActivity:LogActivity.View', 'ArrQuery']]);
$router->get($prefix.'/log_activity/{query:.+}', ['uses' => 'LogActivity\LogActivityBrowseController@get', 'middleware' => ['LogActivity:LogActivity.View','ArrQuery']]);


// config
$router->get($prefix.'/config', ['uses' => 'Config\ConfigBrowseController@get', 'middleware' => ['LogActivity:Config.View','ArrQuery']]);
$router->get($prefix.'/config/{query:.+}', ['uses' => 'Config\ConfigBrowseController@get', 'middleware' => ['Config:Config.View','ArrQuery']]);
$router->post($prefix.'/config', ['uses' => 'Config\ConfigController@Insert', 'middleware' => ['LogActivity:Config.Insert','Config.Insert']]);
$router->put($prefix.'/config/{id}', ['uses' => 'Config\ConfigController@Update', 'middleware' => ['LogActivity:Config.Update','Config.Update']]);
$router->delete($prefix.'/config/{id}', ['uses' => 'Config\ConfigController@Delete', 'middleware' => ['LogActivity:Config.Delete','Config.Delete']]);

// golongan
$router->get($prefix.'/golongan', ['uses' => 'Golongan\GolonganBrowseController@get', 'middleware' => ['LogActivity:Golongan.View','ArrQuery']]);
$router->get($prefix.'/golongan/{query:.+}', ['uses' => 'Golongan\GolonganBrowseController@get', 'middleware' => ['Golongan:Golongan.View','ArrQuery']]);
$router->post($prefix.'/golongan', ['uses' => 'Golongan\GolonganController@Insert', 'middleware' => ['LogActivity:Golongan.Insert','Golongan.Insert']]);
$router->put($prefix.'/golongan/{id}', ['uses' => 'Golongan\GolonganController@Update', 'middleware' => ['LogActivity:Golongan.Update','Golongan.Update']]);
$router->delete($prefix.'/golongan/{id}', ['uses' => 'Golongan\GolonganController@Delete', 'middleware' => ['LogActivity:Golongan.Delete','Golongan.Delete']]);

// unit_kerja
$router->get($prefix.'/unit_kerja', ['uses' => 'UnitKerja\UnitKerjaBrowseController@get', 'middleware' => ['LogActivity:UnitKerja.View','ArrQuery']]);
$router->get($prefix.'/unit_kerja/{query:.+}', ['uses' => 'UnitKerja\UnitKerjaBrowseController@get', 'middleware' => ['UnitKerja:UnitKerja.View','ArrQuery']]);
$router->post($prefix.'/unit_kerja', ['uses' => 'UnitKerja\UnitKerjaController@Insert', 'middleware' => ['LogActivity:UnitKerja.Insert','UnitKerja.Insert']]);
$router->put($prefix.'/unit_kerja/{id}', ['uses' => 'UnitKerja\UnitKerjaController@Update', 'middleware' => ['LogActivity:UnitKerja.Update','UnitKerja.Update']]);
$router->delete($prefix.'/unit_kerja/{id}', ['uses' => 'UnitKerja\UnitKerjaController@Delete', 'middleware' => ['LogActivity:UnitKerja.Delete','UnitKerja.Delete']]);

// indikator_kinerja
$router->get($prefix.'/indikator_kinerja', ['uses' => 'IndikatorKinerja\IndikatorKinerjaBrowseController@get', 'middleware' => ['LogActivity:IndikatorKinerja.View','ArrQuery']]);
$router->get($prefix.'/indikator_kinerja/{query:.+}', ['uses' => 'IndikatorKinerja\IndikatorKinerjaBrowseController@get', 'middleware' => ['IndikatorKinerja:IndikatorKinerja.View','ArrQuery']]);
$router->post($prefix.'/indikator_kinerja', ['uses' => 'IndikatorKinerja\IndikatorKinerjaController@Insert', 'middleware' => ['LogActivity:IndikatorKinerja.Insert','IndikatorKinerja.Insert']]);
$router->put($prefix.'/indikator_kinerja/{id}', ['uses' => 'IndikatorKinerja\IndikatorKinerjaController@Update', 'middleware' => ['LogActivity:IndikatorKinerja.Update','IndikatorKinerja.Update']]);
$router->delete($prefix.'/indikator_kinerja/{id}', ['uses' => 'IndikatorKinerja\IndikatorKinerjaController@Delete', 'middleware' => ['LogActivity:IndikatorKinerja.Delete','IndikatorKinerja.Delete']]);


$router->post($prefix.'/user', ['uses' => 'User\UserController@Insert', 'middleware' => ['LogActivity:User.Insert','User.Insert']]);
$router->put($prefix.'/user/change_password', ['uses' => 'User\UserController@ChangePassword', 'middleware' => ['LogActivity:User.ChangePassword','User.ChangePassword']]);
$router->put($prefix.'/user/{id}', ['uses' => 'User\UserController@Update', 'middleware' => ['LogActivity:User.Update','User.Update']]);
