@extends('layout.app')

@section('title', 'IKI')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Buat IKT</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/e_kinerja_ikt">Iki</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Iki</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newEKinerjaIkiForm">
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Triwulan</label>
                        <select class="form-control" name="month">
                            <option>-= Pilih =-</option>
                            @foreach([1,2,3,4] as $key => $val)
                                @if($val)<option value="{{(int)$key}}">{{$val}}</option>@endif
                            @endforeach
                        </select>
                    </div>
                </form>
                <form autocomplete="off" id="newEKinerjaIkiForm">
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
                <button data-url-next="{{ UrlPrevious(url('/e_kinerja_ikt')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>
                <a href="{{ url('/e_kinerja_ikt') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.e_kinerja_ikt.new.scripts.form')
@endsection
