@extends('layout.app')

@section('title', 'IndikatorTetap')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Indikator Tetap</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/indikator_tetap">Indikator Tetap</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Indikator Tetap</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-9">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="editIndikatorTetapForm">
                  <div class=" row mb-4">
                      <label class="col-md-3 form-label">Nama</label>
                      <div class="col-md-9">
                          <input name="name" value="{{ $data['name'] }}" class="form-control" type="text" required>
                      </div>
                  </div>
                  <div class=" row mb-4">
                      <label class="col-md-3 form-label">Tipe Indikator</label>
                      <div class="col-md-9">
                          @component('components.form.awesomeSelect', [
                            'name' => 'type',
                            'items' => [
                                [
                                    'label' => '-= Pilih Tipe =-',
                                    'value' => ''
                                ],
                                [
                                    'label' => 'Perilaku Kerja',
                                    'value' => 'perilaku_kerja'
                                ],
                                [
                                    'label' => 'Kualitas',
                                    'value' => 'kualitas'
                                ]
                            ],
                            'selected' => $data['type']
                          ])
                          @endcomponent
                      </div>
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
                <a href="{{ UrlPrevious(url('/indikator_tetap')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                    <i class="fa fa-arrow-left"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('formValidationScript')
@include('app.indikator_tetap.edit.scripts.form')
@endsection
