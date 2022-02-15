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

$router->put($prefix.'/user_request/check_exist', ['uses' => 'UserRequest\UserRequestController@CheckExist', 'middleware' => ['LogActivity:UserRequest.Update','UserRequest.CheckExist']]);
$router->post($prefix.'/user_request/request_approval', ['uses' => 'UserRequest\UserRequestController@RequestApproval', 'middleware' => ['LogActivity:UserRequest.RequestApproval','UserRequest.RequestApproval']]);
$router->post($prefix.'/user_request/approve', ['uses' => 'UserRequest\UserRequestController@Approve', 'middleware' => ['LogActivity:UserRequest.Approve','UserRequest.Approve']]);
$router->get($prefix.'/user_request', ['uses' => 'UserRequest\UserRequestBrowseController@get', 'middleware' => ['LogActivity:UserRequest.View','ArrQuery']]);
$router->get($prefix.'/user_request/{query:.+}', ['uses' => 'UserRequest\UserRequestBrowseController@get', 'middleware' => ['LogActivity:UserRequest.View','ArrQuery']]);
$router->put($prefix.'/user_request/{id}', ['uses' => 'UserRequest\UserRequestController@Update', 'middleware' => ['LogActivity:UserRequest.Update','UserRequest.Update']]);

$router->delete($prefix.'/user/{id}', ['uses' => 'User\UserController@Delete', 'middleware' => ['LogActivity:User.Delete','User.Delete']]);
// Developer
$router->post($prefix.'/user/{id}/developer/token', ['uses' => 'User\UserController@DeveloperToken', 'middleware' => ['User.Developer.Token']]);

// getters
$router->get($prefix.'/position', ['uses' => 'Position\PositionBrowseController@get', 'middleware' => ['LogActivity:Position.View','ArrQuery']]);
$router->get($prefix.'/position/{query:.+}', ['uses' => 'Position\PositionBrowseController@get', 'middleware' => ['LogActivity:Position.View','ArrQuery']]);

// actions
$router->post($prefix.'/position', ['uses' => 'Position\PositionController@Insert', 'middleware' => ['LogActivity:Position.Insert','Position.Insert']]);
$router->put($prefix.'/position/{id}', ['uses' => 'Position\PositionController@Update', 'middleware' => ['LogActivity:Position.Update','Position.Update']]);
$router->delete($prefix.'/position/{id}', ['uses' => 'Position\PositionController@Delete', 'middleware' => ['LogActivity:Position.Delete','Position.Delete']]);
$router->post($prefix.'/position/change_status', ['uses' => 'Position\PositionController@ChangeStatus', 'middleware' => ['LogActivity:Position.ChangeStatus','Position.ChangeStatus']]);

// jabatan
$router->get($prefix.'/jabatan', ['uses' => 'Jabatan\JabatanBrowseController@get', 'middleware' => ['LogActivity:Jabatan.View','ArrQuery']]);
$router->get($prefix.'/jabatan/{query:.+}', ['uses' => 'Jabatan\JabatanBrowseController@get', 'middleware' => ['LogActivity:Jabatan.View','ArrQuery']]);
$router->post($prefix.'/jabatan', ['uses' => 'Jabatan\JabatanController@Insert', 'middleware' => ['LogActivity:Jabatan.Insert','Jabatan.Insert']]);
$router->put($prefix.'/jabatan/{id}', ['uses' => 'Jabatan\JabatanController@Update', 'middleware' => ['LogActivity:Jabatan.Update','Jabatan.Update']]);
$router->delete($prefix.'/jabatan/{id}', ['uses' => 'Jabatan\JabatanController@Delete', 'middleware' => ['LogActivity:Jabatan.Delete','Jabatan.Delete']]);

// unit kerja
$router->get($prefix.'/unit_kerja', ['uses' => 'UnitKerja\UnitKerjaBrowseController@get', 'middleware' => ['LogActivity:UnitKerja.View','ArrQuery']]);
$router->get($prefix.'/unit_kerja/{query:.+}', ['uses' => 'UnitKerja\UnitKerjaBrowseController@get', 'middleware' => ['LogActivity:UnitKerja.View','ArrQuery']]);
$router->post($prefix.'/unit_kerja', ['uses' => 'UnitKerja\UnitKerjaController@Insert', 'middleware' => ['LogActivity:UnitKerja.Insert','UnitKerja.Insert']]);
$router->put($prefix.'/unit_kerja/{id}', ['uses' => 'UnitKerja\UnitKerjaController@Update', 'middleware' => ['LogActivity:UnitKerja.Update','UnitKerja.Update']]);
$router->delete($prefix.'/unit_kerja/{id}', ['uses' => 'UnitKerja\UnitKerjaController@Delete', 'middleware' => ['LogActivity:UnitKerja.Delete','UnitKerja.Delete']]);


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

