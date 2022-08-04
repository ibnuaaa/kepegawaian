@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">
        Mata Anggaran
        <a href="/mata_anggaran/new/0" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i>
            Buat Mata Anggaran
        </a>
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mata Anggaran</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12">
        <div class="card overflow-hidden">
            <div class="card-body">
                <table id="basic" class="table table-bordered table-condensed-custom">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>MATA ANGGARAN</th>
                            <th style="width: 20%;">UNIT KERJA</th>
                            <th style="width: 120px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! treeChildMataAnggaran($data, '', '', 0) !!}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- ROW-1 END -->
    </div>
</div>
@endsection

@section('formValidationScript')
@include('app.mata_anggaran.home.scripts.form')
@endsection

@section('script')
@include('app.mata_anggaran.home.style.style')
@endsection
