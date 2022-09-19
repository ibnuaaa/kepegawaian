@extends('layout.app')

@section('title', 'Upload Absensi '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Upload Absensi</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/pendidikan">Upload Absensi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Upload Absensi</li>
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
                        <h2 class="font-montserrat all-caps hint-text">Detail Upload Absensi</h2>
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
                                    No
                                </td>
                                <td>
                                    NIP
                                </td>
                                <td>
                                    Nilai
                                </td>

                            </tr>

                            @foreach ($data->upload_absensi_detail as $key => $val)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>
                                    {{ $val->nip }}
                                </td>
                                <td>
                                    {{ $val->nilai }}
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