// perilaku_kerja
$router->get($prefix.'/indikator_tetap', ['uses' => 'IndikatorTetap\IndikatorTetapBrowseController@get', 'middleware' => ['LogActivity:IndikatorTetap.View','ArrQuery']]);
$router->get($prefix.'/indikator_tetap/{query:.+}', ['uses' => 'IndikatorTetap\IndikatorTetapBrowseController@get', 'middleware' => ['IndikatorTetap:IndikatorTetap.View','ArrQuery']]);
$router->post($prefix.'/indikator_tetap', ['uses' => 'IndikatorTetap\IndikatorTetapController@Insert', 'middleware' => ['LogActivity:IndikatorTetap.Insert','IndikatorTetap.Insert']]);
$router->put($prefix.'/indikator_tetap/{id}', ['uses' => 'IndikatorTetap\IndikatorTetapController@Update', 'middleware' => ['LogActivity:IndikatorTetap.Update','IndikatorTetap.Update']]);
$router->delete($prefix.'/indikator_tetap/{id}', ['uses' => 'IndikatorTetap\IndikatorTetapController@Delete', 'middleware' => ['LogActivity:IndikatorTetap.Delete','IndikatorTetap.Delete']]);


// user_pendidikan
$router->get($prefix.'/user_pendidikan', ['uses' => 'UserPendidikan\UserPendidikanBrowseController@get', 'middleware' => ['LogActivity:UserPendidikan.View','ArrQuery']]);
$router->get($prefix.'/user_pendidikan/{query:.+}', ['uses' => 'UserPendidikan\UserPendidikanBrowseController@get', 'middleware' => ['UserPendidikan:UserPendidikan.View','ArrQuery']]);
$router->post($prefix.'/user_pendidikan', ['uses' => 'UserPendidikan\UserPendidikanController@Insert', 'middleware' => ['LogActivity:UserPendidikan.Insert','UserPendidikan.Insert']]);
$router->put($prefix.'/user_pendidikan/{id}', ['uses' => 'UserPendidikan\UserPendidikanController@Update', 'middleware' => ['LogActivity:UserPendidikan.Update','UserPendidikan.Update']]);
$router->delete($prefix.'/user_pendidikan/{id}', ['uses' => 'UserPendidikan\UserPendidikanController@Delete', 'middleware' => ['LogActivity:UserPendidikan.Delete','UserPendidikan.Delete']]);

// user_pendidikan_request
$router->get($prefix.'/user_pendidikan_request', ['uses' => 'UserPendidikanRequest\UserPendidikanRequestBrowseController@get', 'middleware' => ['LogActivity:UserPendidikanRequest.View','ArrQuery']]);
$router->get($prefix.'/user_pendidikan_request/{query:.+}', ['uses' => 'UserPendidikanRequest\UserPendidikanRequestBrowseController@get', 'middleware' => ['UserPendidikanRequest:UserPendidikanRequest.View','ArrQuery']]);
$router->post($prefix.'/user_pendidikan_request', ['uses' => 'UserPendidikanRequest\UserPendidikanRequestController@Insert', 'middleware' => ['LogActivity:UserPendidikanRequest.Insert','UserPendidikanRequest.Insert']]);
$router->put($prefix.'/user_pendidikan_request/{id}', ['uses' => 'UserPendidikanRequest\UserPendidikanRequestController@Update', 'middleware' => ['LogActivity:UserPendidikanRequest.Update','UserPendidikanRequest.Update']]);
$router->delete($prefix.'/user_pendidikan_request/{id}', ['uses' => 'UserPendidikanRequest\UserPendidikanRequestController@Delete', 'middleware' => ['LogActivity:UserPendidikanRequest.Delete','UserPendidikanRequest.Delete']]);

