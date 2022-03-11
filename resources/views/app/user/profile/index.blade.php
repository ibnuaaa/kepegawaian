@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Profil User
        <a href="#" onClick="ubahProfil()" class="btn btn-primary btn-sm">
            <i class="fa fa-pencil"></i>
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




              @if (!empty($user_request->status_sdm) && $user_request->status_sdm == 'request_approval')
              <div class="alert alert-info" role="alert">
                  <span class="alert-inner--icon"><i class="fe fe-bell"></i></span>
                  <span class="alert-inner--text"><strong>Informasi !</strong> Permintaan ubah data profil menunggu approval dari SDM </span>
              </div>
              @endif
              @if (!empty($user_request->status_diklat) && $user_request->status_diklat == 'request_approval')
              <div class="alert alert-info" role="alert">
                  <span class="alert-inner--icon"><i class="fe fe-bell"></i></span>
                  <span class="alert-inner--text"><strong>Informasi !</strong> Permintaan ubah data profil menunggu approval dari Diklat </span>
              </div>
              @endif

              @if (!empty($user_request->status_sdm) && $user_request->status_sdm == 'approved')
              <div class="alert alert-success" role="alert">
                  <span class="alert-inner--icon"><i class="fe fe-bell"></i></span>
                  <span class="alert-inner--text"><strong>Informasi !</strong> Permintaan ubah data profil telah disetujui SDM </span>
              </div>
              @endif

              @if (!empty($user_request->status_diklat) && $user_request->status_diklat == 'approved')
              <div class="alert alert-success" role="alert">
                  <span class="alert-inner--icon"><i class="fe fe-bell"></i></span>
                  <span class="alert-inner--text"><strong>Informasi !</strong> Permintaan ubah data profil telah disetujui Diklat </span>
              </div>
              @endif


              @if (!empty($reject_request)   && count($reject_request) > 0)
              <div class="alert alert-danger" role="alert">
                  <span class="alert-inner--icon"><i class="fe fe-bell"></i></span>
                  <span class="alert-inner--text"><strong>Informasi !</strong> Permintaan ubah data profil anda ditolak dengan alasan : </span>
                  <br />
                  <ol>
                  @foreach ($reject_request as $key => $val)
                    <li>{{$val->description}}</li>
                  @endforeach
                </ol>

                <br>

                Silahkan klik

                <a href="#" onClick="ubahProfil()" class="btn btn-primary btn-sm">
                    <i class="fa fa-pencil"></i>
                    Ubah Profil
                </a>

                untuk memperbaiki. Terimakasih.

              </div>
              @endif


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
                                <label class="col-md-2 form-label">Foto Profil</label>
                                <div class="col-md-9">
                                    <div style="clear: both;"></div>
                                    <div class="img-preview mt-2" id="img-preview">
                                        @if (!empty($data->foto_profile))
                                        @foreach ($data->foto_profile as $key => $val2)
                                        <img src="/api/preview/{{$val2->storage->key}}" alt="avatar-img" style="max-width: 200px;max-height: 200px;">
                                        @endforeach
                                        @endif
                                        <div style="clear: both;"></div>
                                    </div>

                                    <div style="clear: both;"></div>

                                </div>
                            </div>

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

                            <div class=" row mb-4">
                                <label class="col-md-2 form-label">Jabatan</label>
                                <div class="col-md-9">
                                    {{!empty($data->jabatan->name) ? $data->jabatan->name : ''}}
                                </div>
                            </div>
                            <div class=" row mb-4">
                                <label class="col-md-2 form-label">Unit Kerja</label>
                                <div class="col-md-9">
                                    {{$data->unit_kerja->name}}
                                </div>
                            </div>
                            <div class=" row mb-4">
                                <label class="col-md-2 form-label">Status Pegawai</label>
                                <div class="col-md-9">
                                    {{!empty($data->status_pegawai->name) ? $data->status_pegawai->name : ''}}
                                </div>
                            </div>
                            <div class=" row mb-4">
                                <label class="col-md-2 form-label">Golongan</label>
                                <div class="col-md-9">
                                    {{!empty($data->golongan->pangkat) ? ($data->golongan->pangkat .'/'. $data->golongan->golongan) : ''}}
                                </div>
                            </div>
                            <div class=" row mb-4">
                                <label class="col-md-2 form-label">No STR</label>
                                <div class="col-md-9">
                                    {{!empty($data->no_str) ? ($data->no_str) : ''}}
                                </div>
                            </div>
                            <div class=" row mb-4">
                                <label class="col-md-2 form-label">Masa Berlaku STR Sampai</label>
                                <div class="col-md-9">
                                    {{!empty($data->masa_berlaku_str) ? ($data->masa_berlaku_str) : ''}}
                                </div>
                            </div>
                            <div class=" row mb-4">
                                <label class="col-md-2 form-label">Jabatan Fungsional</label>
                                <div class="col-md-9">
                                    {{!empty($data->jabatan_fungsional->name) ? $data->jabatan_fungsional->name : ''}}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-md-2 form-label">Pendidikan (Terakhir)</label>
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


                            <div class="row mb-4">
                                <label class="col-md-2 form-label">Foto KTP</label>
                                <div class="col-md-9">
                                    <div class="img-preview mt-2" id="img-preview">
                                        @if (!empty($data->foto_ktp))
                                        @foreach ($data->foto_ktp as $key => $val)
                                        <a href="/api/preview/{{$val->storage->key}}">
                                            <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-md-2 form-label">Foto NPWP</label>
                                <div class="col-md-9">
                                    <div class="img-preview mt-2" id="img-preview">
                                        @if (!empty($data->foto_npwp))
                                        @foreach ($data->foto_npwp as $key => $val)
                                        <a href="/api/preview/{{$val->storage->key}}">
                                            <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-md-2 form-label">Foto BPJS</label>
                                <div class="col-md-9">
                                    <div class="img-preview mt-2" id="img-preview">
                                        @if (!empty($data->foto_bpjs))
                                        @foreach ($data->foto_bpjs as $key => $val)
                                        <a href="/api/preview/{{$val->storage->key}}">
                                            <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
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
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="img-preview mt-2" id="img-preview">
                                            @if (!empty($val->foto_ijazah))
                                            @foreach ($val->foto_ijazah as $key => $val)
                                            <a href="/api/preview/{{$val->storage->key}}">
                                                <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div class="img-preview mt-2" id="img-preview">
                                            @if (!empty($val->foto_sertifikat))
                                            @foreach ($val->foto_sertifikat as $key => $val)
                                            <a href="/api/preview/{{$val->storage->key}}">
                                                <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                        </div>
                        <div class="tab-pane  {{ $tab == 'keluarga' ? 'active' : '' }}" id="tab-keluarga">
                            <h2>Keluarga</h2>
                            <br />
                            <h4>Foto Kartu Keluarga</h4>
                            <div class="img-preview mt-2 mb-5" id="img-preview">
                                @if (!empty($data->foto_kk))
                                @foreach ($data->foto_kk as $key => $val)
                                <a href="/api/preview/{{$val->storage->key}}">
                                    <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                </a>
                                @endforeach
                                @endif

                            </div>
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
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane  {{ $tab == 'jabatan' ? 'active' : '' }}" id="tab-jabatan">
                            <h2>Jabatan Struktural</h2>

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
                                                {{ !empty($val->jabatan->name) ? $val->jabatan->name : '' }}
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
                                    </table>
                                </div>
                            </div>


                            <br /><br />
                            <h2>Jabatan Fungsional</h2>

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
                                        </tr>
                                        @foreach ($data->user_jabatan_fungsional as $key => $val)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ !empty($val->jabatan_fungsional->name) ? $val->jabatan_fungsional->name : '' }}
                                            </td>
                                            <td>
                                                {{ $val->dari_tahun }}
                                            </td>
                                            <td>
                                                {{ $val->sampai_tahun }}
                                            </td>
                                        </tr>
                                        @endforeach
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
                                                {{!empty($val->golongan->pangkat) ? $val->golongan->pangkat : ''}}
                                                /
                                                {{!empty($val->golongan->golongan) ? $val->golongan->golongan : ''}}
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
