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

                            </td>
                            <td colspan="3">
                              NAMA
                            </td>
                            <td colspan="4">

                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              NIP
                            </td>
                            <td colspan="3">

                            </td>
                            <td colspan="3">
                              NIP
                            </td>
                            <td colspan="4">

                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              PANGKAT/GOL RUANG
                            </td>
                            <td colspan="3">

                            </td>
                            <td colspan="3">
                              PANGKAT/GOL RUANG
                            </td>
                            <td colspan="4">

                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              JABATAN
                            </td>
                            <td colspan="3">

                            </td>
                            <td colspan="3">
                              JABATAN
                            </td>
                            <td colspan="4">

                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              UNIT KERJA
                            </td>
                            <td colspan="3">

                            </td>
                            <td colspan="3">
                              UNIT KERJA
                            </td>
                            <td colspan="4">

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

                            <?php $parent_id = 0; ?>
                            @foreach ($data as $key => $value)
                              <tr>
                                <td class="text-center">
                                  {{ $key+1 }}
                                </td>
                                <td colspan="2">

                                  @if (empty($parent_id) || (!empty($value->indikator_kinerja->parents->parents->id) && !empty($parent_id) && $parent_id != $value->indikator_kinerja->parents->parents->id))
                                  {{ !empty($value->indikator_kinerja->parents->parents->name) ? $value->indikator_kinerja->parents->parents->name : '' }}
                                  @endif
                                  <?php if (!empty($value->indikator_kinerja->parents->parents->id)) $parent_id = $value->indikator_kinerja->parents->parents->id; ?>

                                </td>
                                <td>
                                  {{ !empty($value->indikator_kinerja->name) ? $value->indikator_kinerja->name : '' }}
                                </td>
                                <td colspan="2" class="text-center">
                                  {{ !empty($value->target) ? $value->target : '' }}
                                </td>
                                <td class="text-center">
                                  {{ !empty($value->realisasi) ? $value->realisasi : '' }}
                                </td>
                                <td colspan="2" class="text-center">
                                  {{ !empty($value->capaian) ? $value->capaian : '' }}
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
