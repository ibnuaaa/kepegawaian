@extends('layout.app')

@section('title', 'Pelatihan')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Buat Pelatihan</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/pelatihan">Pelatihan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Pelatihan</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newPelatihanForm">
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Nama Pelatihan</label>
                        <div class="col-md-8">
                            <input name="name" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Deskripsi Pelatihan</label>
                        <div class="col-md-8">
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Mulai Pendaftaran</label>
                        <div class="col-md-8">
                            <input id="myDatepicker"  name="tanggal_mulai_pendaftaran" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Selesai Pendaftaran</label>
                        <div class="col-md-8">
                            <input id="myDatepicker" name="tanggal_selesai_pendaftaran" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Mulai Pelatihan</label>
                        <div class="col-md-8">
                            <input id="myDatepicker" name="tanggal_mulai_pelatihan" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Tanggal Selesai Pelatihan</label>
                        <div class="col-md-8">
                            <input id="myDatepicker" name="tanggal_selesai_pelatihan" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-4 form-label">Biaya Pelatihan</label>
                        <div class="col-md-8">
                            <input name="biaya" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button data-url-next="{{ UrlPrevious(url('/pelatihan')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>

                <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save & New
                </button>

                <a href="{{ url('/pelatihan') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.pelatihan.new.scripts.form')
@endsection
