@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="card card-white">
            <div class="card-body text-center" style="font-size: 20px;">
                <br /><br /><br />
                <b>
                    <div class="m-b-5">
                        SELAMAT DATANG
                    </div>
                    <div class="m-b-5">
                        di
                    </div>
                    <div class="m-b-5">
                        <span style="font-weight: bold; font-size: 40px;">SIMPEG - RSPON<i></i></span>
                    </div>
                    <div class="m-b-5">
                        <span style="font-weight: bold; font-size: 40px;">Sistem Informasi Manajemen Kepegawaian</span> <br>
                    </div>
                    <div class="m-b-5">
                        <img style="width: 200px;" src="/assets/img/logo-rspon.png">
                    </div>
                    RS PUSAT OTAK NASIONAL
                    <br /><br /><br /><br />
                </b>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('app.home.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.home.scripts.form')
@endsection
