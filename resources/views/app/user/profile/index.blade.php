@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Profil User
      <a href="/profile/personal" class="btn btn-primary btn-sm">
          Ubah Profil
      </a>
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil User</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
      <div class="card overflow-hidden">
        <div class="card-body">








                  <div class="tab-menu-heading tab-menu-heading-boxed">
                      <div class="tabs-menu-boxed">
                          <ul class="nav panel-tabs">
                              <li><a href="#tab-personal" class="active" data-bs-toggle="tab">Personal</a></li>
                              <li><a href="#tab-pendidikan" data-bs-toggle="tab">Pendidikan</a></li>
                              <li><a href="#tab-pelatihan" data-bs-toggle="tab">Pelatihan</a></li>
                              <li><a href="#tab-keluarga" data-bs-toggle="tab">Keluarga</a></li>
                              <li><a href="#tab-jabatan" data-bs-toggle="tab">Riwayat Jabatan</a></li>
                              <li><a href="#tab-golongan" data-bs-toggle="tab">Riwayat Golongan</a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="panel-body tabs-menu-body">
                      <div class="tab-content">
                          <div class="tab-pane {{ $tab == 'personal' ? 'active' : '' }}" id="tab-personal">

                              <h2>Personal</h2>

                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Nama</label>
                                  <div class="col-md-9">
                                      {{ $data['name'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Username</label>
                                  <div class="col-md-9">
                                      {{ $data['username'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">NIP</label>
                                  <div class="col-md-9">
                                      {{ $data['nip'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">No KTP</label>
                                  <div class="col-md-9">
                                      {{ $data['no_ktp'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Tanggal Lahir</label>
                                  <div class="col-md-9">
                                      {{ $data['tanggal_lahir'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Tempat Lahir</label>
                                  <div class="col-md-9">
                                      {{ $data['tempat_lahir'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Alamat</label>
                                  <div class="col-md-9">
                                      {{ $data['alamat'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Kode Pos</label>
                                  <div class="col-md-9">
                                      {{ $data['kode_pos'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Telepon</label>
                                  <div class="col-md-9">
                                      {{ $data['telepon'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">HP</label>
                                  <div class="col-md-9">
                                      {{ $data['hp'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">NPWP</label>
                                  <div class="col-md-9">
                                      {{ $data['npwp'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">No Rekening</label>
                                  <div class="col-md-9">
                                      {{ $data['no_rekening'] }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Golongan Darah</label>
                                  <div class="col-md-9">
                                      {{$data->golongan_darah}}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Status Perkawinan</label>
                                  <div class="col-md-9">
                                      {{ $data->status_perkawinan_id ? status_perkawinan($data->status_perkawinan_id) : '' }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Golongan</label>
                                  <div class="col-md-9">
                                      {{ !empty($data->user_golongan[count($data->user_golongan) - 1]->golongan->name) ? $data->user_golongan[count($data->user_golongan) - 1]->golongan->name : '<Kosong>' }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Unit Kerja</label>
                                  <div class="col-md-9">
                                      {{ !empty($data->user_jabatan[count($data->user_jabatan) - 1]->unit_kerja->name) ? $data->user_jabatan[count($data->user_jabatan) - 1]->unit_kerja->name : '<Kosong>' }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Pendidikan</label>
                                  <div class="col-md-9">
                                      {{ !empty($data->user_pendidikan[count($data->user_pendidikan) - 1]->pendidikan->name)  ? $data->user_pendidikan[count($data->user_pendidikan) - 1]->pendidikan->name : '<Kosong>' }}
                                  </div>
                              </div>
                              <div class="row mb-4">
                                  <label class="col-md-2 form-label">Gender</label>
                                  <div class="col-md-9">
                                      {{ $data->gender ? gender($data->gender) : '' }}
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane  {{ $tab == 'pendidikan' ? 'active' : '' }}" id="tab-pendidikan">
                              <h2>Pendidikan</h2>
                              <table class="table table-bordered">
                                  <tr>
                                      <th>
                                          No
                                      </th>
                                      <th>
                                          Nama Pendidikan
                                      </th>
                                      <th>
                                          Detail Pendidikan
                                      </th>
                                      <th>
                                          No Ijazah
                                      </th>
                                      <th>
                                          Tahun Lulus
                                      </th>
                                      <th>
                                          Foto Ijazah
                                      </th>
                                  </tr>
                                  @foreach ($data->user_pendidikan as $key => $val)
                                  <tr>
                                      <td>
                                          {{ $key + 1 }}
                                      </td>
                                      <td>
                                          {{!empty($val->pendidikan->name) ? $val->pendidikan->name : ''}}
                                      </td>
                                      <td>
                                          {{ $val->pendidikan_detail }}
                                      </td>
                                      <td>
                                          {{$val->no_ijazah ? $val->no_ijazah : ''}}
                                      </td>
                                      <td>
                                          {{$val->tahun_lulus ? $val->tahun_lulus : ''}}
                                      </td>
                                      <td>
                                      </td>
                                  </tr>
                                  @endforeach
                                  <tr>
                                      <td colspan="6" class="text-center">
                                          <input type="button" class="btn btn-primary" value="Tambah Riwayat Pendidikan" onclick="saveNewUserPendidikan()" />
                                      </td>
                                  </tr>
                              </table>
                          </div>
                          <div class="tab-pane  {{ $tab == 'pelatihan' ? 'active' : '' }}" id="tab-pelatihan">
                              <h2>Pelatihan</h2>

                              <table class="table table-bordered">
                                  <tr>
                                      <th>
                                          No
                                      </th>
                                      <th>
                                          Nama Sertifikat
                                      </th>
                                      <th>
                                          No Sertifikat
                                      </th>
                                      <th>
                                          Tahun
                                      </th>
                                      <th>
                                          Foto Sertifikat
                                      </th>
                                  </tr>
                                  @foreach ($data->user_pelatihan as $key => $val)
                                  <tr>
                                      <td>
                                          {{ $key + 1 }}
                                      </td>
                                      <td>
                                          {{ $val->nama_sertifikat }}
                                      </td>
                                      <td>
                                          {{ $val->no_sertifikat }}
                                      </td>
                                      <td>
                                          {{ $val->tahun }}
                                      </td>
                                      <td>

                                      </td>
                                  </tr>
                                  @endforeach
                                  <tr>
                                      <td colspan="5" class="text-center">
                                          <input type="button" class="btn btn-primary" value="Tambah Riwayat Pelatihan" onclick="saveNewUserPelatihan()" />
                                      </td>
                                  </tr>
                              </table>

                          </div>
                          <div class="tab-pane  {{ $tab == 'keluarga' ? 'active' : '' }}" id="tab-keluarga">
                              <h2>Keluarga</h2>

                              <div class="table-responsive">
                                  <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                      <table class="table table-bordered">
                                          <tr>
                                              <th style="min-width: 80px;" rowspan="2">
                                                  No
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Nama Lengkap
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  NIK
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Jenis Kelamin
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Tempat Lahir
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Tanggal Lahir
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Agama
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Pendidikan
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Jenis Pekerjaan
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Status Perkawinan
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Status Hub Dalam Keluarga
                                              </th>
                                              <th style="min-width: 200px;" rowspan="2">
                                                  Kewarganegaraan
                                              </th>
                                              <th colspan="2">
                                                  Dok Imigrasi
                                              </th>
                                              <th colspan="2">
                                                  Nama Orangtua
                                              </th>
                                          </tr>

                                          <tr>
                                              <th style="min-width: 200px;">No Paspor</th>
                                              <th style="min-width: 200px;">No Kitas / Kitap</th>
                                              <th style="min-width: 200px;">Ayah</th>
                                              <th style="min-width: 200px;">Ibu</th>
                                          </tr>



                                          @foreach ($data->user_keluarga as $key => $val)
                                          <tr>
                                              <td>
                                                {{ $key + 1 }}
                                              </td>
                                              <td>
                                                {{ $val->nama_lengkap }}
                                              </td>
                                              <td>
                                                {{ $val->nik }}
                                              </td>
                                              <td>
                                                  {{ $val->jenis_kelamin ? gender($val->jenis_kelamin) : '' }}
                                              </td>
                                              <td>
                                                  {{ $val->tempat_lahir }}
                                              </td>
                                              <td>
                                                  {{ $val->tanggal_lahir }}
                                              </td>
                                              <td>
                                                  {{ $val->agama_id ? agama($val->agama_id) : '' }}
                                              </td>
                                              <td>
                                                  {{$val->pendidikan}}
                                              </td>
                                              <td>
                                                  {{ $val->jenis_pekerjaan }}
                                              </td>
                                              <td>
                                                  {{ $val->status_perkawinan }}
                                              </td>
                                              <td>
                                                  {{ $val->hubungan_keluarga }}
                                              </td>
                                              <td>
                                                  {{ $val->kewarganegaraan }}
                                              </td>
                                              <td>
                                                  {{ $val->no_paspor }}
                                              </td>
                                              <td>
                                                  {{ $val->no_kitas }}
                                              </td>
                                              <td>
                                                  {{ $val->ayah }}
                                              </td>
                                              <td>
                                                  {{ $val->ibu }}
                                              </td>
                                          </tr>
                                          @endforeach
                                          <tr>
                                              <td colspan="6" class="text-center">
                                                  <input type="button" class="btn btn-primary" value="Tambah Anggota Keluarga" onclick="saveNewUserKeluarga()" />
                                              </td>
                                              <td colspan="10" class="text-center">
                                              </td>
                                          </tr>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane  {{ $tab == 'jabatan' ? 'active' : '' }}" id="tab-jabatan">
                              <h2>Jabatan</h2>

                              <div class="table-responsive">
                                  <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                      <table class="table table-bordered">
                                          <tr>
                                              <th style="min-width: 80px;">
                                                  No
                                              </th>
                                              <th style="min-width: 200px;">
                                                  Nama jabatan
                                              </th>
                                              <th style="min-width: 200px;">
                                                  Dari Tahun
                                              </th>
                                              <th style="min-width: 200px;">
                                                  Sampai Tahun
                                              </th>
                                              <th style="min-width: 200px;">
                                                  Unit Kerja
                                              </th>
                                              <th style="min-width: 200px;">
                                                  TMT
                                              </th>
                                          </tr>
                                          @foreach ($data->user_jabatan as $key => $val)
                                          <tr>
                                              <td>
                                                  {{ $key + 1 }}
                                              </td>
                                              <td>
                                                  {{ !empty($val->position->name) ? $val->position->name : '' }}
                                              </td>
                                              <td>
                                                  {{ $val->dari_tahun }}
                                              </td>
                                              <td>
                                                  {{ $val->sampai_tahun }}
                                              </td>
                                              <td>
                                                  {{ !empty($val->unit_kerja->name) ? $val->unit_kerja->name : '' }}
                                              </td>
                                              <td>
                                                  {{$val->tmt}}
                                              </td>
                                          </tr>
                                          @endforeach
                                          <tr>
                                              <td colspan="6" class="text-center">
                                                  <input type="button" class="btn btn-primary" value="Tambah Riwayat Jabatan" onclick="saveNewUserJabatan()" />
                                              </td>
                                          </tr>
                                      </table>
                                  </div>
                              </div>


                          </div>
                          <div class="tab-pane  {{ $tab == 'golongan' ? 'active' : '' }}" id="tab-golongan">
                              <h2>Golongan</h2>

                              <div class="table-responsive">
                                  <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                      <table class="table table-bordered">
                                          <tr>
                                              <th style="min-width: 80px;">
                                                  No
                                              </th>
                                              <th style="min-width: 200px;">
                                                  Nama
                                              </th>
                                              <th style="min-width: 200px;">
                                                  Dari Tahun
                                              </th>
                                              <th style="min-width: 200px;">
                                                  Sampai Tahun
                                              </th>
                                              <th style="min-width: 200px;">
                                                  TMT
                                              </th>
                                          </tr>
                                          @foreach ($data->user_golongan as $key => $val)
                                          <tr>
                                              <td>
                                                  {{ $key + 1 }}
                                              </td>
                                              <td>
                                                {{$val->golongan->name}}
                                              </td>
                                              <td>
                                                  {{ $val->dari_tahun }}
                                              </td>
                                              <td>
                                                  {{ $val->sampai_tahun }}
                                              </td>
                                              <td>
                                                  {{ $val->tmt }}
                                              </td>
                                          </tr>
                                          @endforeach
                                          <tr>
                                              <td colspan="5" class="text-center">
                                                  <input type="button" class="btn btn-primary" value="Tambah Riwayat Golongan" onclick="saveNewUserGolongan()" />
                                              </td>
                                          </tr>
                                      </table>
                                  </div>
                              </div>

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
    @include('app.user.profile.scripts.index')
@endsection

@section('formValidationScript')
    @include('app.user.profile.scripts.form')
@endsection
