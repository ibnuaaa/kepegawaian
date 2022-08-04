@extends('layout.app')

@section('title', 'E-Kinerja Iki')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit E-Kinerja Iki</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/pendidikan">E-Kinerja Iki</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit E-Kinerja Iki</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-9">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="editEKinerjaIkiForm">
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Tahun</label>
                        <input name="year" value="{{ $data['year'] }}" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group form-group-default required ">
                        <label class="form-label">Bulan</label>
                        <select class="form-control" name="month" disabled>
                            <option>-= Pilih =-<option>
                            @foreach(listMonth() as $key => $val)
                                @if ($val)
                                    <option @if($key == $data['month']) selected  @endif >{{$val}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-group-default required ">
                        <label class="form-label">File</label>
                        <input type="file" onchange="prepareUpload(this, 'e_kinerja_iki', null, true, ['xls','xlsx']);">
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
                <a href="{{ UrlPrevious(url('/pendidikan')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                    <i class="fa fa-arrow-left"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('formValidationScript')
@include('app.e_kinerja_iki.edit.scripts.form')
@endsection
