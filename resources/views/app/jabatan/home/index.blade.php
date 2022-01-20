@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">
      Jabatan
      <a href="/jabatan/new/0" class="btn btn-primary btn-sm">
          (+) Buat Jabatan
      </a>
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
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
                          <th style="width: 50%;">JABATAN</th>
                          <th style="width: 30%;">NAMA PEGAWAI / NIP</th>
                          <th style="width: 100px;">AKSI</th>
                      </tr>
                  </thead>
                  <tbody>
                  {!! treeChildJabatan($data, '') !!}
                  </tbody>
              </table>
          </div>
      </div>
      <!-- ROW-1 END -->
    </div>
</div>
@endsection

@section('formValidationScript')
    @include('app.jabatan.home.scripts.form')
@endsection

@section('script')
    @include('app.jabatan.home.style.style')
@endsection
