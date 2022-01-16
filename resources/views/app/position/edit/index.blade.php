@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Jabatan</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Jabatan</li>
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
                            Nama Jabatan
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
                            <select name="parent_id" class="form-control">
                                <option value="{{  $data->parent ? $data->parent->id : '' }}">{{  $data->parent ? $data->parent->name : '' }}</option>
                            </select>
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
                    <div class="form-group-attached form-group-default">
                        <label>ACCESS MENU</label>
                        @foreach ($permissions as $KeyPermission => $permission)
                          <div class="row">
                            @foreach ($permission as $KeyEach => $each)
                            <div class="col-md-4 row">
                                <div class="checkbox check-info col-3 col-md-1">
                                    <input type="checkbox" name="permission" {{$each->checked ? 'checked' : ''}} value="{{$each->id}}" id="checkbox-{{$each->id}}">
                                </div>
                                <div class="col-md-10 col-9">
                                    <label for="checkbox-{{$each->id}}">{{ $each->name }}</label>
                                </div>
                            </div>
                            @endforeach
                          </div>
                        @endforeach
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

                @if (!empty($data->status) && $data->status == 'active')
                <button onClick="changeStatusPosition('inactive')" class="btn btn-block btn-danger btn-cons m-b-10">
                    <i class="fa fa-check"></i> Inactive
                </button>
                @else
                <button onClick="changeStatusPosition('active')" class="btn btn-block btn-primary btn-cons m-b-10">
                    <i class="fa fa-check"></i> Active
                </button>
                @endif


                <a href="{{ url('/position') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
            </div>
        </div>
    </div>

</div>

@endsection

@section('formValidationScript')
    @include('app.position.edit.scripts.form')
@endsection
