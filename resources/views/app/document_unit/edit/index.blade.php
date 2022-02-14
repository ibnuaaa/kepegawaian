@extends('layout.app')

@section('title', 'DocumentUnit')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Dokumen</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/document_unit">Dokumen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Dokumen</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-9">
        <div class="card overflow-hidden">
            <div class="card-body">
                <form autocomplete="off" id="editDocumentUnitForm">
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Judul Dokumen</label>
                        <div class="col-md-9">
                            <input name="name" value="{{ $data->name }}" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Deskripsi</label>
                        <div class="col-md-9 pt-2">
                            <textarea name="description" class="form-control">{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Unit Kerja</label>
                        <div class="col-md-9 pt-2">
                          <select class="form-control form-select" name="unit_kerja_id">
                              <option value="">-= Pilih Unit Kerja =-</option>
                              {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', $data->unit_kerja_id) : '' !!}
                          </select>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Tanggal Terbit Dokumen</label>
                        <div class="col-md-9 pt-2">
                            <input id="myDatepicker" name="tanggal_terbit_dokumen"  value="{{ $data->tanggal_terbit_dokumen }}" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">No Dokumen</label>
                        <div class="col-md-9 pt-2">
                            <input name="no_dokumen" value="{{ $data->no_dokumen }}" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">Perspektif</label>
                        <div class="col-md-9 pt-2">
                            @component('components.form.awesomeSelect', [
                                'name' => 'perspektif_id',
                                'items' => perspektif(),
                                'selected' => $data->perspektif_id
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
                                'selected' => $data->jenis_dokumen_id
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">File</label>
                        <div class="col-md-9 pt-2">
                          <input type="file" onchange="prepareUpload(this, 'document_unit', '{{ $data->id }}');" multiple>
                          <div style="clear: both;"></div>
                          <div class="img-preview mt-2" id="img-preview">
                              @if (!empty($data->document_unit))
                              @foreach ($data->document_unit as $key => $val2)
                              <a href="/api/preview/{{$val2->storage->key}}">
                                  <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                              </a>
                              @endforeach
                              @endif

                              <div style="clear: both;"></div>
                          </div>

                          <div style="clear: both;"></div>
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
                <a href="{{ UrlPrevious(url('/document_unit')) }}" class="btn btn-block btn-primary btn-cons m-b-10">
                    <i class="fa fa-arrow-left"></i> Cancel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('formValidationScript')
@include('app.document_unit.edit.scripts.form')
@endsection