// user_jabatan_fungsional
$router->get($prefix.'/user_jabatan_fungsional', ['uses' => 'UserJabatanFungsional\UserJabatanFungsionalBrowseController@get', 'middleware' => ['LogActivity:UserJabatanFungsional.View','ArrQuery']]);
$router->get($prefix.'/user_jabatan_fungsional/{query:.+}', ['uses' => 'UserJabatanFungsional\UserJabatanFungsionalBrowseController@get', 'middleware' => ['UserJabatanFungsional:UserJabatanFungsional.View','ArrQuery']]);
$router->post($prefix.'/user_jabatan_fungsional', ['uses' => 'UserJabatanFungsional\UserJabatanFungsionalController@Insert', 'middleware' => ['LogActivity:UserJabatanFungsional.Insert','UserJabatanFungsional.Insert']]);
$router->put($prefix.'/user_jabatan_fungsional/{id}', ['uses' => 'UserJabatanFungsional\UserJabatanFungsionalController@Update', 'middleware' => ['LogActivity:UserJabatanFungsional.Update','UserJabatanFungsional.Update']]);
$router->delete($prefix.'/user_jabatan_fungsional/{id}', ['uses' => 'UserJabatanFungsional\UserJabatanFungsionalController@Delete', 'middleware' => ['LogActivity:UserJabatanFungsional.Delete','UserJabatanFungsional.Delete']]);

// user_jabatan_fungsional_request
$router->get($prefix.'/user_jabatan_fungsional_request', ['uses' => 'UserJabatanFungsionalRequest\UserJabatanFungsionalRequestBrowseController@get', 'middleware' => ['LogActivity:UserJabatanFungsionalRequest.View','ArrQuery']]);
$router->get($prefix.'/user_jabatan_fungsional_request/{query:.+}', ['uses' => 'UserJabatanFungsionalRequest\UserJabatanFungsionalRequestBrowseController@get', 'middleware' => ['UserJabatanFungsionalRequest:UserJabatanFungsionalRequest.View','ArrQuery']]);
$router->post($prefix.'/user_jabatan_fungsional_request', ['uses' => 'UserJabatanFungsionalRequest\UserJabatanFungsionalRequestController@Insert', 'middleware' => ['LogActivity:UserJabatanFungsionalRequest.Insert','UserJabatanFungsionalRequest.Insert']]);
$router->put($prefix.'/user_jabatan_fungsional_request/{id}', ['uses' => 'UserJabatanFungsionalRequest\UserJabatanFungsionalRequestController@Update', 'middleware' => ['LogActivity:UserJabatanFungsionalRequest.Update','UserJabatanFungsionalRequest.Update']]);
$router->delete($prefix.'/user_jabatan_fungsional_request/{id}', ['uses' => 'UserJabatanFungsionalRequest\UserJabatanFungsionalRequestController@Delete', 'middleware' => ['LogActivity:UserJabatanFungsionalRequest.Delete','UserJabatanFungsionalRequest.Delete']]);


// user_pelatihan
$router->get($prefix.'/user_pelatihan', ['uses' => 'UserPelatihan\UserPelatihanBrowseController@get', 'middleware' => ['LogActivity:UserPelatihan.View','ArrQuery']]);
$router->get($prefix.'/user_pelatihan/{query:.+}', ['uses' => 'UserPelatihan\UserPelatihanBrowseController@get', 'middleware' => ['UserPelatihan:UserPelatihan.View','ArrQuery']]);
$router->post($prefix.'/user_pelatihan', ['uses' => 'UserPelatihan\UserPelatihanController@Insert', 'middleware' => ['LogActivity:UserPelatihan.Insert','UserPelatihan.Insert']]);
$router->put($prefix.'/user_pelatihan/{id}', ['uses' => 'UserPelatihan\UserPelatihanController@Update', 'middleware' => ['LogActivity:UserPelatihan.Update','UserPelatihan.Update']]);
$router->delete($prefix.'/user_pelatihan/{id}', ['uses' => 'UserPelatihan\UserPelatihanController@Delete', 'middleware' => ['LogActivity:UserPelatihan.Delete','UserPelatihan.Delete']]);

