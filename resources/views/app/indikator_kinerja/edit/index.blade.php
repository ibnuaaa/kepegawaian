@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit IndikatorKinerja</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit IndikatorKinerja</li>
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
                            Nama IndikatorKinerja
                        </label>
                        <div class="col-md-9">
                            <input name="name" value="{{ $data->name }}" class="form-control" type="text" placeholder="" required>
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <label class="col-md-3 form-label">
                            Turunan Dari
                        </label>
                        <div class="col-md-9">
                            <select class="form-control form-select" name="parent_id">
                              <option value="">-= Pilih Indikator Kinerja =-</option>
                              {!! !empty($indikator_kinerja) && count($indikator_kinerja) > 0 ? treeSelectIndikatorKinerja($indikator_kinerja, '', $data->parent_id) : '' !!}
                            </select>
                        </div>
                    </div>
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
