@extends('layout.app')

@section('title', 'IndikatorTetap')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Buat Indikator Tetap</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/indikator_tetap">Indikator Tetap</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Indikator Tetap</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newIndikatorTetapForm">
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Nama</label>
                        <div class="col-md-9">
                            <input name="name" value="" class="form-control" type="text" required>
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
                              'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button data-url-next="{{ UrlPrevious(url('/indikator_tetap')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>

                <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save & New
                </button>

                <a href="{{ url('/indikator_tetap') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.indikator_tetap.new.scripts.form')
@endsection