// user_pelatihan_request
$router->get($prefix.'/user_pelatihan_request', ['uses' => 'UserPelatihanRequest\UserPelatihanRequestBrowseController@get', 'middleware' => ['LogActivity:UserPelatihanRequest.View','ArrQuery']]);
$router->get($prefix.'/user_pelatihan_request/{query:.+}', ['uses' => 'UserPelatihanRequest\UserPelatihanRequestBrowseController@get', 'middleware' => ['UserPelatihanRequest:UserPelatihanRequest.View','ArrQuery']]);
$router->post($prefix.'/user_pelatihan_request', ['uses' => 'UserPelatihanRequest\UserPelatihanRequestController@Insert', 'middleware' => ['LogActivity:UserPelatihanRequest.Insert','UserPelatihanRequest.Insert']]);
$router->put($prefix.'/user_pelatihan_request/{id}', ['uses' => 'UserPelatihanRequest\UserPelatihanRequestController@Update', 'middleware' => ['LogActivity:UserPelatihanRequest.Update','UserPelatihanRequest.Update']]);
$router->delete($prefix.'/user_pelatihan_request/{id}', ['uses' => 'UserPelatihanRequest\UserPelatihanRequestController@Delete', 'middleware' => ['LogActivity:UserPelatihanRequest.Delete','UserPelatihanRequest.Delete']]);

// user_keluarga
$router->get($prefix.'/user_keluarga', ['uses' => 'UserKeluarga\UserKeluargaBrowseController@get', 'middleware' => ['LogActivity:UserKeluarga.View','ArrQuery']]);
$router->get($prefix.'/user_keluarga/{query:.+}', ['uses' => 'UserKeluarga\UserKeluargaBrowseController@get', 'middleware' => ['UserKeluarga:UserKeluarga.View','ArrQuery']]);
$router->post($prefix.'/user_keluarga', ['uses' => 'UserKeluarga\UserKeluargaController@Insert', 'middleware' => ['LogActivity:UserKeluarga.Insert','UserKeluarga.Insert']]);
$router->put($prefix.'/user_keluarga/{id}', ['uses' => 'UserKeluarga\UserKeluargaController@Update', 'middleware' => ['LogActivity:UserKeluarga.Update','UserKeluarga.Update']]);
$router->delete($prefix.'/user_keluarga/{id}', ['uses' => 'UserKeluarga\UserKeluargaController@Delete', 'middleware' => ['LogActivity:UserKeluarga.Delete','UserKeluarga.Delete']]);

// user_keluarga_request
$router->get($prefix.'/user_keluarga_request', ['uses' => 'UserKeluargaRequest\UserKeluargaRequestBrowseController@get', 'middleware' => ['LogActivity:UserKeluargaRequest.View','ArrQuery']]);
$router->get($prefix.'/user_keluarga_request/{query:.+}', ['uses' => 'UserKeluargaRequest\UserKeluargaRequestBrowseController@get', 'middleware' => ['UserKeluargaRequest:UserKeluargaRequest.View','ArrQuery']]);
$router->post($prefix.'/user_keluarga_request', ['uses' => 'UserKeluargaRequest\UserKeluargaRequestController@Insert', 'middleware' => ['LogActivity:UserKeluargaRequest.Insert','UserKeluargaRequest.Insert']]);
$router->put($prefix.'/user_keluarga_request/{id}', ['uses' => 'UserKeluargaRequest\UserKeluargaRequestController@Update', 'middleware' => ['LogActivity:UserKeluargaRequest.Update','UserKeluargaRequest.Update']]);
$router->delete($prefix.'/user_keluarga_request/{id}', ['uses' => 'UserKeluargaRequest\UserKeluargaRequestController@Delete', 'middleware' => ['LogActivity:UserKeluargaRequest.Delete','UserKeluargaRequest.Delete']]);

// user_jabatan
$router->get($prefix.'/user_jabatan', ['uses' => 'UserJabatan\UserJabatanBrowseController@get', 'middleware' => ['LogActivity:UserJabatan.View','ArrQuery']]);
$router->get($prefix.'/user_jabatan/{query:.+}', ['uses' => 'UserJabatan\UserJabatanBrowseController@get', 'middleware' => ['UserJabatan:UserJabatan.View','ArrQuery']]);
$router->post($prefix.'/user_jabatan', ['uses' => 'UserJabatan\UserJabatanController@Insert', 'middleware' => ['LogActivity:UserJabatan.Insert','UserJabatan.Insert']]);
$router->put($prefix.'/user_jabatan/{id}', ['uses' => 'UserJabatan\UserJabatanController@Update', 'middleware' => ['LogActivity:UserJabatan.Update','UserJabatan.Update']]);
$router->delete($prefix.'/user_jabatan/{id}', ['uses' => 'UserJabatan\UserJabatanController@Delete', 'middleware' => ['LogActivity:UserJabatan.Delete','UserJabatan.Delete']]);

