@extends('layout.app')

@section('title', 'Upload Absensi')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Upload Absensi</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/upload_absensi">Upload Absensi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Upload Absensi</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newUploadAbsensiForm">
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Bulan</label>
                        <select class="form-control" name="month">
                            <option>-= Pilih =-<option>
                            @foreach(listMonth() as $key => $val)
                                @if((int)$key == (int)date('m'))
                                <option selected value="{{(int)$key}}">{{$val}}</option>
                                @else
                                <option value="{{(int)$key}}">{{$val}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </form>
                <form autocomplete="off" id="newUploadAbsensiForm">
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Year</label>
                        <input name="year" value="{{date('Y')}}" class="form-control" type="number" required>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button data-url-next="{{ UrlPrevious(url('/upload_absensi')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>
                <a href="{{ url('/upload_absensi') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.upload_absensi.new.scripts.form')
@endsection
