@extends('layout.app')

@section('title', 'PenilaianPrestasiKerja')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Penilaian Prestasi Kerja</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/penilaian_prestasi_kerja">Penilaian Prestasi Kerja</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Penilaian PrestasiKerja</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12">
        <div class="card overflow-hidden">
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th class="text-center" colspan="7">
                            1. Indikator Sasaran Kinerja Pegawai (70%)
                        </th>
                    </tr>

                    <tr>
                        <th class="text-center">
                            No
                        </th>
                        <th class="text-center">
                            Nama Indikator
                        </th>
                        <th class="text-center">
                            Bobot
                        </th>
                        <th class="text-center">
                            Target
                        </th>
                        <th class="text-center">
                            Realisasi
                        </th>
                        <th class="text-center">
                            Capaian
                        </th>
                        <th class="text-center">
                            Nilai Kinerja
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center fs-8">
                            1
                        </th>
                        <th class="text-center fs-8">
                            2
                        </th>
                        <th class="text-center fs-8">
                            3
                        </th>
                        <th class="text-center fs-8">
                            4
                        </th>
                        <th class="text-center fs-8">
                            5
                        </th>
                        <th class="text-center fs-8">
                            6 = 5/4
                        </th>
                        <th class="text-center fs-8">
                            7 = 6*3
                        </th>
                    </tr>

                    <tr>
                        <td class="text-center" colspan="7">
                            <a class="btn btn-primary btn-sm" href="#" onclick="return saveNewIndikatorKinerja();">
                                <i class="fa fa-plus"></i>
                                Tambah Indikator Kinerja
                            </a>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal effect-sign" id="modalIndikatorKinerja" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Indikator Kinerja Individual</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Test Modal</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.penilaian_prestasi_kerja.edit.scripts.form')
@endsection