// user_jabatan_request
$router->get($prefix.'/user_jabatan_request', ['uses' => 'UserJabatanRequest\UserJabatanRequestBrowseController@get', 'middleware' => ['LogActivity:UserJabatanRequest.View','ArrQuery']]);
$router->get($prefix.'/user_jabatan_request/{query:.+}', ['uses' => 'UserJabatanRequest\UserJabatanRequestBrowseController@get', 'middleware' => ['UserJabatanRequest:UserJabatanRequest.View','ArrQuery']]);
$router->post($prefix.'/user_jabatan_request', ['uses' => 'UserJabatanRequest\UserJabatanRequestController@Insert', 'middleware' => ['LogActivity:UserJabatanRequest.Insert','UserJabatanRequest.Insert']]);
$router->put($prefix.'/user_jabatan_request/{id}', ['uses' => 'UserJabatanRequest\UserJabatanRequestController@Update', 'middleware' => ['LogActivity:UserJabatanRequest.Update','UserJabatanRequest.Update']]);
$router->delete($prefix.'/user_jabatan_request/{id}', ['uses' => 'UserJabatanRequest\UserJabatanRequestController@Delete', 'middleware' => ['LogActivity:UserJabatanRequest.Delete','UserJabatanRequest.Delete']]);

// user_golongan
$router->get($prefix.'/user_golongan', ['uses' => 'UserGolongan\UserGolonganBrowseController@get', 'middleware' => ['LogActivity:UserGolongan.View','ArrQuery']]);
$router->get($prefix.'/user_golongan/{query:.+}', ['uses' => 'UserGolongan\UserGolonganBrowseController@get', 'middleware' => ['UserGolongan:UserGolongan.View','ArrQuery']]);
$router->post($prefix.'/user_golongan', ['uses' => 'UserGolongan\UserGolonganController@Insert', 'middleware' => ['LogActivity:UserGolongan.Insert','UserGolongan.Insert']]);
$router->put($prefix.'/user_golongan/{id}', ['uses' => 'UserGolongan\UserGolonganController@Update', 'middleware' => ['LogActivity:UserGolongan.Update','UserGolongan.Update']]);
$router->delete($prefix.'/user_golongan/{id}', ['uses' => 'UserGolongan\UserGolonganController@Delete', 'middleware' => ['LogActivity:UserGolongan.Delete','UserGolongan.Delete']]);

// user_golongan_request
$router->get($prefix.'/user_golongan_request', ['uses' => 'UserGolonganRequest\UserGolonganRequestBrowseController@get', 'middleware' => ['LogActivity:UserGolonganRequest.View','ArrQuery']]);
$router->get($prefix.'/user_golongan_request/{query:.+}', ['uses' => 'UserGolonganRequest\UserGolonganRequestBrowseController@get', 'middleware' => ['UserGolonganRequest:UserGolonganRequest.View','ArrQuery']]);
$router->post($prefix.'/user_golongan_request', ['uses' => 'UserGolonganRequest\UserGolonganRequestController@Insert', 'middleware' => ['LogActivity:UserGolonganRequest.Insert','UserGolonganRequest.Insert']]);
$router->put($prefix.'/user_golongan_request/{id}', ['uses' => 'UserGolonganRequest\UserGolonganRequestController@Update', 'middleware' => ['LogActivity:UserGolonganRequest.Update','UserGolonganRequest.Update']]);
$router->delete($prefix.'/user_golongan_request/{id}', ['uses' => 'UserGolonganRequest\UserGolonganRequestController@Delete', 'middleware' => ['LogActivity:UserGolonganRequest.Delete','UserGolonganRequest.Delete']]);

// pendidikan
$router->get($prefix.'/pendidikan', ['uses' => 'Pendidikan\PendidikanBrowseController@get', 'middleware' => ['LogActivity:Pendidikan.View','ArrQuery']]);
$router->get($prefix.'/pendidikan/{query:.+}', ['uses' => 'Pendidikan\PendidikanBrowseController@get', 'middleware' => ['Pendidikan:Pendidikan.View','ArrQuery']]);
$router->post($prefix.'/pendidikan', ['uses' => 'Pendidikan\PendidikanController@Insert', 'middleware' => ['LogActivity:Pendidikan.Insert','Pendidikan.Insert']]);
$router->put($prefix.'/pendidikan/{id}', ['uses' => 'Pendidikan\PendidikanController@Update', 'middleware' => ['LogActivity:Pendidikan.Update','Pendidikan.Update']]);
$router->delete($prefix.'/pendidikan/{id}', ['uses' => 'Pendidikan\PendidikanController@Delete', 'middleware' => ['LogActivity:Pendidikan.Delete','Pendidikan.Delete']]);

