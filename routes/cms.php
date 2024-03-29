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

$router->get('/position', 'CMS\Position\PositionController@HomeWithPaging');
$router->get('/position/new/{position_id}', 'CMS\Position\PositionController@New');
$router->get('/position/{id}', 'CMS\Position\PositionController@PositionEdit');

$router->get('/jabatan', 'CMS\Jabatan\JabatanController@Home');
$router->get('/jabatan/new/{jabatan_id}', 'CMS\Jabatan\JabatanController@New');
$router->get('/jabatan/{id}', 'CMS\Jabatan\JabatanController@JabatanEdit');

$router->get('/golongan', 'CMS\Golongan\GolonganController@Home');
$router->get('/golongan/new', 'CMS\Golongan\GolonganController@New');
$router->get('/golongan/edit/{id}', 'CMS\Golongan\GolonganController@Edit');
$router->get('/golongan/{id}', 'CMS\Golongan\GolonganController@Detail');

$router->get('/complaint', 'CMS\Complaint\ComplaintController@Home');
$router->get('/complaint/{menu}', 'CMS\Complaint\ComplaintController@Home');
$router->get('/complaint/edit/{id}', 'CMS\Complaint\ComplaintController@Edit');
$router->get('/complaint/detail/{id}/{menu}', 'CMS\Complaint\ComplaintController@Detail');

$router->get('/unit_kerja', 'CMS\UnitKerja\UnitKerjaController@Home');
$router->get('/unit_kerja/new/{unit_kerja_id}', 'CMS\UnitKerja\UnitKerjaController@New');
$router->get('/unit_kerja/{id}', 'CMS\UnitKerja\UnitKerjaController@UnitKerjaEdit');

$router->get('/indikator_kinerja', 'CMS\IndikatorKinerja\IndikatorKinerjaController@Home');
$router->get('/indikator_kinerja/new/{indikator_kinerja_id}', 'CMS\IndikatorKinerja\IndikatorKinerjaController@New');
$router->get('/indikator_kinerja/{id}', 'CMS\IndikatorKinerja\IndikatorKinerjaController@IndikatorKinerjaEdit');

$router->get('/mata_anggaran', 'CMS\MataAnggaran\MataAnggaranController@Home');
$router->get('/mata_anggaran/new/{mata_anggaran_id}', 'CMS\MataAnggaran\MataAnggaranController@New');
$router->get('/mata_anggaran/{id}', 'CMS\MataAnggaran\MataAnggaranController@MataAnggaranEdit');

$router->get('/user_request/status/{status}/{menu}', 'CMS\UserRequest\UserRequestController@Home');
$router->get('/user_request/{menu}/{id}', 'CMS\UserRequest\UserRequestController@Detail');

$router->get('/report_skp', 'CMS\ReportSkp\ReportSkpController@Home');

$router->get('/config', 'CMS\Config\ConfigController@Home');
$router->get('/config/new', 'CMS\Config\ConfigController@New');
$router->get('/config/edit/{id}', 'CMS\Config\ConfigController@Edit');
$router->get('/config/{id}', 'CMS\Config\ConfigController@Detail');

$router->get('/pendidikan', 'CMS\Pendidikan\PendidikanController@Home');
$router->get('/pendidikan/new', 'CMS\Pendidikan\PendidikanController@New');
$router->get('/pendidikan/edit/{id}', 'CMS\Pendidikan\PendidikanController@Edit');
$router->get('/pendidikan/{id}', 'CMS\Pendidikan\PendidikanController@Detail');

$router->get('/approval_penilaian_sdm/status/{status}', 'CMS\ApprovalPenilaianSdm\ApprovalPenilaianSdmController@Home');
$router->get('/approval_penilaian_sdm/{id}', 'CMS\ApprovalPenilaianSdm\ApprovalPenilaianSdmController@Detail');

$router->get('/kampus', 'CMS\Kampus\KampusController@Home');
$router->get('/kampus/new', 'CMS\Kampus\KampusController@New');
$router->get('/kampus/edit/{id}', 'CMS\Kampus\KampusController@Edit');
$router->get('/kampus/{id}', 'CMS\Kampus\KampusController@Detail');

$router->get('/pelatihan', 'CMS\Pelatihan\PelatihanController@Home');
$router->get('/pelatihan/new', 'CMS\Pelatihan\PelatihanController@New');
$router->get('/pelatihan/edit/{id}', 'CMS\Pelatihan\PelatihanController@Edit');
$router->get('/pelatihan/{id}', 'CMS\Pelatihan\PelatihanController@Detail');

$router->get('/laporan_iki', 'CMS\Laporan\LaporanIkiController@Home');

$router->get('/status_pegawai', 'CMS\StatusPegawai\StatusPegawaiController@Home');
$router->get('/status_pegawai/new', 'CMS\StatusPegawai\StatusPegawaiController@New');
$router->get('/status_pegawai/edit/{id}', 'CMS\StatusPegawai\StatusPegawaiController@Edit');
$router->get('/status_pegawai/{id}', 'CMS\StatusPegawai\StatusPegawaiController@Detail');

$router->get('/document_unit', 'CMS\DocumentUnit\DocumentUnitController@Home');
$router->get('/document_unit/new', 'CMS\DocumentUnit\DocumentUnitController@New');
$router->get('/document_unit/edit/{id}', 'CMS\DocumentUnit\DocumentUnitController@Edit');
$router->get('/document_unit/{id}', 'CMS\DocumentUnit\DocumentUnitController@Detail');

