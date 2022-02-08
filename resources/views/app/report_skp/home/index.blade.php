@extends('layout.app')

@section('title', 'ReportSkp')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">ReportSkp
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">ReportSkp</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
      <div class="card">
          <div class="card-body">
              <div class="table-responsive">
                 <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                      <table class="table table-bordered table-condensed-custom">
                          <tr>
                              <td style="width: 25%;">
                                  Cari Pegawai
                              </td>
                              <td style="width: 25%;">
                                  <select name="user_id" class="form-control form-select" >
                                      @if (!empty($user->id))
                                      <option value="{{ $user->id }}">{{ $user->name }}<option>
                                      @else
                                      <option value="">-= Pilih Pegawai =-<option>
                                      @endif
                                  </select>
                              </td>
                              <td style="width: 25%;">
                                  Dari Bulan
                              </td>
                              <td style="width: 25%;">
                                <select name="dari_bulan" class="form-control">
                                    <option value="">-= Pilih Bulan =-</option>
                                    @foreach (listMonth() as $key => $value)
                                        <option {{ !empty($dari_bulan) && $dari_bulan == $key ? 'selected="selected"' : '' }} value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                Tahun
                              </td>
                              <td>
                                <select name="tahun" class="form-control form-select">
                                    <option value="2022">2022</option>
                                </select>
                              </td>
                              <td style="width: 25%;">
                                  Sampai Bulan
                              </td>
                              <td style="width: 25%;">
                                  <select name="sampai_bulan" class="form-control">
                                      <option value="">-= Pilih Bulan =-</option>
                                      @foreach (listMonth() as $key => $value)
                                          <option {{ !empty($sampai_bulan) && $sampai_bulan == $key ? 'selected="selected"' : '' }} value="{{$key}}">{{$value}}</option>
                                      @endforeach
                                  </select>
                              </td>
                          </tr>
                          <tr>
                              <td>
                              </td>
                              <td>
                                  <a href="#" class="btn btn-primary btn-sm" onclick="return cari()">
                                      <i class="fa fa-search"></i>
                                      Cari
                                  </a>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                          </tr>
                      </table>

                      <table class="table table-bordered table-condensed-custom" style="width: 1500px;">
                          <tr>
                              <td colspan="13" class="text-center">
                                  PENILAIAN SKP PEJABAT PIMPINAN TINGGI DAN PIMPINAN UNIT KERJA MANDIRI
                              </td>
                          </tr>
                          <tr>
                            <td colspan="6" class="text-center">
                              Nama Instansi
                            </td>
                            <td colspan="7" class="text-center">
                              PERIODE PENILAIAN : JULI s.d DESEMBER
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6" class="text-center">
                              TAHUN
                            </td>
                            <td colspan="7" class="text-center">

                            </td>
                          </tr>



                          <tr>
                            <td colspan="6" class="text-center">
                              PEGAWAI YANG DINILAI
                            </td>
                            <td colspan="7" class="text-center">
                              PEJABAT PENILAI KINERJA
                            </td>
                          </tr>

                          <tr>
                            <td colspan="3">
                              NAMA
                            </td>
                            <td colspan="3">
                              {{ !empty($user->name) ? $user->name : '' }}
                            </td>
                            <td colspan="3">
                              NAMA
                            </td>
                            <td colspan="4">
                              {{ !empty($user_penilai->name) ? $user_penilai->name :'' }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              NIP
                            </td>
                            <td colspan="3">
                              {{ !empty($user->nip) ? $user->nip : '' }}
                            </td>
                            <td colspan="3">
                              NIP
                            </td>
                            <td colspan="4">
                              {{ !empty($user_penilai->nip) ? $user_penilai->nip : '' }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              PANGKAT/GOL RUANG
                            </td>
                            <td colspan="3">
                              @if (!empty($user->golongan))
                              {{ !empty($user->golongan->pangkat) ? $user->golongan->pangkat : '' }}
                              /
                              {{ !empty($user->golongan->golongan) ? $user->golongan->golongan : '' }}
                              @endif
                            </td>
                            <td colspan="3">
                              PANGKAT/GOL RUANG
                            </td>
                            <td colspan="4">
                              @if (!empty($user_penilai->golongan))
                              {{ !empty($user_penilai->golongan->pangkat) ? $user_penilai->golongan->pangkat : '' }}/{{ !empty($user_penilai->golongan->golongan) ? $user_penilai->golongan->golongan : '' }}
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              JABATAN
                            </td>
                            <td colspan="3">
                              @if (!empty($user->jabatan->is_staff) && $user->jabatan->is_staff)
                              {{ !empty($user->jabatan_fungsional->name) ? $user->jabatan_fungsional->name : '' }}
                              @else
                              {{ !empty($user->jabatan->name) ? $user->jabatan->name : '' }}
                              @endif

                            </td>
                            <td colspan="3">
                              JABATAN
                            </td>
                            <td colspan="4">
                              {{ !empty($user_penilai->jabatan->name) ? $user_penilai->jabatan->name : '' }}
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              UNIT KERJA
                            </td>
                            <td colspan="3">
                              {{ !empty($user->unit_kerja->name) ? $user->unit_kerja->name : '' }}
                            </td>
                            <td colspan="3">
                              UNIT KERJA
                            </td>
                            <td colspan="4">
                              {{ !empty($user_penilai->unit_kerja->name) ? $user_penilai->unit_kerja->name : ''  }}
                            </td>
                          </tr>

                          <tr>
                                <td class="text-center">
                                  NO
                                </td>
                                <td colspan="2" class="text-center">
                                  RENCANA KINERJA
                                </td>
                                <td class="text-center">
                                  INDIKATOR KINERJA INDIVIDU
                                </td>
                                <td colspan="2" class="text-center">
                                  TARGET
                                </td>
                                <td class="text-center">
                                  REALISASI
                                </td>
                                <td colspan="2" class="text-center">
                                  CAPAIAN IKI
                                </td>
                                <td class="text-center">
                                  KATEGORI CAPAIAN
                                </td>
                                <td class="text-center">
                                  NILAI CAPAIAN IKI
                                </td>
                                <td class="text-center">
                                  NILAI TERTIMBANG
                                </td>
                            </tr>

                            <tr>
                                <td class="text-center">
                                  (1)
                                </td>
                                <td colspan="2" class="text-center">
                                  (2)
                                </td>
                                <td class="text-center">
                                  (3)
                                </td>
                                <td colspan="2" class="text-center">
                                  (4)
                                </td>
                                <td class="text-center">
                                  (5)
                                </td>
                                <td colspan="2" class="text-center">
                                  (6)
                                </td>
                                <td class="text-center">
                                  (7)
                                </td>
                                <td class="text-center">
                                  (8)
                                </td>
                                <td class="text-center">
                                  (9)
                                </td>
                            </tr>

                            <?php $id_iku = 0; ?>
                            @foreach ($data as $key => $value)
                              <tr>
                                <td class="text-center">
                                  {{ $key+1 }}
                                </td>
                                <td colspan="2">
                                  @if ($value->id_iku != $id_iku)
                                  {{ !empty($value->nama_iku) ? $value->nama_iku : '' }}
                                  @endif
                                </td>
                                <td>
                                  {{ !empty($value->nama_iki) ? $value->nama_iki : '' }}
                                </td>
                                <td colspan="2" class="text-center">
                                  {{ !empty($value->target) ? $value->target : '' }}
                                </td>
                                <td class="text-center">
                                  {{ !empty($value->realisasi) ? $value->realisasi : '' }}
                                </td>
                                <td colspan="2" class="text-center">
                                  {{ !empty($value->capaian) ? ($value->capaian * 100) . '%' : '' }}
                                </td>
                                <td class="text-center">
                                  <?php

                                  $capaian = $value->capaian * 100;
                                  if ($capaian < 60 ) $kategori_capaian = 'SANGAT KURANG';
                                  else if ($capaian < 80 ) $kategori_capaian = 'KURANG';
                                  else if ($capaian < 100 ) $kategori_capaian = 'CUKUP';
                                  else if ($capaian == 100 ) $kategori_capaian = 'BAIK';
                                  else if ($capaian > 100 ) $kategori_capaian = 'SANGAT BAIK';
                                  ?>

                                  {{$kategori_capaian}}
                                </td>
                                <td class="text-center">
                                  <?php

                                    $capaian = $value->capaian * 100;
                                    if ($capaian < 60 ) $nilai_capaian = 25;
                                    else if ($capaian < 80 ) $nilai_capaian = 60;
                                    else if ($capaian < 100 ) $nilai_capaian = 80;
                                    else if ($capaian == 100 ) $nilai_capaian = 100;
                                    else if ($capaian > 100 ) $nilai_capaian = 120;
                                    ?>

                                    {{$nilai_capaian}}
                                </td>
                                <td class="text-center">

                                </td>
                            </tr>
                          <?php $id_iku = $value->id_iku; ?>
                          @endforeach
                      </table>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-1 END -->
</div>
@endsection

@section('script')
@include('app.report_skp.home.scripts.index')
@endsection
