@extends('layout.app')

@section('title', 'UnitKerja')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Buat UnitKerja</h1>
        <div>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="/unit_kerja">UnitKerja</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buat UnitKerja</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-12 col-md-7 col-lg-8">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <form autocomplete="off" id="newUnitKerjaForm">
                        <div class="form-group form-group-default required ">
                            <label>Nama</label>
                            <input name="name" value="" class="form-control" type="text" required>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card card-default card-action">
                <div class="card-body">
                    <button data-url-next="{{ UrlPrevious(url('/unit_kerja')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                        <i class="fa fa-save"></i>
                        Save
                    </button>

                    <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                        <i class="fa fa-save"></i>
                        Save & New
                    </button>

                    <a href="{{ url('/unit_kerja') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('formValidationScript')
    @include('app.unit_kerja.new.scripts.form')
@endsection
