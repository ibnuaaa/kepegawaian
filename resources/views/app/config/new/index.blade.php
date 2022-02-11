@extends('layout.app')

@section('title', 'Config')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Buat Config</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/config">Config</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Config</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newConfigForm">
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Key</label>
                        <input name="key" value="" class="form-control" type="text" required>
                    </div>
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Value</label>
                        <input name="value" value="" class="form-control" type="text" required>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button data-url-next="{{ UrlPrevious(url('/config')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>

                <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save & New
                </button>

                <a href="{{ url('/config') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.config.new.scripts.form')
@endsection
