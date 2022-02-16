@extends('layout.app')

@section('title', 'Pelatihan '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Pelatihan</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/pelatihan">Pelatihan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pelatihan</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="card card-default m-t-20">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h2 class="font-montserrat all-caps hint-text">Detail Pelatihan</h2>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-6 col-md-2">
                        Nama
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->name }}
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-6 col-md-2">
                        Periode Pendaftaran
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->tanggal_mulai_pendaftaran }} s/d {{ $data->tanggal_selesai_pendaftaran }}
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-6 col-md-2">
                        Periode Pelatihan
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->tanggal_mulai_pelatihan }} s/d {{ $data->tanggal_selesai_pelatihan }}
                    </div>
                </div>
                <div class="row mb-8">
                    <div class="col-6 col-md-2">
                        Deskripsi
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->description }}
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-md-12 text-center">
                        <a href="#" class="btn btn-primary">
                            Ikuti Pelatihan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
