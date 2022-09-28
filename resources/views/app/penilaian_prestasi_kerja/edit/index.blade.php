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

<?php



$can_edit = false;
// jika yang login belum mengapprove
if (empty($data->penilaian_prestasi_kerja_my_approval)) {
  $can_edit = true;
}


if (!empty($data->penilaian_prestasi_kerja_my_approval)) {
  if ($data->penilaian_prestasi_kerja_my_approval->status == '4') {
      $can_edit = true;
  }
}

if (!empty($user_atasan_penilai) && $user_atasan_penilai->id == MyAccount()->id) {
  $can_edit = false;
}


?>

<!-- ROW-1 -->
<div class="row">
    <div class="col-12">
        <div class="card overflow-scrolln">
            <div class="card-body">

                <div class="table-responsive">
                   <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                      <table class="table table-bordered table-sm">

                          <tr>
                              <td style="width: 80px;" colspan="2">
                                    @if ($can_edit)
                                        @component('components.form.awesomeSelect', [
                                          'name' => 'bulan',
                                          'onChange' => 'saveUpdate(this)',
                                          'items' => [[
                                              'label' => '-= Bulan =-',
                                              'value' => ''
                                          ],[
                                              'label' => 'Januari',
                                              'value' => '1'
                                          ],[
                                              'label' => 'Februari',
                                              'value' => '2'
                                          ],[
                                              'label' => 'Maret',
                                              'value' => '3'
                                          ],[
                                              'label' => 'April',
                                              'value' => '4'
                                          ],[
                                              'label' => 'Mei',
                                              'value' => '5'
                                          ],[
                                              'label' => 'Juni',
                                              'value' => '6'
                                          ],[
                                              'label' => 'Juli',
                                              'value' => '7'
                                          ],[
                                              'label' => 'Agustus',
                                              'value' => '8'
                                          ],[
                                              'label' => 'September',
                                              'value' => '9'
                                          ],[
                                              'label' => 'Oktober',
                                              'value' => '10'
                                          ],[
                                              'label' => 'November',
                                              'value' => '11'
                                          ],[
                                              'label' => 'Desember',
                                              'value' => '12'
                                          ]],
                                          'selected' => $data->bulan
                                      ])
                                      @endcomponent
                                  @else
                                      Bulan : {{ monthIndo($data->bulan) }}
                                  @endif
                              </td>
                          </tr>

                          <tr>
                              <td style="width: 80px;" colspan="2">
                                    @if ($can_edit)
                                        <select class="form-control form-select" disabled="disabled">
                                            <option>-= Pilih Tahun =-</option>
                                            @for ($i= date('Y'); $i >= 2022; $i--)
                                            <option value="{{$i}}" {{ $i == $data->tahun ? 'selected=selected' : '' }}>
                                                {{$i}}
                                            </option>
                                            @endfor
                                        </select>
                                    @else
                                        Tahun : {{ $data->tahun }}
                                    @endif
                              </td>
                          </tr>

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
                                  {{ !empty($data->unit_kerja->name) ? $data->unit_kerja->name : '' }}
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  Nip
                              </td>
                              <td colspan=3>
                                  {{ $data->user->nip }}
                              </td>
                              <td>
                                  Jabatan
                              </td>
                              <td colspan=3>
                                  @if (!empty($data->jabatan->is_staff) && $data->jabatan->is_staff)
                                  {{ !empty($data->jabatan_fungsional->name) ? $data->jabatan_fungsional->name : '' }}
                                  @else
                                  {{ !empty($data->jabatan->name) ? $data->jabatan->name : '' }}
                                  @endif
                              </td>
                          </tr>


                          <tr>
                              <th class="text-center" colspan="8">
                                <br>
                              </th>
                          </tr>


                          <tr>
                              <th class="text-center" colspan="8">
                                  1. Indikator Sasaran Kinerja Pegawai (70%)
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center" colspan="8">
                                  Kinerja Utama
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center" colspan="8">
                                  Indikator Kuantitas Kerja (40%)
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
                                  <a href="#" onclick="return openModalDetailRealisasiAtasan();">Realisasi</a>
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
                          <?php $total_nilai_kinerja = 0;
                          ?>
                          @foreach ($data->penilaian_prestasi_kerja_item as $key => $val)
                          <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
                          <tr>
                              <td class="text-center">
                                  {{$key + 1}}
                              </td>
                              <td>
                                  {{!empty($val->indikator_kinerja->name) ? $val->indikator_kinerja->name : ''}}
                              </td>
                              <td align="center">
                                    @if ($can_edit)
                                    <input type="text" name="bobot" class="form-control" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;text-align:center;">
                                    @else
                                    {{ $val->bobot }}
                                    @endif
                              </td>
                              <td align="center">
                                    @if ($can_edit)
                                        <input type="text" name="target" class="form-control" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;text-align:center;">
                                    @else
                                        {{ $val->target }}
                                    @endif
                              </td>
                              <td align="center">
                                    @if ($can_edit)
                                        <input type="text" name="realisasi" class="form-control" value="{{ $val->realisasi }}" disabled="disabled" data-id="{{ $val->id }}" style="width: 80px;text-align:center;">
                                    @else
                                        {{ $val->realisasi_approved }}
                                    @endif
                              </td>
                              <td align="center">
                                    @if ($can_edit)
                                        <input type="text" name="capaian" id="capaian_{{$val->id}}" class="form-control" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;text-align:center;" disabled>
                                    @else
                                        {{ $val->capaian }}
                                    @endif
                              </td>
                              <td align="center">
                                    @if ($can_edit)
                                        <input type="text" name="nilai_kinerja" id="nilai_kinerja_{{$val->id}}" class="form-control" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;text-align:center;" disabled>
                                    @else
                                        {{ $val->nilai_kinerja }}
                                    @endif
                              </td>
                              <td class="text-center">
                                    @if ($can_edit)
                                        <a class="btn btn-danger btn-sm" href="#" onclick="return remove('{{ $val->id }}','{{!empty($val->indikator_kinerja->name) ? $val->indikator_kinerja->name : ''}}')"><i class="fa fa-trash"></i></a>
                                    @else

                                    @endif
                              </td>
                          </tr>
                          @endforeach
                          @if ($can_edit)
                          <tr>
                              <td class="text-left" colspan="8">
                                  <a class="btn btn-primary btn-sm" href="#" onclick="return openModalIndikatorKinerja();">
                                      <i class="fa fa-plus"></i>
                                      Tambah Indikator Kinerja
                                  </a>
                              </td>
                          </tr>
                          @endif
                          <tr>
                              <td class="text-center" colspan="6">
                                  Capaian kinerja utama Indikator Kuantitas
                              </td>
                              <td class="text-center">
                                {{$total_nilai_kinerja}}
                              </td>
                              <td class="text-center">

                              </td>
                          </tr>
                          <?php $total_nilai_kinerja_utama =  $total_nilai_kinerja; ?>



                          <tr>
                              <th class="text-center" colspan="8">
                                  <br />
                              </th>
                          </tr>


                          <tr>
                              <th class="text-center" colspan="8">
                                  Indikator Kualitas Kerja (30%)
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

                          <?php $total_nilai_kualitas = 0;

                          // cetak($data->penilaian_kualitas->toArray());
                          // die();


                          ?>



                          @foreach ($data->penilaian_kualitas as $key => $val)
                          <?php $total_nilai_kualitas += $val->nilai_kinerja;

                          ?>
                          <tr>
                              <td class="text-center">
                                  {{$key + 1}}
                              </td>
                              <td>
                                  {{!empty($val->indikator_tetap->name) ? $val->indikator_tetap->name : ''}}
                              </td>
                              <td class="text-center">
                                  @if ($can_edit)
                                  <input type="text" id="bobot_{{ $val->id }}" name="bobot" class="form-control text-center" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                  @else
                                  {{ $val->bobot }}
                                  @endif
                              </td>
                              <td class="text-center">
                                  @if ($can_edit)
                                  <input type="text" id="target_{{ $val->id }}" name="target" class="form-control text-center" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                  @else
                                  {{ $val->target }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                      @if ($data->user_id == MyAccount()->id)
                                          @if (count($val->indikator_tetap->indikator_tetap_dasar_nilai) == 0)
                                            <input type="text" id="realisasi_{{ $val->id }}" name="realisasi" class="form-control text-center" value="{{ $val->realisasi }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                          @else
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                <span id="realisasi_{{ $val->id }}">{{ $val->realisasi ? $val->realisasi : 'Nilai' }}</span> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li class="dropdown-plus-title">
                                                    Pilih salah satu
                                                </li>
                                                @foreach ($val->indikator_tetap->indikator_tetap_dasar_nilai as $key2 => $val2)
                                                <li><a href="#" onclick="return saveSKPIndikatorTetap('{{$val->id}}','{{$val2->nilai}}')" style="width:500px;white-space: normal !important;">Nilai <b style="color:black;">{{$val2->nilai}}</b>) {{ $val2->name }}</a></li>
                                                @endforeach
                                            </ul>
                                          @endif
                                      @else
                                          @if (count($val->indikator_tetap->indikator_tetap_dasar_nilai) == 0)
                                            <input type="text" id="realisasi_approved_{{ $val->id }}" name="realisasi_approved" class="form-control text-center" value="{{ $val->realisasi_approved }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                          @else
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                <span id="realisasi_approved_{{ $val->id }}">{{ $val->realisasi_approved ? $val->realisasi_approved : 'Nilai' }}</span> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li class="dropdown-plus-title">
                                                    Pilih salah satu
                                                </li>
                                                @foreach ($val->indikator_tetap->indikator_tetap_dasar_nilai as $key2 => $val2)
                                                <li><a href="#" onclick="return saveSKPIndikatorTetapApproved('{{$val->id}}','{{$val2->nilai}}')" style="width:500px;white-space: normal !important;">Nilai <b style="color:black;">{{$val2->nilai}}</b>) {{ $val2->name }}</a></li>
                                                @endforeach
                                            </ul>
                                          @endif
                                      @endif
                                  @else
                                      {{$val->realisasi_approved}}
                                  @endif
                              </td>
                              <td class="text-center">
                                  @if ($can_edit)
                                      <input type="text" id="capaian_{{ $val->id }}" name="capaian" class="form-control text-center" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;"  disabled>
                                  @else
                                      {{ $val->capaian }}
                                  @endif
                              </td>
                              <td class="text-center">
                                  @if ($can_edit)
                                      <input type="text" id="nilai_kinerja_{{ $val->id }}" name="nilai_kinerja" class="form-control text-center" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;"  disabled>
                                  @else
                                      {{ $val->nilai_kinerja }}
                                  @endif
                              </td>
                          </tr>
                          @endforeach

                          <tr>
                              <td class="text-center" colspan="6">
                                  Capaian kinerja utama Indikator Kualitas
                              </td>
                              <td class="text-center">
                                {{$total_nilai_kualitas}}
                              </td>
                              <td class="text-center">

                              </td>
                          </tr>
                          <?php $total_nilai_kinerja_utama +=  $total_nilai_kualitas; ?>


                          <tr>
                              <td class="text-center" colspan="6">
                                  Jumlah Capaian kinerja utama
                              </td>
                              <td class="text-center">
                                {{$total_nilai_kinerja_utama}}
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

                          <?php $total_nilai_kinerja = 0; ?>
                          @foreach ($data->penilaian_perilaku_kerja as $key => $val)
                          <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
                          @if (!empty($data->jabatan->is_staff) && $data->jabatan->is_staff == 1 && $val->indikator_tetap->name == 'Kepemimpinan')

                          @else
                              <tr>
                                  <td class="text-center">
                                      {{$key + 1}}
                                  </td>
                                  <td>
                                      {{!empty($val->indikator_tetap->name) ? $val->indikator_tetap->name : ''}}
                                  </td>
                                  <td align="center">
                                      @if ($can_edit)
                                          <input type="text" id="bobot_{{ $val->id }}" name="bobot" class="form-control text-center" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                      @else
                                          {{ $val->bobot }}
                                      @endif
                                  </td>
                                  <td align="center">
                                      @if ($can_edit)
                                          <input type="text" id="target_{{ $val->id }}" name="target" class="form-control text-center" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                      @else
                                          {{ $val->target }}
                                      @endif
                                  </td>
                                  <td align="center">
                                      @if ($can_edit)
                                          @if ($data->user_id == MyAccount()->id)
                                              @if (count($val->indikator_tetap->indikator_tetap_dasar_nilai) == 0)
                                                <input type="text" id="realisasi_{{ $val->id }}" name="realisasi" class="form-control text-center" value="{{ $val->realisasi }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                              @else
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                    <span id="realisasi_{{ $val->id }}">{{ $val->realisasi ? $val->realisasi : 'Nilai' }}</span> <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="dropdown-plus-title">
                                                        Pilih salah satu
                                                    </li>
                                                    @foreach ($val->indikator_tetap->indikator_tetap_dasar_nilai as $key2 => $val2)
                                                    <li><a href="#" onclick="return saveSKPIndikatorTetap('{{$val->id}}','{{$val2->nilai}}')" style="width:500px;white-space: normal !important;">Nilai <b style="color:black;">{{$val2->nilai}}</b>) {{ $val2->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                              @endif
                                          @else
                                              @if (count($val->indikator_tetap->indikator_tetap_dasar_nilai) == 0)
                                                <input type="text" id="realisasi_approved_{{ $val->id }}" name="realisasi_approved" class="form-control text-center" value="{{ $val->realisasi_approved }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                              @else
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                    <span id="realisasi_approved_{{ $val->id }}">{{ $val->realisasi_approved ? $val->realisasi_approved : 'Nilai' }}</span> <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="dropdown-plus-title">
                                                        Pilih salah satu
                                                    </li>
                                                    @foreach ($val->indikator_tetap->indikator_tetap_dasar_nilai as $key2 => $val2)
                                                    <li><a href="#" onclick="return saveSKPIndikatorTetapApproved('{{$val->id}}','{{$val2->nilai}}')" style="width:500px;white-space: normal !important;">Nilai <b style="color:black;">{{$val2->nilai}}</b>) {{ $val2->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                              @endif
                                          @endif
                                      @else
                                          {{ $val->realisasi_approved }}
                                      @endif
                                  </td>
                                  <td align="center">
                                      @if ($can_edit)
                                          <input type="text" id="capaian_{{ $val->id }}" name="capaian" class="form-control text-center" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;"  disabled>
                                      @else
                                          {{ $val->capaian }}
                                      @endif
                                  </td>
                                  <td align="center">
                                      @if ($can_edit)
                                          <input type="text" id="nilai_kinerja_{{ $val->id }}" name="nilai_kinerja" class="form-control text-center" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;"  disabled>
                                      @else
                                          {{ $val->nilai_kinerja }}
                                      @endif
                                  </td>
                                  <td class="text-center">
                                  </td>
                              </tr>
                          @endif
                          @endforeach

                          <tr>
                              <td class="text-center" colspan="6">
                                  Jumlah nilai indikator perilaku
                              </td>
                              <td class="text-center">
                                {{$total_nilai_kinerja}}
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
                                  3. Kinerja Tambahan (Maksimal 5%)
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

                          <?php $total_nilai_kinerja = 0; ?>
                          @foreach ($data->penilaian_tambahan as $key => $val)
                          <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
                          <tr>
                              <td class="text-center">
                                  {{ $key+1 }}
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" id="indikator_kinerja_text_{{ $val->id }}" name="indikator_kinerja_text" class="form-control" value="{{ $val->indikator_kinerja_text }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}">
                                  @else
                                  {{ $val->indikator_kinerja_text }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" id="bobot_{{ $val->id }}" name="bobot" class="form-control text-center" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                  @else
                                  {{ $val->bobot }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" id="target_{{ $val->id }}" name="target" class="form-control text-center" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                  @else
                                  {{ $val->target }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" id="realisasi_{{ $val->id }}" name="realisasi" class="form-control text-center" value="{{ $val->realisasi }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                                  @else
                                  {{ $val->realisasi }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" id="capaian_{{ $val->id }}" name="capaian" class="form-control text-center" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;" disabled>
                                  @else
                                  {{ $val->capaian }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" id="nilai_kinerja_{{ $val->id }}" name="nilai_kinerja" class="form-control text-center" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;" disabled>
                                  @else
                                  {{ $val->nilai_kinerja }}
                                  @endif
                              </td>
                              <td class="text-center">
                                  @if ($can_edit)
                                  <a class="btn btn-danger btn-sm" href="#" onclick="return remove('{{ $val->id }}','{{!empty($val->indikator_kinerja->name) ? $val->indikator_kinerja->name : ''}}')"><i class="fa fa-trash"></i></a>
                                  @else
                                  @endif
                              </td>
                          </tr>
                          @endforeach


                          <tr>
                              <th class="text-center" colspan="8">
                                  <br><br>
                              </th>
                          </tr>
                          <tr>
                              <th class="text-center" colspan="8">
                                  INDEKS KINERJA UNIT (IKU)
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
                                  Target
                              </th>
                              <th class="text-center">
                                  Realisasi
                              </th>
                              <th class="text-center" colspan="2">
                                  Capaian Unit
                              </th>
                              <th class="text-center">
                                  Nilai Kinerja
                              </th>
                          </tr>

                          <tr>
                              <td class="text-center" colspan="2">
                                  Indeks Kinerja Unit (IKU)
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" name="target" class="form-control text-center" value="{{ $data->penilaian_iku->target }}" data-id="{{ $data->penilaian_iku->id }}" onChange="savePeilaianIku(this)"  style="width: 80px;">
                                  @else
                                  {{ $data->penilaian_iku->target }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" name="realisasi" class="form-control text-center" value="{{ $data->penilaian_iku->realisasi }}" data-id="{{ $data->penilaian_iku->id }}" onChange="savePeilaianIku(this)"  style="width: 80px;">
                                  @else
                                  {{ $data->penilaian_iku->realisasi }}
                                  @endif
                              </td>
                              <td align="center" colspan="2">
                                  @if ($can_edit)
                                  <input type="text" name="capaian_unit" class="form-control text-center" value="{{ $data->penilaian_iku->capaian_unit }}" data-id="{{ $data->penilaian_iku->id }}" onChange="savePeilaianIku(this)"  style="width: 80px;">
                                  @else
                                  {{ $data->penilaian_iku->capaian_unit }}
                                  @endif
                              </td>
                              <td align="center">
                                  @if ($can_edit)
                                  <input type="text" name="iku" class="form-control text-center" value="{{ $data->penilaian_iku->iku }}" data-id="{{ $data->penilaian_iku->id }}" onChange="savePeilaianIku(this)"  style="width: 80px;">
                                  @else
                                  {{ $data->penilaian_iku->iku }}
                                  @endif
                              </td>
                              <td class="text-center">

                              </td>
                          </tr>



                          <tr>
                              <td class="text-center" colspan="6">
                                  Jumlah nilai kegiatan tambahan
                              </td>
                              <td class="text-center">
                                {{$total_nilai_kinerja}}
                              </td>
                              <td class="text-center">
                              </td>
                          </tr>
                          <tr>
                              <th class="text-center" colspan="8">
                                <br>
                              </th>
                          </tr>

                          <tr>
                              <th class="text-center" colspan="8">
                                  Catatan
                              </th>
                          </tr>

                          <tr>
                              <td colspan="8">
                                  @if ($can_edit)
                                  <textarea class="form-control" name="catatan" placeholder="Inputkan catatan di sini..." onchange="saveUpdate(this)">{{ $data->catatan }}</textarea>
                                  @else
                                  {{ $data->catatan }}
                                  @endif
                              </td>
                          </tr>
                      </table>

                    </div>
                </div>
                @if (!empty($jabatan->is_staff) && $jabatan->is_staff == 1)
                @else
                  <a href="/penilaian_prestasi_kerja/id/{{$data['id']}}" class="btn btn-primary btn-sm pull-right" >
                      Buat Progrem & Kegiatan
                      <i class="fa fa-angle-right"></i>
                  </a>
                @endif
            </div>


            @if (false)
            <div class="card-body">
                <h4>Upload Penilaian Prestasi Kerja yang telah ditandatangani (PDF)</h4>
                <input type="file" onchange="prepareUpload(this, 'foto_penilaian_prestasi_kerja', '{{ $data->id }}', false, ['pdf']);" multiple>
                <div style="clear: both;"></div>
                <div class="img-preview mt-2" id="img-preview">
                    @if (!empty($data->foto_penilaian_prestasi_kerja))
                    @foreach ($data->foto_penilaian_prestasi_kerja as $key => $val2)
                    <a href="/api/preview/{{$val2->storage->key}}">
                        <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                    </a>
                    @endforeach
                    @endif
                    <div style="clear: both;"></div>
                </div>
                <div style="clear: both;"></div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card overflow-scrolln">
            <div class="card-body text-center">
                @if (empty($data->penilaian_prestasi_kerja_my_approval) || (!empty($data->penilaian_prestasi_kerja_my_approval) && in_array($data->penilaian_prestasi_kerja_my_approval->status, ['4','5'])) )
                  @if (MyAccount()->id != $data->user_id)
                  <a class="btn btn-danger btn-lg text-white" onClick="tolak()"><i class="fa fa-times"></i>
                    Tolak
                  </a>
                  @endif

                  @if (MyAccount()->id == $data->user_id)

                      @if (!empty($data->penilaian_prestasi_kerja_my_approval) && in_array($data->penilaian_prestasi_kerja_my_approval->status, ['4']))
                      <a class="btn btn-primary btn-lg" onClick="approve()"><i class="fa fa-telegram"></i>
                        Kirim Perbaikan
                      </a>
                      @else
                      <a class="btn btn-primary btn-lg" onClick="approve()"><i class="fa fa-telegram"></i>
                        Kirim
                      </a>
                      @endif


                  @else
                  <a class="btn btn-primary btn-lg" onClick="approve()"><i class="fa fa-telegram"></i>
                      Setujui
                  </a>
                  @endif
                @endif
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card overflow-scrolln">
            <div class="card-body text-center">
                <h4>Riwayat Penolakan</h4>



                <table class="table table-bordered table-sm">
                    <tr>
                        <th style="width: 15%;">
                          Nama
                        </th>
                        <th style="width: 15%;">
                          Unit Kerja
                        </th>
                        <th style="width: 15%;">
                          Jabatan
                        </th>
                        <th style="width: 55%;">
                          Notes Reject
                        </th>
                    </tr>

                    @foreach($data->penilaian_prestasi_kerja_reject as $key => $value)
                    <tr>
                        <td>
                          {{ $value->user->name }}
                        </td>
                        <td>
                          {{ $value->user->unit_kerja->name }}
                        </td>
                        <td>
                          {{ $value->user->jabatan->name }}
                        </td>
                        <td>
                          {{ $value->notes }}
                        </td>
                    </tr>
                    @endforeach

                </table>
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
                                {!! treeChildIndikatorKinerjaModal($indikator_kinerja, '', '', 0, $indikator_kerja_ids, $tipe_indikator_ditampilkan, $data) !!}
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


<div class="modal effect-sign" id="modalTolak" role="dialog">
    <div class="modal-dialog modal-md " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alasan Ditolak</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-sasaran-kinerja">
                <textarea class="form-control" name="catatan_penolakan" placeholder="Tulis alasan penolakan..."></textarea>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger btn-sm text-white" onClick="saveTolak()"><i class="fa fa-times"></i>
                  Tolak
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal effect-sign" id="modalDetailRealisasiAtasan" role="dialog">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="body-modal-sasaran-kinerja">
              <table class="table table-bordered table-sm">
              @foreach ($realisasi as $key => $val)
                <tr>
                  <?php for ($i=0; $i < $val['level']; $i++): ?>
                    <td style="width:10%;"></td>
                  <?php endfor; ?>

                  <td style="width:10%;">
                    {{  $val['indikator_kinerja']->name }}
                  </td>
                  <td style="width:10%;">
                    {{ round($val['value'], 2)}}
                  </td>
                </tr>
              @endforeach
              </table>
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
