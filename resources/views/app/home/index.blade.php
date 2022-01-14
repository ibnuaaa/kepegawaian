@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">

                    <div class="card overflow-hidden">
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
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->


</div>

@endsection
