@extends('layout.app')

@section('title', 'PenilaianPrestasiKerja')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Penilaian</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/penilaian_prestasi_kerja">Penilaian</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit </li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-12">
        <div class="card overflow-scrolln">
            <div class="card-body">


                <div class="table-responsive">
                   <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">


                      <table class="table table-bordered table-sm">

                          <tr>
                              <th class="text-center" colspan="8">
                                  Identitas Pegawai
                              </th>
                          </tr>


                          <tr>
                              <td>
                                  Nama
                              </td>
                              <td colspan=3>
                                  {{ $data->user->name }}
                              </td>
                              <td>
                                  Unit Kerja
                              </td>
                              <td colspan=3>
                                  {{ $data->user->unit_kerja->name }}
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Nip
                              </td>
                              <td colspan=3>
                                  {{ $data->user->jabatan->name }}
                              </td>
                              <td>
                                  Jabatan
                              </td>
                              <td colspan=3>
                                  {{ $data->user->nip }}
                              </td>
                          </tr>


                          <tr>
                              <th class="text-center" colspan="8">
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center" colspan="8">
                                  1. Indikator Sasaran Kinerja Pegawai (70%)
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center">
                                  No
                              </th>
                              <th class="text-center" style="min-width: 200px;">
                                  Indikator Kinerja Utama
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
                              <th class="text-center">
                                  Aksi
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
                              <th>

                              </th>
                          </tr>
                          @foreach ($data->penilaian_prestasi_kerja_item as $key => $val)
                          <tr>
                              <td class="text-center">
                                  {{$key + 1}}
                              </td>
                              <td>
                                  {{!empty($val->indikator_kinerja->name) ? $val->indikator_kinerja->name : ''}}
                              </td>
                              <td>
                                  <input type="text" name="bobot" class="form-control" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="target" class="form-control" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="realisasi" class="form-control" value="{{ $val->realisasi }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="capaian" class="form-control" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="nilai_kinerja" class="form-control" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td class="text-center">
                                  <a class="btn btn-danger btn-sm" href="#" onclick="return remove('{{ $val->id }}','{{!empty($val->indikator_kinerja->name) ? $val->indikator_kinerja->name : ''}}')"><i class="fa fa-trash"></i></a>
                              </td>
                          </tr>
                          @endforeach
                          <tr>
                              <td class="text-left" colspan="8">
                                  <a class="btn btn-primary btn-sm" href="#" onclick="return openModalIndikatorKinerja();">
                                      <i class="fa fa-plus"></i>
                                      Tambah Indikator Kinerja
                                  </a>
                              </td>
                          </tr>

                          <tr>
                              <td class="text-center" colspan="2">
                                  Jumlah nilai indikator kinerja utama
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td class="text-center">
                              </td>
                          </tr>


                          <tr>
                              <th class="text-center" colspan="8">
                                  <br />
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center" colspan="8">
                                  2. Indikator Perilaku Kerja (30%)
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center">
                                  No
                              </th>
                              <th class="text-center" style="min-width: 200px;">
                                  Indikator
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


                          @foreach ($data->penilaian_perilaku_kerja as $key => $val)
                          <tr>
                              <td class="text-center">
                                  {{$key + 1}}
                              </td>
                              <td>
                                  {{!empty($val->perilaku_kerja->name) ? $val->perilaku_kerja->name : ''}}
                              </td>
                              <td class="text-center">
                                  {{ $val->bobot }}
                              </td>
                              <td class="text-center">
                                  {{ $val->target }}
                              </td>
                              <td class="text-center">
                                  {{ $val->realisasi }}
                              </td>
                              <td class="text-center">
                                  {{ $val->capaian }}
                              </td>
                              <td class="text-center">
                                  {{ $val->nilai_kinerja }}
                              </td>
                          </tr>
                          @endforeach



                          <tr>
                              <th class="text-center" colspan="8">
                                  <br />
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center" colspan="8">
                                  3. Kinerja Tambahan
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center">
                                  No
                              </th>
                              <th class="text-center" style="min-width: 200px;">
                                  Jenis & Nama Kegiatan
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

                          @foreach ($data->penilaian_tambahan as $key => $val)
                          <tr>
                              <td class="text-center">
                                  {{ $key+1 }}
                              </td>
                              <td>
                                  <input type="text" name="indikator_kinerja_text" class="form-control" value="{{ $val->indikator_kinerja_text }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" >
                              </td>
                              <td>
                                  <input type="text" name="bobot" class="form-control" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="target" class="form-control" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="realisasi" class="form-control" value="{{ $val->realisasi }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="capaian" class="form-control" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td>
                                  <input type="text" name="nilai_kinerja" class="form-control" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td class="text-center">
                                  <a class="btn btn-danger btn-sm" href="#" onclick="return remove('{{ $val->id }}','{{!empty($val->indikator_kinerja->name) ? $val->indikator_kinerja->name : ''}}')"><i class="fa fa-trash"></i></a>
                              </td>
                          </tr>
                          @endforeach
                          <tr>
                              <td class="text-left" colspan="7">
                                  <a class="btn btn-primary btn-sm" href="#" onclick="return saveNewIndikatorTambahan();">
                                      <i class="fa fa-plus"></i>
                                      Tambah Kegiatan
                                  </a>
                              </td>
                          </tr>

                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal effect-sign" id="modalIndikatorKinerja" role="dialog">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Indikator Kinerja Individual</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-sasaran-kinerja">
                <div class="table-responsive">
                   <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                        <table id="basic" class="table table-bordered table-condensed-custom">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th style="width: 50%;">INDIKATOR KINERJA</th>
                                    <th style="width: 40%;">UNIT KERJA</th>
                                    <th style="width: 120px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                {!! treeChildIndikatorKinerjaModal($indikator_kinerja, '', '', 0, $indikator_kerja_ids, $tipe_indikator_ditampilkan) !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.penilaian_prestasi_kerja.edit.scripts.form')
@endsection
