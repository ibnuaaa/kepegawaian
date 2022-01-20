@extends('layout.app')

@section('title', 'User')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Buat User</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil User</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newUserForm">
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Nama</label>
                        <div class="col-md-9">
                            <input name="name" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Username</label>
                        <div class="col-md-9">
                            <input name="username" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">NIP</label>
                        <div class="col-md-9">
                            <input name="nip" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Password</label>
                        <div class="col-md-9">
                            <input autocomplete="new-password" name="password" class="form-control" type="password" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Konfirmasi Password</label>
                        <div class="col-md-9">
                            <input name="confirmPassword" class="form-control" type="password" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Email</label>
                        <div class="col-md-9">
                            <input name="email" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Hak Akses</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                                'name' => 'position_id',
                                'items' => $positions,
                                'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Jabatan</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                                'name' => 'jabatan_id',
                                'items' => $jabatan,
                                'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Unit Kerja</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                                'name' => 'unit_kerja_id',
                                'items' => $unit_kerja,
                                'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Golongan</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                                'name' => 'golongan_id',
                                'items' => $golongan,
                                'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Gender</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                                'name' => 'gender',
                                'items' => [['value' => 'male', 'label' => 'Laki-laki'], ['value' => 'female', 'label' => 'Perempuan']],
                                'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button data-url-next="{{ UrlPrevious(url('/user')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>

                <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save & New
                </button>

                <a href="{{ url('/user') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('app.user.new.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.user.new.scripts.form')
@endsection
