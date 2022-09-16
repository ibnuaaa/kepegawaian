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

            <div class="container-login100">
                <div class="wrap-login100 p-6">
                    <form id="loginForm" class="p-t-15" role="form" style="opacity: 1 !important;font-family: monospace;">
                        <div class="row">
                          <div class="col-12">
                              <h3>Penandatangan</h3>
                              <table class="table table-bordered table-sm" style="font-size: 16px; ;">
                                  <tr>
                                      <td style="width:50%;">Nama</td>
                                      <td style="width:50%;">{{$data->user->name}}</td>
                                  </tr>
                                  <tr>
                                      <td>NIP</td>
                                      <td>{{$data->user->nip}}</td>
                                  </tr>
                                  <tr>
                                      <td>Waktu Approval</td>
                                      <td>{{$data->created_at}}</td>
                                  </tr>

                              </table>
                              <br>
                              <h3>Menandatangani </h3>
                              <table class="table table-bordered table-sm" style="font-size: 16px;">
                                  <tr>
                                      <td style="width:50%;">Dokumen</td>
                                      <td style="width:50%;">Penilaian Prestasi Kerja</td>
                                  </tr>
                                  <tr>
                                      <td>Nama</td>
                                      <td>{{$data->penilaian_prestasi_kerja->user->name}}</td>
                                  </tr>
                                  <tr>
                                      <td>NIP</td>
                                      <td>{{$data->penilaian_prestasi_kerja->user->nip}}</td>
                                  </tr>
                                  <tr>
                                      <td>Periode</td>
                                      <td>{{monthIndo($data->penilaian_prestasi_kerja->bulan)}} {{$data->penilaian_prestasi_kerja->tahun}}</td>
                                  </tr>

                              </table>



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
