@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Indikator Kinerja</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Indikator Kinerja</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form id="editUserForm">
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">
                            Nama Indikator Kinerja
                        </label>
                        <div class="col-md-9">
                            <input name="name" value="{{ $data->name }}" class="form-control" type="text" placeholder="" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">
                            Turunan Dari
                        </label>
                        <div class="col-md-9 pt-2">
                            {{ !empty($data->parent->name) ? $data->parent->name : '< Kosong >' }}
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Unit Kerja</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                            'name' => 'unit_kerja_id',
                            'items' => $unit_kerja,
                            'selected' => $data->unit_kerja_id
                            ])
                            @endcomponent
                        </div>
                    </div>
                    @if (!$data->parent_id)
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Perspektif</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                            'name' => 'perspektif_id',
                            'items' => perspektif(),
                            'selected' => $data->perspektif_id
                            ])
                            @endcomponent
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button id="saveAction" class="btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i> Save
                </button>
                <a href="{{ url('/indikator_kinerja') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>

</div>

@endsection

@section('formValidationScript')
@include('app.indikator_kinerja.edit.scripts.form')
@endsection