// status_pegawai
$router->get($prefix.'/status_pegawai', ['uses' => 'StatusPegawai\StatusPegawaiBrowseController@get', 'middleware' => ['LogActivity:StatusPegawai.View','ArrQuery']]);
$router->get($prefix.'/status_pegawai/{query:.+}', ['uses' => 'StatusPegawai\StatusPegawaiBrowseController@get', 'middleware' => ['StatusPegawai:StatusPegawai.View','ArrQuery']]);
$router->post($prefix.'/status_pegawai', ['uses' => 'StatusPegawai\StatusPegawaiController@Insert', 'middleware' => ['LogActivity:StatusPegawai.Insert','StatusPegawai.Insert']]);
$router->put($prefix.'/status_pegawai/{id}', ['uses' => 'StatusPegawai\StatusPegawaiController@Update', 'middleware' => ['LogActivity:StatusPegawai.Update','StatusPegawai.Update']]);
$router->delete($prefix.'/status_pegawai/{id}', ['uses' => 'StatusPegawai\StatusPegawaiController@Delete', 'middleware' => ['LogActivity:StatusPegawai.Delete','StatusPegawai.Delete']]);

// document_unit
$router->get($prefix.'/document_unit', ['uses' => 'DocumentUnit\DocumentUnitBrowseController@get', 'middleware' => ['LogActivity:DocumentUnit.View','ArrQuery']]);
$router->get($prefix.'/document_unit/{query:.+}', ['uses' => 'DocumentUnit\DocumentUnitBrowseController@get', 'middleware' => ['DocumentUnit:DocumentUnit.View','ArrQuery']]);
$router->post($prefix.'/document_unit', ['uses' => 'DocumentUnit\DocumentUnitController@Insert', 'middleware' => ['LogActivity:DocumentUnit.Insert','DocumentUnit.Insert']]);
$router->put($prefix.'/document_unit/{id}', ['uses' => 'DocumentUnit\DocumentUnitController@Update', 'middleware' => ['LogActivity:DocumentUnit.Update','DocumentUnit.Update']]);
$router->delete($prefix.'/document_unit/{id}', ['uses' => 'DocumentUnit\DocumentUnitController@Delete', 'middleware' => ['LogActivity:DocumentUnit.Delete','DocumentUnit.Delete']]);


// jabatan_fungsional
$router->get($prefix.'/jabatan_fungsional', ['uses' => 'JabatanFungsional\JabatanFungsionalBrowseController@get', 'middleware' => ['LogActivity:JabatanFungsional.View','ArrQuery']]);
$router->get($prefix.'/jabatan_fungsional/{query:.+}', ['uses' => 'JabatanFungsional\JabatanFungsionalBrowseController@get', 'middleware' => ['JabatanFungsional:JabatanFungsional.View','ArrQuery']]);
$router->post($prefix.'/jabatan_fungsional', ['uses' => 'JabatanFungsional\JabatanFungsionalController@Insert', 'middleware' => ['LogActivity:JabatanFungsional.Insert','JabatanFungsional.Insert']]);
$router->put($prefix.'/jabatan_fungsional/{id}', ['uses' => 'JabatanFungsional\JabatanFungsionalController@Update', 'middleware' => ['LogActivity:JabatanFungsional.Update','JabatanFungsional.Update']]);
$router->delete($prefix.'/jabatan_fungsional/{id}', ['uses' => 'JabatanFungsional\JabatanFungsionalController@Delete', 'middleware' => ['LogActivity:JabatanFungsional.Delete','JabatanFungsional.Delete']]);

// penilaian_logbook
$router->get($prefix.'/penilaian_logbook', ['uses' => 'PenilaianLogbook\PenilaianLogbookBrowseController@get', 'middleware' => ['LogActivity:PenilaianLogbook.View','ArrQuery']]);
$router->get($prefix.'/penilaian_logbook/{query:.+}', ['uses' => 'PenilaianLogbook\PenilaianLogbookBrowseController@get', 'middleware' => ['PenilaianLogbook:PenilaianLogbook.View','ArrQuery']]);
$router->post($prefix.'/penilaian_logbook', ['uses' => 'PenilaianLogbook\PenilaianLogbookController@Insert', 'middleware' => ['LogActivity:PenilaianLogbook.Insert','PenilaianLogbook.Insert']]);
$router->put($prefix.'/penilaian_logbook', ['uses' => 'PenilaianLogbook\PenilaianLogbookController@Update', 'middleware' => ['LogActivity:PenilaianLogbook.Update','PenilaianLogbook.Update']]);
$router->delete($prefix.'/penilaian_logbook/{id}', ['uses' => 'PenilaianLogbook\PenilaianLogbookController@Delete', 'middleware' => ['LogActivity:PenilaianLogbook.Delete','PenilaianLogbook.Delete']]);

