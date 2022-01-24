@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">
        Buat Indikator Kinerja
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil User</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-9">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form id="editUserForm">
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Nama Indikator Kinerja</label>
                        <div class="col-md-9">
                            <input name="name" value="" class="form-control" type="text" placeholder="" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Turunan Dari</label>
                        <div class="col-md-9 pt-2">
                            {{ !empty($parent_indikator_kinerja->name) ? $parent_indikator_kinerja->name : '< Kosong >' }}
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Unit Kerja</label>
                        <div class="col-md-9">
                            <span id="span_unit_kerja"></span> &nbsp;&nbsp;
                            <a href="#" onclick="return openModalUnitKerja()" class="btn btn-sm btn-primary">
                                Pilih Unit Kerja ...
                            </a>
                        </div>
                    </div>
                    @if (empty($parent_indikator_kinerja->name))
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Perspektif</label>
                        <div class="col-md-9">
                            @component('components.form.awesomeSelect', [
                            'name' => 'perspektif_id',
                            'items' => perspektif(),
                            'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                    @endif
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
                <a href="{{ url('/indikator_kinerja') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>


<div class="modal effect-sign" id="modalUnitKerja" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Unit Kerja</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-sasaran-kinerja">
                <table id="basic" class="table table-bordered table-condensed-custom">
                    <thead>
                        <tr>
                            <th>UNIT KERJA</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! treeChildUnitKerjaModal($unit_kerja, '') !!}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


@endsection

@section('formValidationScript')
@include('app.indikator_kinerja.new.scripts.form')
@endsection
