@extends('layout.app')

@section('title', 'Pelatihan')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Pelatihan</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/pelatihan">Pelatihan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pelatihan</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-9">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="editPelatihanForm">
                    <div class=" row mb-4">
                        <label  class="col-md-4 form-label">Nama Pelatihan</label>
                        <div class="col-md-8">
                            <input name="name" value="{{ $data->name }}" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Deskripsi Pelatihan</label>
                        <div class="col-md-8">
                            <textarea name="description" class="form-control">{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Mulai Pendaftaran</label>
                        <div class="col-md-8">
                            <input id="myDatepicker" value="{{ $data->tanggal_mulai_pendaftaran }}" name="tanggal_mulai_pendaftaran" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Selesai Pendaftaran</label>
                        <div class="col-md-8">
                            <input id="myDatepicker" value="{{ $data->tanggal_selesai_pendaftaran }}" name="tanggal_selesai_pendaftaran" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Mulai Pelatihan</label>
                        <div class="col-md-8">
                            <input id="myDatepicker" value="{{ $data->tanggal_mulai_pelatihan }}" name="tanggal_mulai_pelatihan" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Selesai Pelatihan</label>
                        <div class="col-md-8">
                            <input id="myDatepicker" value="{{ $data->tanggal_selesai_pelatihan }}" name="tanggal_selesai_pelatihan" value="" class="form-control" type="text" required>
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
                <a href="{{ UrlPrevious(url('/pelatihan')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                    <i class="fa fa-arrow-left"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('formValidationScript')
@include('app.pelatihan.edit.scripts.form')
@endsection
