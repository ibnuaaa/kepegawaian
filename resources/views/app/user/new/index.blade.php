@extends('layout.app')

@section('title', 'User')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Buat User</h1>
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
                        <form autocomplete="off" id="newUserForm">
                            <div class="form-group form-group-default required ">
                                <label>Nama</label>
                                <input name="name" value="" class="form-control" type="text" required>
                            </div>

                            <div class="form-group form-group-default required ">
                                <label>Username</label>
                                <input name="username" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>NIP</label>
                                <input name="nip" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Password</label>
                                <input autocomplete="new-password" name="password" class="form-control" type="password" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Confirmation Password</label>
                                <input name="confirmPassword" class="form-control" type="password" required>
                            </div>
                            <div class="form-group form-group-default required ">
                                <label>Email</label>
                                <input name="email" class="form-control" type="text" required>
                            </div>
                            <div class="form-group form-group-default form-group-default-select2 required">
                                <label class="">Position</label>
                                @component('components.form.awesomeSelect', [
                                    'name' => 'position_id',
                                    'items' => $positions,
                                    'selected' => 3
                                ])
                                @endcomponent
                            </div>
                            <div class="form-group form-group-default form-group-default-select2 required">
                                <label class="">Gender</label>
                                @component('components.form.awesomeSelect', [
                                    'name' => 'gender',
                                    'items' => [['value' => 'male', 'label' => 'Male'], ['value' => 'female', 'label' => 'Female']],
                                    'selected' => null
                                ])
                                @endcomponent
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card card-default card-action">
                    <div class="card-body">
                        <button data-url-next="{{ UrlPrevious(url('/user')) }}" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                            <i class="fa fa-save"></i>
                            Save
                        </button>

                        <button data-is-recreate="true" class="saveAction btn btn-block btn-success btn-cons m-b-10">
                            <i class="fa fa-save"></i>
                            Save & New
                        </button>

                        <a href="{{ url('/user') }}" class="btn btn-block btn-primary btn-cons m-b-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.new.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.user.new.scripts.form')
@endsection
