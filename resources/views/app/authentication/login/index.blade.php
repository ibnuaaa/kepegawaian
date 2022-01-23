@extends('layout.authentication')

@section('title', 'Login')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

<!-- SINGLE-PAGE CSS -->
<link href="/assets/plugins/single-page/css/main.css" rel="stylesheet" type="text/css">


@section('content')
<div class="login-img">

    <!-- GLOABAL LOADER -->
    <div id="global-loader">
        <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOABAL LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="">
            <!-- Theme-Layout -->

            <!-- CONTAINER OPEN -->
            <div class="col col-login mx-auto mt-7">
                <div class="text-center">
                    <img src="/assets/images/brand/logo-white.png" class="header-brand-img" alt="">
                </div>
            </div>

            <div class="container-login100">
                <div class="wrap-login100 p-6">
                    <span class="login100-form-title pb-5">
                        Login SIMPEG
                    </span>
                    <!-- START Login Form -->
                    <form id="loginForm" class="p-t-15" role="form" style="opacity: 1 !important;">
                        <div class="form-group form-group-default login100-form">
                            <div class="controls">
                                <input type="text" name="username" placeholder="Email / NIP" class="form-control">
                            </div>
                        </div>
                        <div class="form-group form-group-default">
                            <div class="controls">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center m-t-10">
                                <button class="btn btn-primary m-t-10 w-100" type="submit">Masuk</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center text-center">
                                <br />
                                <span style="color: #ffffff; font-size: 12px;font-weight: bold;color: #00AA00;">
                                    &copy;2022 RS PUSAT OTAK NASIONAL
                                </span>
                            </div>
                        </div>
                    </form>
                    <!--END Login Form-->
                </div>

            </div>
        </div>
        <!-- END Login Right Container-->
    </div>
</div>
@endsection

@section('script')
@include('app.authentication.login.scripts.index')
@endsection

@section('formValidationScript')
@include('app.authentication.login.scripts.form')
@endsection
