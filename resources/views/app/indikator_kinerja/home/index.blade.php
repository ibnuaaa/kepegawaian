@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">
      IndikatorKinerja
      <a href="/indikator_kinerja/new/0" class="btn btn-primary btn-sm">
          (+) Buat IndikatorKinerja
      </a>
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">IndikatorKinerja</li>
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
                          <th style="width: 45%;">INDIKATOR KINERJA</th>
                          <th style="width: 30%;">NAMA PEGAWAI / NIP</th>
                          <th style="width: 180px;">AKSI</th>
                      </tr>
                  </thead>
                  <tbody>
                  {!! treeChildIndikatorKinerja($data, '') !!}
                  </tbody>
              </table>
          </div>
      </div>
      <!-- ROW-1 END -->
    </div>
</div>
@endsection

@section('formValidationScript')
    @include('app.indikator_kinerja.home.scripts.form')
@endsection

@section('script')
    @include('app.indikator_kinerja.home.style.style')
@endsection
