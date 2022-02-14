@extends('layout.app')

@section('title', 'DocumentUnit '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Dokumen</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/document_unit">Dokumen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Dokumen</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="card card-default m-t-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="font-montserrat all-caps hint-text">Detail Dokumen</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Nama Dokumen
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Deskripsi
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->description }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Jenis Dokumen
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->jenis_dokumen_id ? jenis_dokumen($data->jenis_dokumen_id) : '' }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Revisi Ke
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->revisi_ke }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Tanggal Terbit Dokumen
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->tanggal_terbit_dokumen }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        No Dokumen
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->no_dokumen }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Perspektif
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data->perspektif_id ? perspektif($data->perspektif_id) : '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
