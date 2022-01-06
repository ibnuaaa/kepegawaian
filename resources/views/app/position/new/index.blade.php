@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Profil User</h1>
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
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Nama</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group form-group-default required">
                                        <input name="name" value="" class="form-control" type="text" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Turunan Dari</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <select name="parent_id" class="form-control">
                                    </select>
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
                        <a href="{{ url('/position/paging') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('formValidationScript')
    @include('app.position.new.scripts.form')
@endsection
