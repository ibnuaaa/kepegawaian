@extends('layout.app')

@section('title', 'Dokumen')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Buat Dokumen</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/document_unit">Dokumen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Dokumen</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12 col-md-7 col-lg-8">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="newDocumentUnitForm">
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Judul Dokumen</label>
                        <div class="col-md-9">
                            <input name="name" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Deskripsi</label>
                        <div class="col-md-9 pt-2">
                            <textarea name="description" value="" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Unit Kerja</label>
                        <div class="col-md-9 pt-2">
                          <select class="form-control form-select" name="unit_kerja_id">
                              <option value="">-= Pilih Unit Kerja =-</option>
                              {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', MyAccount()->unit_kerja_id) : '' !!}
                          </select>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Tanggal Terbit Dokumen</label>
                        <div class="col-md-9 pt-2">
                            <input id="myDatepicker" name="tanggal_terbit_dokumen" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">No Dokumen</label>
                        <div class="col-md-9 pt-2">
                            <input name="no_dokumen" value="" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Perspektif</label>
                        <div class="col-md-9 pt-2">
                            @component('components.form.awesomeSelect', [
                                'name' => 'perspektif_id',
                                'items' => perspektif(),
                                'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Jenis Dokumen</label>
                        <div class="col-md-9 pt-2">
                            @component('components.form.awesomeSelect', [
                                'name' => 'jenis_dokumen_id',
                                'items' => jenis_dokumen(),
                                'selected' => null
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">File</label>
                        <div class="col-md-9 pt-2">
                          <input type="file" onchange="prepareUpload(this, 'document_unit', null, true);" multiple>
                          <div style="clear: both;"></div>
                          <div class="img-preview mt-2" id="img-preview">
                              <div style="clear: both;"></div>
                          </div>
                          <div style="clear: both;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-default card-action">
            <div class="card-body">
                <button data-url-next="{{ UrlPrevious(url('/document_unit')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save
                </button>

                <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                    <i class="fa fa-save"></i>
                    Save & New
                </button>

                <a href="{{ url('/document_unit') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.document_unit.new.scripts.form')
@endsection
