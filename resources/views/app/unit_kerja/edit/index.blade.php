@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit UnitKerja</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit UnitKerja</li>
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
                            Nama UnitKerja
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
                          @component('components.form.awesomeSelect', [
                              'name' => 'parent_id',
                              'items' => $unit_kerja,
                              'selected' => null
                          ])
                          @endcomponent
                        </div>
                    </div>
                    <div class=" row mb-4">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Status</label>
                            </div>
                        </div>
                        <div class="col-9">
                            @if (!empty($data['status']) && $data['status'] == 'active')
                            <input type="button" class="btn btn-primary btn-xs" value="Active" />
                            @else
                            <input type="button" class="btn btn-danger btn-xs" value="Inctive" />
                            @endif
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
                <a href="{{ url('/unit_kerja') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>

</div>

@endsection

@section('formValidationScript')
    @include('app.unit_kerja.edit.scripts.form')
@endsection
