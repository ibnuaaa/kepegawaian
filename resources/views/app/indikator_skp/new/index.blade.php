@extends('layout.app')

@section('title', 'IndikatorSkp')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Buat Indikator Skp</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/indikator_skp">Indikator Skp</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Indikator Skp</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newIndikatorSkpForm">
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Nama {{$tipe_indikator}} : </label>
                        <input name="name" value="" class="form-control" type="text" required>
                    </div>
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Turunan Dari Indikator Kinerja :</label>
                        <label>
                            {{ $indikator_kinerja->name }}
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button data-url-next="{{ UrlPrevious(url('/indikator_skp')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>

                <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save & New
                </button>

                <a href="{{ url('/penilaian_prestasi_kerja/id/' . $penilaian_prestasi_kerja_id) }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.indikator_skp.new.scripts.form')
@endsection
