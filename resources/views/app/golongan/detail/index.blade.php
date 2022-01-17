@extends('layout.app')

@section('title', 'Golongan '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Golongan</h1>
    <div>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/golongan">Golongan</a></li>
          <li class="breadcrumb-item active" aria-current="page">Detail Golongan</li>
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
                        <h2 class="font-montserrat all-caps hint-text">Detail Golongan</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Nama
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data['name'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
