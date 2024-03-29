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
                              <td style="width: 80px;" colspan="2">
                                    @component('components.form.awesomeSelect', [
                                      'name' => 'bulan',
                                      'disabled' => 'disabled',
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

                              </td>
                          </tr>

                          <tr>
                              <td style="width: 80px;" colspan="2">
                                    <select class="form-control form-select" disabled="disabled">
                                        <option>-= Pilih Tahun =-</option>
                                        @for ($i= date('Y'); $i >= 2022; $i--)
                                        <option value="{{$i}}" {{ $i == $data->tahun ? 'selected=selected' : '' }}>
                                            {{$i}}
                                        </option>
                                        @endfor
                                    </select>
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
                          <?php $total_nilai_kinerja = 0; ?>
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
                                    {{$val->bobot}}
                              </td>
                              <td align="center">
                                    {{$val->target}}
                              </td>
                              <td align="center">
                                    {{ $val->realisasi }}
                              </td>
                              <td align="center">
                                    {{ $val->capaian }}
                              </td>
                              <td align="center">
                                    {{ $val->nilai_kinerja }}
                              </td>
                              <td class="text-center">
                              </td>
                          </tr>
                          @endforeach

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

                          <?php $total_nilai_kualitas = 0; ?>
                          @foreach ($data->penilaian_kualitas as $key => $val)
                          <?php $total_nilai_kualitas += $val->nilai_kinerja; ?>
                          <tr>
                              <td class="text-center">
                                  {{$key + 1}}
                              </td>
                              <td>
                                  {{!empty($val->indikator_tetap->name) ? $val->indikator_tetap->name : ''}}
                              </td>
                              <td align="center">
                                  <input type="text" id="bobot_{{ $val->id }}" name="bobot" class="form-control text-center" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td align="center">
                                  <input type="text" id="target_{{ $val->id }}" name="target" class="form-control text-center" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td align="center">
                                  <input type="text" id="realisasi_{{ $val->id }}" name="realisasi" class="form-control text-center" value="{{ $val->realisasi }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td align="center">
                                  <input type="text" id="capaian_{{ $val->id }}" name="capaian" class="form-control text-center" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;" disabled>
                              </td>
                              <td align="center">
                                  <input type="text" id="nilai_kinerja_{{ $val->id }}" name="nilai_kinerja" class="form-control text-center" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;"  disabled>
                              </td>
                              <td class="text-center">
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
                          <tr>
                              <td class="text-center">
                                  {{$key + 1}}
                              </td>
                              <td>
                                  {{!empty($val->indikator_tetap->name) ? $val->indikator_tetap->name : ''}}
                              </td>
                              <td align="center">
                                  <input type="text" id="bobot_{{ $val->id }}" name="bobot" class="form-control text-center" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td align="center">
                                  <input type="text" id="target_{{ $val->id }}" name="target" class="form-control text-center" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td align="center">
                                  <input type="text" id="realisasi_{{ $val->id }}" name="realisasi" class="form-control text-center" value="{{ $val->realisasi }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;">
                              </td>
                              <td align="center">
                                  <input type="text" id="capaian_{{ $val->id }}" name="capaian" class="form-control text-center" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;"  disabled>
                              </td>
                              <td align="center">
                                  <input type="text" id="nilai_kinerja_{{ $val->id }}" name="nilai_kinerja" class="form-control text-center" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="width: 80px;"  disabled>
                              </td>
                              <td class="text-center">
                              </td>
                          </tr>
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

                          <?php $total_nilai_kinerja = 0; ?>
                          @foreach ($data->penilaian_tambahan as $key => $val)
                          <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
                          <tr>
                              <td class="text-center">
                                  {{ $key+1 }}
                              </td>
                              <td align="center">
                                  {{ $val->indikator_kinerja_text }}
                              </td>
                              <td align="center">
                                  {{ $val->bobot }}
                              </td>
                              <td align="center">
                                  {{ $val->target }}
                              </td>
                              <td align="center">
                                  {{ $val->realisasi }}
                              </td>
                              <td align="center">
                                  {{ $val->capaian }}
                              </td>
                              <td align="center">
                                  {{ $val->nilai_kinerja }}
                              </td>
                              <td class="text-center">
                              </td>
                          </tr>
                          @endforeach

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


                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('formValidationScript')
@include('app.penilaian_perilaku_kerja.edit.scripts.form')
@endsection
