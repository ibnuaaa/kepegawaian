<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    protected $middleware = [
        \Barryvdh\Cors\HandleCors::class
    ];

    protected $routeMiddleware = [
        // Web Middleware
        'cookies.encrypt' => \App\Http\Middleware\EncryptCookies::class,
        'auth.web' => \App\Http\Middleware\AuthenticateForWeb::class,
        'subtitue.bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'throttle' => \App\Http\Middleware\ThrottleRequests::class,

        'auth.api' => \App\Http\Middleware\Authenticate::class,
        'auth.cms' => \App\Http\Middleware\CMS\Authenticate::class,
        'cors' => \Barryvdh\Cors\HandleCors::class,
        'landing' => \App\Http\Middleware\Landing::class,
        'ArrQuery' => \App\Http\Middleware\QueryRoute::class,
        'AuthenticatePage' => \App\Http\Middleware\AuthenticatePage::class,

        'Authentication.Login' => \App\Http\Middleware\Authentication\Login::class,

        'Account.SignUp' => \App\Http\Middleware\Account\SignUp::class,

        'Account.SignUp' => \App\Http\Middleware\Account\SignUp::class,

        'User.Insert' => \App\Http\Middleware\User\Insert::class,
        'User.InsertMember' => \App\Http\Middleware\User\InsertMember::class,
        'User.Update' => \App\Http\Middleware\User\Update::class,
        'User.UpdateAdmin' => \App\Http\Middleware\User\UpdateAdmin::class,
        'User.UpdateMember' => \App\Http\Middleware\User\UpdateMember::class,
        'User.ChangePassword' => \App\Http\Middleware\User\ChangePassword::class,
        'User.ResetPassword' => \App\Http\Middleware\User\ResetPassword::class,
        'User.ChangeStatus' => \App\Http\Middleware\User\ChangeStatus::class,
        'User.Password' => \App\Http\Middleware\User\Password::class,
        'User.Delete' => \App\Http\Middleware\User\Delete::class,

        'UserRequest.CheckExist' => \App\Http\Middleware\UserRequest\CheckExist::class,
        'UserRequest.Update' => \App\Http\Middleware\UserRequest\Update::class,
        'UserRequest.RequestApproval' => \App\Http\Middleware\UserRequest\RequestApproval::class,
        'UserRequest.Approve' => \App\Http\Middleware\UserRequest\Approve::class,
        'UserRequest.Reject' => \App\Http\Middleware\UserRequest\Reject::class,


        'Config.Insert' => \App\Http\Middleware\Config\Insert::class,
        'Config.Update' => \App\Http\Middleware\Config\Update::class,
        'Config.Delete' => \App\Http\Middleware\Config\Delete::class,

        'Golongan.Insert' => \App\Http\Middleware\Golongan\Insert::class,
        'Golongan.Update' => \App\Http\Middleware\Golongan\Update::class,
        'Golongan.Delete' => \App\Http\Middleware\Golongan\Delete::class,

        'Pendidikan.Insert' => \App\Http\Middleware\Pendidikan\Insert::class,
        'Pendidikan.Update' => \App\Http\Middleware\Pendidikan\Update::class,
        'Pendidikan.Delete' => \App\Http\Middleware\Pendidikan\Delete::class,

        'Pelatihan.Insert' => \App\Http\Middleware\Pelatihan\Insert::class,
        'Pelatihan.Update' => \App\Http\Middleware\Pelatihan\Update::class,
        'Pelatihan.Delete' => \App\Http\Middleware\Pelatihan\Delete::class,

        'StatusPegawai.Insert' => \App\Http\Middleware\StatusPegawai\Insert::class,
        'StatusPegawai.Update' => \App\Http\Middleware\StatusPegawai\Update::class,
        'StatusPegawai.Delete' => \App\Http\Middleware\StatusPegawai\Delete::class,

        'DocumentUnit.Insert' => \App\Http\Middleware\DocumentUnit\Insert::class,
        'DocumentUnit.Update' => \App\Http\Middleware\DocumentUnit\Update::class,
        'DocumentUnit.Approve' => \App\Http\Middleware\DocumentUnit\Approve::class,
        'DocumentUnit.Delete' => \App\Http\Middleware\DocumentUnit\Delete::class,

        'JabatanFungsional.Insert' => \App\Http\Middleware\JabatanFungsional\Insert::class,
        'JabatanFungsional.Update' => \App\Http\Middleware\JabatanFungsional\Update::class,
        'JabatanFungsional.Delete' => \App\Http\Middleware\JabatanFungsional\Delete::class,

        'PenilaianLogbook.Insert' => \App\Http\Middleware\PenilaianLogbook\Insert::class,
        'PenilaianLogbook.Update' => \App\Http\Middleware\PenilaianLogbook\Update::class,
        'PenilaianLogbook.Delete' => \App\Http\Middleware\PenilaianLogbook\Delete::class,

        'IndikatorTetap.Insert' => \App\Http\Middleware\IndikatorTetap\Insert::class,
        'IndikatorTetap.Update' => \App\Http\Middleware\IndikatorTetap\Update::class,
        'IndikatorTetap.Delete' => \App\Http\Middleware\IndikatorTetap\Delete::class,

        'PenilaianPrestasiKerja.Insert' => \App\Http\Middleware\PenilaianPrestasiKerja\Insert::class,
        'PenilaianPrestasiKerja.Update' => \App\Http\Middleware\PenilaianPrestasiKerja\Update::class,
        'PenilaianPrestasiKerja.Delete' => \App\Http\Middleware\PenilaianPrestasiKerja\Delete::class,

        'PenilaianPrestasiKerjaItem.Insert' => \App\Http\Middleware\PenilaianPrestasiKerjaItem\Insert::class,
        'PenilaianPrestasiKerjaItem.Update' => \App\Http\Middleware\PenilaianPrestasiKerjaItem\Update::class,
        'PenilaianPrestasiKerjaItem.Delete' => \App\Http\Middleware\PenilaianPrestasiKerjaItem\Delete::class,

        'UnitKerja.Insert' => \App\Http\Middleware\UnitKerja\Insert::class,
        'UnitKerja.Update' => \App\Http\Middleware\UnitKerja\Update::class,
        'UnitKerja.Delete' => \App\Http\Middleware\UnitKerja\Delete::class,

        'IndikatorKinerja.Insert' => \App\Http\Middleware\IndikatorKinerja\Insert::class,
        'IndikatorKinerja.Update' => \App\Http\Middleware\IndikatorKinerja\Update::class,
        'IndikatorKinerja.Delete' => \App\Http\Middleware\IndikatorKinerja\Delete::class,

        'IndikatorSkp.Insert' => \App\Http\Middleware\IndikatorSkp\Insert::class,
        'IndikatorSkp.Update' => \App\Http\Middleware\IndikatorSkp\Update::class,
        'IndikatorSkp.Delete' => \App\Http\Middleware\IndikatorSkp\Delete::class,

        'Position.Insert' => \App\Http\Middleware\Position\Insert::class,
        'Position.Update' => \App\Http\Middleware\Position\Update::class,
        'Position.Delete' => \App\Http\Middleware\Position\Delete::class,
        'Position.ChangeStatus' => \App\Http\Middleware\Position\ChangeStatus::class,

        'Jabatan.Insert' => \App\Http\Middleware\Jabatan\Insert::class,
        'Jabatan.Update' => \App\Http\Middleware\Jabatan\Update::class,
        'Jabatan.Delete' => \App\Http\Middleware\Jabatan\Delete::class,
        'Jabatan.ChangeStatus' => \App\Http\Middleware\Jabatan\ChangeStatus::class,

        'UserPendidikan.Insert' => \App\Http\Middleware\UserPendidikan\Insert::class,
        'UserPendidikan.Update' => \App\Http\Middleware\UserPendidikan\Update::class,
        'UserPendidikan.Delete' => \App\Http\Middleware\UserPendidikan\Delete::class,

        'UserJabatanFungsional.Insert' => \App\Http\Middleware\UserJabatanFungsional\Insert::class,
        'UserJabatanFungsional.Update' => \App\Http\Middleware\UserJabatanFungsional\Update::class,
        'UserJabatanFungsional.Delete' => \App\Http\Middleware\UserJabatanFungsional\Delete::class,

        'UserPelatihan.Insert' => \App\Http\Middleware\UserPelatihan\Insert::class,
        'UserPelatihan.Update' => \App\Http\Middleware\UserPelatihan\Update::class,
        'UserPelatihan.Delete' => \App\Http\Middleware\UserPelatihan\Delete::class,

        'UserKeluarga.Insert' => \App\Http\Middleware\UserKeluarga\Insert::class,
        'UserKeluarga.Update' => \App\Http\Middleware\UserKeluarga\Update::class,
        'UserKeluarga.Delete' => \App\Http\Middleware\UserKeluarga\Delete::class,

        'UserJabatan.Insert' => \App\Http\Middleware\UserJabatan\Insert::class,
        'UserJabatan.Update' => \App\Http\Middleware\UserJabatan\Update::class,
        'UserJabatan.Delete' => \App\Http\Middleware\UserJabatan\Delete::class,

        'UserGolongan.Insert' => \App\Http\Middleware\UserGolongan\Insert::class,
        'UserGolongan.Update' => \App\Http\Middleware\UserGolongan\Update::class,
        'UserGolongan.Delete' => \App\Http\Middleware\UserGolongan\Delete::class,

        'UserPendidikanRequest.Insert' => \App\Http\Middleware\UserPendidikanRequest\Insert::class,
        'UserPendidikanRequest.Update' => \App\Http\Middleware\UserPendidikanRequest\Update::class,
        'UserPendidikanRequest.Delete' => \App\Http\Middleware\UserPendidikanRequest\Delete::class,

        'UserJabatanFungsionalRequest.Insert' => \App\Http\Middleware\UserJabatanFungsionalRequest\Insert::class,
        'UserJabatanFungsionalRequest.Update' => \App\Http\Middleware\UserJabatanFungsionalRequest\Update::class,
        'UserJabatanFungsionalRequest.Delete' => \App\Http\Middleware\UserJabatanFungsionalRequest\Delete::class,

        'UserPelatihanRequest.Insert' => \App\Http\Middleware\UserPelatihanRequest\Insert::class,
        'UserPelatihanRequest.Update' => \App\Http\Middleware\UserPelatihanRequest\Update::class,
        'UserPelatihanRequest.Delete' => \App\Http\Middleware\UserPelatihanRequest\Delete::class,

        'UserKeluargaRequest.Insert' => \App\Http\Middleware\UserKeluargaRequest\Insert::class,
        'UserKeluargaRequest.Update' => \App\Http\Middleware\UserKeluargaRequest\Update::class,
        'UserKeluargaRequest.Delete' => \App\Http\Middleware\UserKeluargaRequest\Delete::class,

        'UserJabatanRequest.Insert' => \App\Http\Middleware\UserJabatanRequest\Insert::class,
        'UserJabatanRequest.Update' => \App\Http\Middleware\UserJabatanRequest\Update::class,
        'UserJabatanRequest.Delete' => \App\Http\Middleware\UserJabatanRequest\Delete::class,

        'UserGolonganRequest.Insert' => \App\Http\Middleware\UserGolonganRequest\Insert::class,
        'UserGolonganRequest.Update' => \App\Http\Middleware\UserGolonganRequest\Update::class,
        'UserGolonganRequest.Delete' => \App\Http\Middleware\UserGolonganRequest\Delete::class,

        'User.Developer.Token' => \App\Http\Middleware\User\Developer\Token::class,

        'LogActivity' => \App\Http\Middleware\LogActivity::class,

        'File.Upload' => \App\Http\Middleware\Upload\File::class,

        'Storage.Save' => \App\Http\Middleware\Storage\Save::class,
        'Storage.SaveExcel' => \App\Http\Middleware\Storage\SaveExcel::class,
        'Storage.Fetch' => \App\Http\Middleware\Storage\Fetch::class,
        'Storage.FetchTmp' => \App\Http\Middleware\Storage\FetchTmp::class,
        'Storage.Delete' => \App\Http\Middleware\Storage\Delete::class,
        'Storage.FetchThumb' => \App\Http\Middleware\Storage\FetchThumb::class,

        'PushNotification.Insert' => \App\Http\Middleware\PushNotification\Insert::class,

    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->middleware($this->middleware);
        $this->app->routeMiddleware($this->routeMiddleware);
    }
}
