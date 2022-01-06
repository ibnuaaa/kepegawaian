@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Ganti Password</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ganti password</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
              <div class="card card-white">
                  <div class="card-header ">
                      <div class="card-title">Form</div><br>
                  </div>
                  <div class="card-body">

                    <form id="changePasswordForm">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Password Lama</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="password" value="" class="form-control" type="password" placeholder="Password Lama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Password Baru</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="new_password" value="" class="form-control" type="password" placeholder="Passwor Baru" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group form-group-default required">
                                <input name="new_password_confirmation" value="" class="form-control" type="password" placeholder="Konfirmasi Password baru" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                        </div>
                        <div class="col-9">
                            <button id="saveAction" class="btn btn-block btn-success btn-cons m-b-10">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </form>
                  </div>

              </div>
          </div>
        </div>
    </div>
    <!-- ROW-1 END -->
</div>
@endsection

@section('script')
    @include('app.user.change_password.scripts.form')
@endsection
