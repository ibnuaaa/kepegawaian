@extends('layout.app')

@section('title', 'Golongan')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<div class="main-container container-fluid">

  <!-- PAGE-HEADER -->
  <div class="page-header">
      <h1 class="page-title">Edit Golongan</h1>
      <div>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/golongan">Golongan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Golongan</li>
          </ol>
      </div>
  </div>
  <!-- PAGE-HEADER END -->

  <!-- ROW-1 -->
  <div class="row">
      <div class="col-9">
          <div class="card overflow-hidden">
              <div class="card-body">
                  <form autocomplete="off" id="editGolonganForm">
                      <div class="form-group form-group-default required ">
                          <label>Nama</label>
                          <input name="name" value="{{ $data['name'] }}" class="form-control" type="text" required>
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
                    <a href="{{ UrlPrevious(url('/golongan')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                        <i class="fa fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('formValidationScript')
    @include('app.golongan.edit.scripts.form')
@endsection