// pendidikan
$router->get($prefix.'/indikator_', ['uses' => 'IndikatorSkp\IndikatorSkpBrowseController@get', 'middleware' => ['LogActivity:IndikatorSkp.View','ArrQuery']]);
$router->get($prefix.'/indikator_/{query:.+}', ['uses' => 'IndikatorSkp\IndikatorSkpBrowseController@get', 'middleware' => ['IndikatorSkp:IndikatorSkp.View','ArrQuery']]);
$router->post($prefix.'/indikator_', ['uses' => 'IndikatorSkp\IndikatorSkpController@Insert', 'middleware' => ['LogActivity:IndikatorSkp.Insert','IndikatorSkp.Insert']]);
$router->put($prefix.'/indikator_/{id}', ['uses' => 'IndikatorSkp\IndikatorSkpController@Update', 'middleware' => ['LogActivity:IndikatorSkp.Update','IndikatorSkp.Update']]);
$router->delete($prefix.'/indikator_/{id}', ['uses' => 'IndikatorSkp\IndikatorSkpController@Delete', 'middleware' => ['LogActivity:IndikatorSkp.Delete','IndikatorSkp.Delete']]);

// penilaian_prestasi_kerja
$router->get($prefix.'/penilaian_prestasi_kerja', ['uses' => 'PenilaianPrestasiKerja\PenilaianPrestasiKerjaBrowseController@get', 'middleware' => ['LogActivity:PenilaianPrestasiKerja.View','ArrQuery']]);
$router->get($prefix.'/penilaian_prestasi_kerja/{query:.+}', ['uses' => 'PenilaianPrestasiKerja\PenilaianPrestasiKerjaBrowseController@get', 'middleware' => ['PenilaianPrestasiKerja:PenilaianPrestasiKerja.View','ArrQuery']]);
$router->post($prefix.'/penilaian_prestasi_kerja', ['uses' => 'PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Insert', 'middleware' => ['LogActivity:PenilaianPrestasiKerja.Insert','PenilaianPrestasiKerja.Insert']]);
$router->put($prefix.'/penilaian_prestasi_kerja/{id}', ['uses' => 'PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Update', 'middleware' => ['LogActivity:PenilaianPrestasiKerja.Update','PenilaianPrestasiKerja.Update']]);
$router->delete($prefix.'/penilaian_prestasi_kerja/{id}', ['uses' => 'PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Delete', 'middleware' => ['LogActivity:PenilaianPrestasiKerja.Delete','PenilaianPrestasiKerja.Delete']]);

// penilaian_perilaku_kerja
$router->get($prefix.'/penilaian_perilaku_kerja', ['uses' => 'PenilaianPerilakuKerja\PenilaianPerilakuKerjaBrowseController@get', 'middleware' => ['LogActivity:PenilaianPerilakuKerja.View','ArrQuery']]);
$router->get($prefix.'/penilaian_perilaku_kerja/{query:.+}', ['uses' => 'PenilaianPerilakuKerja\PenilaianPerilakuKerjaBrowseController@get', 'middleware' => ['PenilaianPerilakuKerja:PenilaianPerilakuKerja.View','ArrQuery']]);
$router->post($prefix.'/penilaian_perilaku_kerja', ['uses' => 'PenilaianPerilakuKerja\PenilaianPerilakuKerjaController@Insert', 'middleware' => ['LogActivity:PenilaianPerilakuKerja.Insert','PenilaianPerilakuKerja.Insert']]);
$router->put($prefix.'/penilaian_perilaku_kerja/{id}', ['uses' => 'PenilaianPerilakuKerja\PenilaianPerilakuKerjaController@Update', 'middleware' => ['LogActivity:PenilaianPerilakuKerja.Update','PenilaianPerilakuKerja.Update']]);
$router->delete($prefix.'/penilaian_perilaku_kerja/{id}', ['uses' => 'PenilaianPerilakuKerja\PenilaianPerilakuKerjaController@Delete', 'middleware' => ['LogActivity:PenilaianPerilakuKerja.Delete','PenilaianPerilakuKerja.Delete']]);


