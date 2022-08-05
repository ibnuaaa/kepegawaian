@extends('layout.app')

@section('title', 'E-Kinerja Ikt '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">E-Kinerja Ikt</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/pendidikan">E-Kinerja Ikt</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail E-Kinerja IKT</li>
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
                        <h2 class="font-montserrat all-caps hint-text">Detail E-Kinerja IKT</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2">
                        Triwulan Ke
                    </div>
                    <div class="col-6 col-md-10">
                        : {{ $data['month'] }}
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
                                    No
                                </td>
                                <td>
                                    Judul Indikator
                                </td>
                                <td>
                                    Standart
                                </td>
                                <td>
                                    Target
                                </td>
                                <td>
                                    Realisasi
                                </td>


                            </tr>

                            @foreach ($data->e_kinerja_ikt_detail as $key => $val)
                            <tr>
                                <td>
                                    {{ $val->no }}
                                </td>
                                <td>
                                    {{ $val->judul_indikator }}
                                </td>
                                <td>
                                {{ $val->standart }}
                                </td>
                                <td>
                                {{ $val->target }}
                                </td>
                                <td>
                                {{ $val->realisasi }}
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