$router->get('/jabatan_fungsional', 'CMS\JabatanFungsional\JabatanFungsionalController@Home');
$router->get('/jabatan_fungsional/new', 'CMS\JabatanFungsional\JabatanFungsionalController@New');
$router->get('/jabatan_fungsional/edit/{id}', 'CMS\JabatanFungsional\JabatanFungsionalController@Edit');
$router->get('/jabatan_fungsional/{id}', 'CMS\JabatanFungsional\JabatanFungsionalController@Detail');

// $router->get('/indikator_skp', 'CMS\IndikatorSkp\IndikatorSkpController@Home');
$router->get('/indikator_skp/new/{tipe_indikator}/{indikator_kinerja_id}/{penilaian_prestasi_kerja_id}', 'CMS\IndikatorSkp\IndikatorSkpController@New');
$router->get('/indikator_skp/edit/{id}/{penilaian_prestasi_kerja_id}', 'CMS\IndikatorSkp\IndikatorSkpController@Edit');
$router->get('/indikator_skp/{id}', 'CMS\IndikatorSkp\IndikatorSkpController@Detail');

$router->get('/penilaian_prestasi_kerja/id/{penilaian_prestasi_kerja_id}', 'CMS\PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@IndikatorSkp');
$router->get('/penilaian_prestasi_kerja', 'CMS\PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Home');
$router->get('/penilaian_prestasi_kerja/edit/{id}', 'CMS\PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Edit');
$router->get('/penilaian_prestasi_kerja/pdf/{id}', 'CMS\PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Pdf');
$router->get('/penilaian_prestasi_kerja/pdf_iku/{id}', 'CMS\PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@PdfIku');
$router->get('/penilaian_prestasi_kerja/{id}', 'CMS\PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Detail');
$router->get('/penilaian_prestasi_kerja/logbook/{id}', 'CMS\PenilaianPrestasiKerja\PenilaianPrestasiKerjaController@Logbook');

$router->get('/penilaian_prestasi_kerja_approval', 'CMS\PenilaianPrestasiKerjaApproval\PenilaianPrestasiKerjaApprovalController@Home');
$router->get('/penilaian_prestasi_kerja_approval/{id}', 'CMS\PenilaianPrestasiKerjaApproval\PenilaianPrestasiKerjaApprovalController@Detail');

$router->get('/penilaian_perilaku_kerja', 'CMS\PenilaianPerilakuKerja\PenilaianPerilakuKerjaController@Home');
$router->get('/penilaian_perilaku_kerja/edit/{id}', 'CMS\PenilaianPerilakuKerja\PenilaianPerilakuKerjaController@Edit');
$router->get('/penilaian_perilaku_kerja/{id}', 'CMS\PenilaianPerilakuKerja\PenilaianPerilakuKerjaController@Detail');

$router->get('/indikator_tetap', 'CMS\IndikatorTetap\IndikatorTetapController@Home');
$router->get('/indikator_tetap/new', 'CMS\IndikatorTetap\IndikatorTetapController@New');
$router->get('/indikator_tetap/edit/{id}', 'CMS\IndikatorTetap\IndikatorTetapController@Edit');
$router->get('/indikator_tetap/{id}', 'CMS\IndikatorTetap\IndikatorTetapController@Detail');

$router->get('/user', 'CMS\User\UserController@Home');
$router->get('/user/new', 'CMS\User\UserController@New');
$router->get('/user/edit/{id}', 'CMS\User\UserController@Edit');
$router->get('/user/{id}', 'CMS\User\UserController@Detail');

$router->get('/profile', 'CMS\User\UserController@Profile');
$router->get('/profile/{tab}', 'CMS\User\UserController@ProfileEdit');
$router->get('/profile/{tab}/{id}', 'CMS\User\UserController@ProfileEdit');
$router->get('/change_password', 'CMS\User\UserController@ChangePassword');

$router->get('/notifikasi', 'CMS\Notifikasi\NotifikasiController@Home');

$router->get('/audit_trail', 'CMS\AuditTrail\AuditTrailController@Home');
$router->get('/audit_trail/log_data/{id}', 'CMS\AuditTrail\AuditTrailController@LogData');

$router->get('/upload_absensi', 'CMS\UploadAbsensi\UploadAbsensiController@Home');
$router->get('/upload_absensi/new', 'CMS\UploadAbsensi\UploadAbsensiController@New');
$router->get('/upload_absensi/edit/{id}', 'CMS\UploadAbsensi\UploadAbsensiController@Edit');
$router->get('/upload_absensi/{id}', 'CMS\UploadAbsensi\UploadAbsensiController@Detail');

$router->get('/e_kinerja_iki', 'CMS\EKinerjaIki\EKinerjaIkiController@Home');
$router->get('/e_kinerja_iki/new', 'CMS\EKinerjaIki\EKinerjaIkiController@New');
$router->get('/e_kinerja_iki/edit/{id}', 'CMS\EKinerjaIki\EKinerjaIkiController@Edit');
$router->get('/e_kinerja_iki/{id}', 'CMS\EKinerjaIki\EKinerjaIkiController@Detail');

$router->get('/e_kinerja_ikt', 'CMS\EKinerjaIkt\EKinerjaIktController@Home');
$router->get('/e_kinerja_ikt/new', 'CMS\EKinerjaIkt\EKinerjaIktController@New');
$router->get('/e_kinerja_ikt/edit/{id}', 'CMS\EKinerjaIkt\EKinerjaIktController@Edit');
$router->get('/e_kinerja_ikt/{id}', 'CMS\EKinerjaIkt\EKinerjaIktController@Detail');