// penilaian_prestasi_kerja_item
$router->get($prefix.'/penilaian_prestasi_kerja_item', ['uses' => 'PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemBrowseController@get', 'middleware' => ['LogActivity:PenilaianPrestasiKerjaItem.View','ArrQuery']]);
$router->get($prefix.'/penilaian_prestasi_kerja_item/{query:.+}', ['uses' => 'PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemBrowseController@get', 'middleware' => ['PenilaianPrestasiKerjaItem:PenilaianPrestasiKerjaItem.View','ArrQuery']]);
$router->post($prefix.'/penilaian_prestasi_kerja_item', ['uses' => 'PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemController@Insert', 'middleware' => ['LogActivity:PenilaianPrestasiKerjaItem.Insert','PenilaianPrestasiKerjaItem.Insert']]);
$router->put($prefix.'/penilaian_prestasi_kerja_item/{id}', ['uses' => 'PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemController@Update', 'middleware' => ['LogActivity:PenilaianPrestasiKerjaItem.Update','PenilaianPrestasiKerjaItem.Update']]);
$router->delete($prefix.'/penilaian_prestasi_kerja_item/{id}', ['uses' => 'PenilaianPrestasiKerjaItem\PenilaianPrestasiKerjaItemController@Delete', 'middleware' => ['LogActivity:PenilaianPrestasiKerjaItem.Delete','PenilaianPrestasiKerjaItem.Delete']]);


// indikator_kinerja
$router->get($prefix.'/indikator_kinerja', ['uses' => 'IndikatorKinerja\IndikatorKinerjaBrowseController@get', 'middleware' => ['LogActivity:IndikatorKinerja.View','ArrQuery']]);
$router->get($prefix.'/indikator_kinerja/{query:.+}', ['uses' => 'IndikatorKinerja\IndikatorKinerjaBrowseController@get', 'middleware' => ['IndikatorKinerja:IndikatorKinerja.View','ArrQuery']]);
$router->post($prefix.'/indikator_kinerja', ['uses' => 'IndikatorKinerja\IndikatorKinerjaController@Insert', 'middleware' => ['LogActivity:IndikatorKinerja.Insert','IndikatorKinerja.Insert']]);
$router->put($prefix.'/indikator_kinerja/{id}', ['uses' => 'IndikatorKinerja\IndikatorKinerjaController@Update', 'middleware' => ['LogActivity:IndikatorKinerja.Update','IndikatorKinerja.Update']]);
$router->delete($prefix.'/indikator_kinerja/{id}', ['uses' => 'IndikatorKinerja\IndikatorKinerjaController@Delete', 'middleware' => ['LogActivity:IndikatorKinerja.Delete','IndikatorKinerja.Delete']]);

// indikator_skp
$router->get($prefix.'/indikator_skp', ['uses' => 'IndikatorSkp\IndikatorSkpBrowseController@get', 'middleware' => ['LogActivity:IndikatorSkp.View','ArrQuery']]);
$router->get($prefix.'/indikator_skp/{query:.+}', ['uses' => 'IndikatorSkp\IndikatorSkpBrowseController@get', 'middleware' => ['IndikatorSkp:IndikatorSkp.View','ArrQuery']]);
$router->post($prefix.'/indikator_skp', ['uses' => 'IndikatorSkp\IndikatorSkpController@Insert', 'middleware' => ['LogActivity:IndikatorSkp.Insert','IndikatorSkp.Insert']]);
$router->put($prefix.'/indikator_skp/{id}', ['uses' => 'IndikatorSkp\IndikatorSkpController@Update', 'middleware' => ['LogActivity:IndikatorSkp.Update','IndikatorSkp.Update']]);
$router->delete($prefix.'/indikator_skp/{id}', ['uses' => 'IndikatorSkp\IndikatorSkpController@Delete', 'middleware' => ['LogActivity:IndikatorSkp.Delete','IndikatorSkp.Delete']]);


$router->post($prefix.'/user', ['uses' => 'User\UserController@Insert', 'middleware' => ['LogActivity:User.Insert','User.Insert']]);
$router->put($prefix.'/user/change_password', ['uses' => 'User\UserController@ChangePassword', 'middleware' => ['LogActivity:User.ChangePassword','User.ChangePassword']]);
$router->put($prefix.'/user/{id}', ['uses' => 'User\UserController@Update', 'middleware' => ['LogActivity:User.Update','User.Update']]);
