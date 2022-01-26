@extends('layout.app')

@section('title', 'PenilaianPerilakuKerja')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Penilaian</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/penilaian_perilaku_kerja">Penilaian</a></li>
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
                          <th class="text-center" colspan="7">
                              Indikator Perilaku Kerja
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
                          <th class="text-center">
                              Aksi
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
@include('app.penilaian_perilaku_kerja.edit.scripts.form')
@endsection
