@extends('layout.app')

@section('title', 'E-Kinerja Iki '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">E-Kinerja Iki</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/pendidikan">E-Kinerja Iki</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail E-Kinerja Iki</li>
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
                        <h2 class="font-montserrat all-caps hint-text">Detail E-Kinerja Iki</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Bulan
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ monthIndo($data['month']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Tahun
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data['year'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <br><br>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    Kategori
                                </td> 
                                <td>
                                    No
                                </td>
                                <td>
                                    Judul Indikator
                                </td> 
                                <td>
                                    Bobot
                                </td>
                                <td>
                                    Standart
                                </td>
                                <td>
                                    Haper
                                </td>
                                <td>
                                    Skor
                                </td>
                                <td>
                                    Total
                                </td>
                                
                                
                            </tr> 
                            
                            @foreach ($data->e_kinerja_iki_detail as $key => $val)
                            <tr>
                                <td>
                                    {{ $val->category }}
                                </td> 
                                <td>
                                    {{ $val->no }}
                                </td>
                                <td>
                                    {{ $val->judul_indikator }}
                                </td> 
                                <td>
                                {{ $val->bobot }}
                                </td>
                                <td>
                                {{ $val->standart }}
                                </td>
                                <td>
                                {{ $val->haper }}
                                </td>
                                <td>
                                {{ $val->skor }}
                                </td>
                                <td>
                                {{ $val->total }}
                                </td>
                                
                                
                            </tr> 
                            @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
