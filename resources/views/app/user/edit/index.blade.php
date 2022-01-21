@extends('layout.app')

@section('title', 'User')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit User</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-9">
        <div class="card card-default">
            <div class="card-header ">
                <div class="card-title">
                    Form
                </div>
            </div>
            <div class="card-body">
                <form autocomplete="off" id="editUserForm">
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Nama</label>
                        <div class="col-md-9">
                            <input name="name" value="{{ $data['name'] }}" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Username</label>
                        <div class="col-md-9">
                            <input name="username" value="{{ $data['username'] }}" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">NIP</label>
                        <div class="col-md-9">
                            <input name="nip" value="{{ $data['nip'] }}" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Hak Akses</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                                'name' => 'position_id',
                                'items' => $positions,
                                'selected' => $data->position_id
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Jabatan</label>
                        <div class="col-md-9">
                            <select class="form-control form-select" name="jabatan_id">
                              <option value="">-= Pilih Jabatan =-</option>
                              {!! !empty($jabatan) && count($jabatan) > 0 ? treeSelectJabatan($jabatan, '', $data->jabatan_id) : '' !!}
                            </select>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Unit Kerja</label>
                        <div class="col-md-9">
                            <select class="form-control form-select" name="unit_kerja_id">
                              <option value="">-= Pilih Unit Kerja =-</option>
                              {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', $data->unit_kerja_id) : '' !!}
                            </select>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Golongan</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                                'name' => 'golongan_id',
                                'items' => $golongan,
                                'selected' => $data->golongan_id
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Password</label>
                        <div class="col-md-9">
                            <input autocomplete="new-password" name="password" class="form-control" type="password">
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Confirmation Password</label>
                        <div class="col-md-9">
                            <input name="confirmPassword" class="form-control" type="password">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card card-default card-action">
            <div class="card-body">
                <button id="saveAction" class="btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i> Save
                </button>
                <a href="{{ UrlPrevious(url('/user')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                    <i class="fa fa-arrow-left"></i> Cancel
                </a>
                <button id="deleteOpenModal" class="btn btn-block btn-danger btn-cons">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('app.user.edit.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.user.edit.scripts.form')
@endsection
