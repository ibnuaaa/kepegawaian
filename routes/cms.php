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

$router->get('/distributor', 'CMS\Distributor\DistributorController@Home');
$router->get('/distributor/new', 'CMS\Distributor\DistributorController@New');
$router->get('/distributor/edit/{id}', 'CMS\Distributor\DistributorController@Edit');
$router->get('/distributor/edit_harga/{id}', 'CMS\Distributor\DistributorController@EditHarga');
$router->get('/distributor/{id}', 'CMS\Distributor\DistributorController@Detail');

$router->get('/principal', 'CMS\Principal\PrincipalController@Home');
$router->get('/principal/new', 'CMS\Principal\PrincipalController@New');
$router->get('/principal/edit/{id}', 'CMS\Principal\PrincipalController@Edit');
$router->get('/principal/edit_harga/{id}', 'CMS\Principal\PrincipalController@EditHarga');
$router->get('/principal/{id}', 'CMS\Principal\PrincipalController@Detail');


$router->get('/ppk', 'CMS\Ppk\PpkController@Home');
$router->get('/ppk/new', 'CMS\Ppk\PpkController@New');
$router->get('/ppk/edit/{id}', 'CMS\Ppk\PpkController@Edit');
$router->get('/ppk/{id}', 'CMS\Ppk\PpkController@Detail');


$router->get('/material', 'CMS\Material\MaterialController@Home');
$router->get('/material/new', 'CMS\Material\MaterialController@New');
$router->get('/material/edit/{id}', 'CMS\Material\MaterialController@Edit');
$router->get('/material/{id}', 'CMS\Material\MaterialController@Detail');

$router->get('/material_request', 'CMS\MaterialRequest\MaterialRequestController@Home');
$router->get('/material_request/new', 'CMS\MaterialRequest\MaterialRequestController@New');
$router->get('/material_request/edit/{id}', 'CMS\MaterialRequest\MaterialRequestController@Edit');
$router->get('/material_request/{id}', 'CMS\MaterialRequest\MaterialRequestController@Detail');
$router->get('/material_request/edit_item/{id}', 'CMS\MaterialRequest\MaterialRequestController@EditItem');
$router->get('/material_request/cetak_request/{id}', 'CMS\MaterialRequest\MaterialRequestController@CetakRequest');
$router->get('/material_request/cetak_po/{id}', 'CMS\MaterialRequest\MaterialRequestController@CetakPO');

$router->get('/approval_anggaran', 'CMS\ApprovalAnggaran\ApprovalAnggaranController@Home');
$router->get('/approval_anggaran/{id}', 'CMS\ApprovalAnggaran\ApprovalAnggaranController@Detail');

$router->get('/purchase_order', 'CMS\PurchaseOrder\PurchaseOrderController@Home');
$router->get('/purchase_order/new', 'CMS\PurchaseOrder\PurchaseOrderController@New');
$router->get('/purchase_order/edit/{id}', 'CMS\PurchaseOrder\PurchaseOrderController@Edit');
$router->get('/purchase_order/{id}', 'CMS\PurchaseOrder\PurchaseOrderController@Detail');
$router->get('/purchase_order/edit_item/{id}', 'CMS\PurchaseOrder\PurchaseOrderController@EditItem');
$router->get('/purchase_order/cetak_po/{id}', 'CMS\PurchaseOrder\PurchaseOrderController@CetakPO');


$router->get('/receive_request', 'CMS\ReceiveRequest\ReceiveRequestController@Home');
$router->get('/receive_request/edit_item/{id}', 'CMS\ReceiveRequest\ReceiveRequestController@EditItem');
$router->get('/receive_request/{id}', 'CMS\ReceiveRequest\ReceiveRequestController@Detail');
$router->get('/receive_request/cetak_bap/{id}', 'CMS\ReceiveRequest\ReceiveRequestController@CetakBap');

$router->get('/kontrak_payung', 'CMS\KontrakPayung\KontrakPayungController@Home');
$router->get('/kontrak_payung/new', 'CMS\KontrakPayung\KontrakPayungController@New');
$router->get('/kontrak_payung/edit/{id}', 'CMS\KontrakPayung\KontrakPayungController@Edit');
$router->get('/kontrak_payung/{id}', 'CMS\KontrakPayung\KontrakPayungController@Detail');
$router->get('/kontrak_payung/edit_item/{id}', 'CMS\KontrakPayung\KontrakPayungController@EditItem');
$router->get('/kontrak_payung/cetak_kontrak_payung/{id}', 'CMS\KontrakPayung\KontrakPayungController@CetakKontrakPayung');


$router->get('/user', 'CMS\User\UserController@Home');
$router->get('/user/new', 'CMS\User\UserController@New');
$router->get('/user/edit/{id}', 'CMS\User\UserController@Edit');
$router->get('/user/{id}', 'CMS\User\UserController@Detail');

$router->get('/profile', 'CMS\User\UserController@Profile');
$router->get('/change_password', 'CMS\User\UserController@ChangePassword');

$router->get('/notifikasi', 'CMS\Notifikasi\NotifikasiController@Home');

$router->get('/audit_trail', 'CMS\AuditTrail\AuditTrailController@Home');
$router->get('/audit_trail/log_data/{id}', 'CMS\AuditTrail\AuditTrailController@LogData');
