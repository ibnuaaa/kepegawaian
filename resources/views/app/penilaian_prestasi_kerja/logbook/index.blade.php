@extends('layout.app')

@section('title', 'PenilaianPrestasiKerja '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Logbook</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/penilaian_prestasi_kerja">Penilaian</a></li>
            <li class="breadcrumb-item active" aria-current="page">Logbook</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="card card-default m-t-20">
            <div class="card-body">





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
                            {{ !empty($data->jabatan->name) ? $data->jabatan->name : '' }}
                        </td>
                    </tr>
                </table>





              <div class="table-responsive">
                  <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">



                      <table class="table table-bordered table-condensed-custom table-striped">
                            <tr>
                                <th style="min-width: 300px;">
                                    Nama Kegiatan
                                </th>
                                @for ($i= 0; $i < $num_days; $i++)
                                <th class="text-center">
                                    {{ $i+1 }}
                                </th>
                                @endfor
                                <th class="text-center">
                                    Total
                                </th>
                            </tr>

                            @foreach ($data->penilaian_prestasi_kerja_item as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->indikator_kinerja->name }}
                                    </td>
                                    @for ($i= 0; $i < $num_days; $i++)
                                    <td>
                                        <input type="text" class="form-control" value="{{ !empty($nilai[$value->indikator_kinerja_id][$i+1]) ? $nilai[$value->indikator_kinerja_id][$i+1] : '' }}" style="width: 60px; text-align:center;" onchange="saveLogbook(this, '{{ $value->indikator_kinerja_id }}', '{{ $i + 1 }}')">
                                    </td>
                                    @endfor
                                    <td id="total_{{ $value->indikator_kinerja_id }}" class="text-center" style="padding-top: 10px !important;">
                                      {{$value->realisasi}}
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

@section('formValidationScript')
@include('app.penilaian_prestasi_kerja.logbook.scripts.form')
@endsection
