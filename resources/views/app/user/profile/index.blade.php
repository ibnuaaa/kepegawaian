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
                                <label class="col-md-2 form-label">Email</label>
                                <div class="col-md-9">
                                    {{ $data['email'] }}
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
                                <label class="col-md-2 form-label">Alamat (Domisili)</label>
                                <div class="col-md-9">
                                    {{ $data['alamat_domisili'] }}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-md-2 form-label">Kode Pos (Domisili)</label>
                                <div class="col-md-9">
                                    {{ $data['kode_pos_domisili'] }}
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
                                <label class="col-md-2 form-label">No Rekening (Mandiri)</label>
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
                                    {{!empty($data->unit_kerja->name) ? $data->unit_kerja->name : ''}}
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
                                <label class="col-md-2 form-label">No SIP</label>
                                <div class="col-md-9">
                                    {{!empty($data->no_sip) ? ($data->no_sip) : ''}}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-md-2 form-label">Upload File SIP (PDF)</label>
                                <div class="col-md-9">
                                    <div class="img-preview mt-2" id="img-preview">
                                        @if (!empty($data->foto_sip))
                                        @foreach ($data->foto_sip as $key => $val)
                                        <a href="/api/preview/{{$val->storage->key}}">
                                            <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                        </a>
                                        @endforeach
                                        @endif
                                    </div>
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
                                        Jenjang Pendidikan
                                    </th>
                                    <th>
                                        Nama Sekolah / Kampus
                                    </th>
                                    <th>
                                        Fakultas
                                    </th>
                                    <th>
                                        NIM
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
                                        {{ $val->fakultas }}
                                    </td>
                                    <td>
                                        {{ $val->nim   }}
                                    </td>
                                    <td>
                                        {{$val->no_ijazah ? $val->no_ijazah : ''}}
                                    </td>
                                    <td>
                                        {{$val->tahun_lulus ? $val->tahun_lulus : ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9">
                                        <div class="row">
                                            <div class="col-2">
                                                <h4>File Ijazah</h4>
                                                <div class="img-preview mt-2" id="img-preview">
                                                    @if (!empty($val->foto_ijazah))
                                                    @foreach ($val->foto_ijazah as $key2 => $val2)
                                                    <a href="/api/preview/{{$val2->storage->key}}">
                                                        <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                                    </a>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <h4>File Transkrip Nilai</h4>
                                                <div class="img-preview mt-2" id="img-preview">
                                                    @if (!empty($val->foto_transkrip_nilai))
                                                    @foreach ($val->foto_transkrip_nilai as $key2 => $val2)
                                                    <a href="/api/preview/{{$val2->storage->key}}">
                                                        <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                                    </a>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
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


                            <br />
                            <h4>Foto Akta Nikah</h4>
                            <div class="img-preview mt-2 mb-5" id="img-preview">
                                @if (!empty($data->foto_akta_nikah))
                                @foreach ($data->foto_akta_nikah as $key => $val)
                                <a href="/api/preview/{{$val->storage->key}}">
                                    <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                </a>
                                @endforeach
                                @endif

                            </div>


                            <div class="table-responsive">
                                <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                                      @foreach ($data->user_keluarga as $key => $val)
                                      <div style="border-bottom: solid thin #ccc;padding-top: 30px;" class="disable-form">
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Hub Keluarga</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control form-select" name="hub_keluarga_id" data-id="{{ $val->id }}">
                                                                <option>-= Pilih =-</option>
                                                                <option value="1" @if ($val->hub_keluarga_id == '1') selected='selected'  @endif>Pasangan Saya (suami / istri)</option>
                                                                <option value="2" @if ($val->hub_keluarga_id == '2') selected='selected'  @endif>Anak Saya</option>
                                                                <option value="3" @if ($val->hub_keluarga_id == '3') selected='selected'  @endif>Lain2 (Ayah saya / Ibu saya / Kakek saya / Nenek Saya / Adik Saya / Kakak Saya)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @if ($val->hub_keluarga_id == 1)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Nama Suami / Istri</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->nama_lengkap != $val->user_keluarga->nama_lengkap ? 'bg-changed' : '' }}">
                                                            <input name="nama_lengkap" value="{{ $val->nama_lengkap }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">NIK Suami / Istri</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->nik != $val->user_keluarga->nik ? 'bg-changed' : '' }}">
                                                            <input name="nik" value="{{ $val->nik }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">NIP Suami / Istri (Jika PNS)</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->nip != $val->user_keluarga->nip ? 'bg-changed' : '' }}">
                                                            <input name="nip" value="{{ $val->nip }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Tempat lahir Suami / Istri</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->tempat_lahir != $val->user_keluarga->tempat_lahir ? 'bg-changed' : '' }}">
                                                            <input name="tempat_lahir" value="{{ $val->tempat_lahir }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Tanggal lahir Suami / Istri</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->tanggal_lahir != $val->user_keluarga->tanggal_lahir ? 'bg-changed' : '' }}">
                                                            <input id="myDatepicker" name="tanggal_lahir" value="{{ $val->tanggal_lahir }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">No Akta Nikah</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->no_akta_nikah != $val->user_keluarga->no_akta_nikah ? 'bg-changed' : '' }}">
                                                            <input name="no_akta_nikah" value="{{ $val->no_akta_nikah }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Tanggal Pernikahan</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->tgl_pernikahan != $val->user_keluarga->tgl_pernikahan ? 'bg-changed' : '' }}">
                                                            <input id="myDatepicker" name="tgl_pernikahan" value="{{ $val->tgl_pernikahan }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Pekerjaan</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->jenis_pekerjaan != $val->user_keluarga->jenis_pekerjaan ? 'bg-changed' : '' }}">
                                                            <input name="jenis_pekerjaan" value="{{ $val->jenis_pekerjaan }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Alamat Suami / Istri</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->alamat != $val->user_keluarga->alamat ? 'bg-changed' : '' }}">
                                                            <input name="alamat" value="{{ $val->alamat }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Telp / HP</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->hp != $val->user_keluarga->hp ? 'bg-changed' : '' }}">
                                                            <input name="hp" value="{{ $val->hp }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Status</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->status_pasangan != $val->user_keluarga->status_pasangan ? 'bg-changed' : '' }}">
                                                          <select class="form-control form-select" name="status_pasangan" data-id="{{ $val->id }}">
                                                            <option>-= Pilih =-</option>
                                                            <option value="meninggal" @if ($val->status_pasangan == 'meninggal') selected='selected'  @endif>Meninggal</option>
                                                              <option value="cerai" @if ($val->status_pasangan == 'cerai') selected='selected'  @endif>Cerai</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">No Akta Cerai / Kematian</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->no_akta_cerai_meninggal != $val->user_keluarga->no_akta_cerai_meninggal ? 'bg-changed' : '' }}">
                                                            <input name="no_akta_cerai_meninggal" value="{{ $val->no_akta_cerai_meninggal }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Tanggal Akta Cerai / Kematian</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->tgl_akta_cerai_meninggal != $val->user_keluarga->tgl_akta_cerai_meninggal ? 'bg-changed' : '' }}">
                                                            <input id="myDatepicker" name="tgl_akta_cerai_meninggal" value="{{ $val->tgl_akta_cerai_meninggal }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>







                                        @elseif ($val->hub_keluarga_id == 2)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-4 mt-4">
                                                        <label class="col-md-4 form-label">Nama Anak</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->nama_lengkap != $val->user_keluarga->nama_lengkap ? 'bg-changed' : '' }}">
                                                            <input name="nama_lengkap" value="{{ $val->nama_lengkap }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">NIK</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->nik != $val->user_keluarga->nik ? 'bg-changed' : '' }}">
                                                            <input name="nik" value="{{ $val->nik }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Jenis Kelamin</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->jenis_kelamin != $val->user_keluarga->jenis_kelamin ? 'bg-changed' : '' }}">
                                                            <input name="jenis_kelamin" value="{{ $val->jenis_kelamin }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Tempat Lahir</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->tempat_lahir != $val->user_keluarga->tempat_lahir ? 'bg-changed' : '' }}">
                                                            <input name="tempat_lahir" value="{{ $val->tempat_lahir }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Tanggal Lahir</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->tanggal_lahir != $val->user_keluarga->tanggal_lahir ? 'bg-changed' : '' }}">
                                                            <input id="myDatepicker" name="tanggal_lahir" value="{{ $val->tanggal_lahir }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">No Akta Kelahiran</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->akta_kelahiran != $val->user_keluarga->akta_kelahiran ? 'bg-changed' : '' }}">
                                                            <input name="akta_kelahiran" value="{{ $val->akta_kelahiran }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Alamat</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->alamat != $val->user_keluarga->alamat ? 'bg-changed' : '' }}">
                                                            <input name="alamat" value="{{ $val->alamat }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">No Telp / Hp</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->hp != $val->user_keluarga->hp ? 'bg-changed' : '' }}">
                                                            <input name="hp" value="{{ $val->hp }}" data-id="{{ $val->id }}" class="form-control" type="text" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Status Perkawinan</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->status_perkawinan != $val->user_keluarga->status_perkawinan ? 'bg-changed' : '' }}">
                                                          <select class="form-control form-select" name="status_perkawinan" data-id="{{ $val->id }}">
                                                              <option value="">-= Pilih =-</option>
                                                              <option value="belum_menikah" @if( $val->status_perkawinan == 'belum_menikah' ) selected='selected' @endif >Belum Menikah</option>
                                                              <option value="sudah_menikah" @if( $val->status_perkawinan == 'sudah_menikah' ) selected='selected' @endif>Sudah Menikah</option>
                                                              <option value="janda" @if( $val->status_perkawinan == 'janda' ) selected='selected' @endif>Janda</option>
                                                              <option value="duda" @if( $val->status_perkawinan == 'duda' ) selected='selected' @endif>Duda</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Status Pekerjaan</label>
                                                        <div class="col-md-8 {{ $val->user_keluarga && $val->status_pekerjaan != $val->user_keluarga->status_pekerjaan ? 'bg-changed' : '' }}">
                                                            <select class="form-control form-select" name="status_pekerjaan_id" data-id="{{ $val->id }}">
                                                                <option value="">-= Pilih =-</option>W
                                                                <option value="1" @if( $val->status_pekerjaan_id == '1' ) selected='selected' @endif>Sekolah / Kuliah</option>
                                                                <option value="2" @if( $val->status_pekerjaan_id == '2' ) selected='selected' @endif>Bekerja</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <label class="col-md-4 form-label">Status Anak</label>
                                                        <div class="col-md-8 {{ $val->user_pelatihan && $val->status_anak_id != $val->user_pelatihan->status_anak_id ? 'bg-changed' : '' }}">
                                                          <select class="form-control form-select" name="status_anak_id" data-id="{{ $val->id }}">
                                                              <option value="">-= Pilih =-</option>W
                                                              <option value="1" @if( $val->status_pekerjaan_id == '1' ) selected='selected' @endif>Anak Kandung</option>
                                                              <option value="2" @if( $val->status_pekerjaan_id == '2' ) selected='selected' @endif>Anak Angkat</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @else
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Nama</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->nama_lengkap != $val->user_keluarga->nama_lengkap ? 'bg-changed' : '' }}">
                                                                <input name="nama_lengkap" value="{{ $val->nama_lengkap }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">NIK</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->nik != $val->user_keluarga->nik ? 'bg-changed' : '' }}">
                                                                <input name="nik" value="{{ $val->nik }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Jenis Kelamin</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->jenis_kelamin != $val->user_keluarga->jenis_kelamin ? 'bg-changed' : '' }}">
                                                              @component('components.form.awesomeSelect', [
                                                              'name' => 'jenis_kelamin',
                                                              'items' => [
                                                              [
                                                              'label' => 'Laki-laki',
                                                              'value' => 'm',
                                                              ],
                                                              [
                                                              'label' => 'Perempuan',
                                                              'value' => 'f',
                                                              ]
                                                              ],
                                                              'selected' => $val->jenis_kelamin,
                                                              'data_id' => $val->id
                                                              ])
                                                              @endcomponent
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Tempat Lahir</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->tempat_lahir != $val->user_keluarga->tempat_lahir ? 'bg-changed' : '' }}">
                                                            <input name="tempat_lahir" value="{{ $val->tempat_lahir }}" data-id="{{ $val->id }}" class="form-control datepicker" type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Tanggal Lahir</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->tanggal_lahir != $val->user_keluarga->tanggal_lahir ? 'bg-changed' : '' }}">
                                                            <input name="tanggal_lahir" id="myDatepicker" value="{{ $val->tanggal_lahir }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Agama</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->nik != $val->user_keluarga->nik ? 'bg-changed' : '' }}">
                                                            @component('components.form.awesomeSelect', [
                                                            'name' => 'agama_id',
                                                            'items' => agama(),
                                                            'selected' => $val->agama_id,
                                                            'data_id' => $val->id
                                                            ])
                                                            @endcomponent
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Pendidikan</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->pendidikan_id != $val->user_keluarga->pendidikan_id ? 'bg-changed' : '' }}">
                                                              @component('components.form.awesomeSelect', [
                                                              'name' => 'pendidikan_id',
                                                              'items' => $pendidikan,
                                                              'selected' => $val->pendidikan_id,
                                                              'data_id' => $val->id
                                                              ])
                                                              @endcomponent
                                                            </div>
                                                        </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Jenis Pekerjaan</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->jenis_pekerjaan != $val->user_keluarga->jenis_pekerjaan ? 'bg-changed' : '' }}">
                                                                <input name="jenis_pekerjaan" value="{{ $val->jenis_pekerjaan }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Status Perkawinan</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->status_perkawinan != $val->user_keluarga->status_perkawinan ? 'bg-changed' : '' }}">
                                                                <input name="status_perkawinan" value="{{ $val->status_perkawinan }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Hub Keluarga</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->hubungan_keluarga != $val->user_keluarga->hubungan_keluarga ? 'bg-changed' : '' }}">
                                                                <input name="hubungan_keluarga" value="{{ $val->hubungan_keluarga }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                                <i style="font-size: 10px;">Sesuai Dengan Kartu Keluarga</i>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Kewarganegaraan</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->kewarganegaraan != $val->user_keluarga->kewarganegaraan ? 'bg-changed' : '' }}">
                                                                <input name="kewarganegaraan" value="{{ $val->kewarganegaraan }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">No Paspor</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->no_paspor != $val->user_keluarga->no_paspor ? 'bg-changed' : '' }}">
                                                                <input name="no_paspor" value="{{ $val->no_paspor }}" data-id="{{ $val->id }}" class="form-control" type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">No Kitas</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->no_kitas != $val->user_keluarga->no_kitas ? 'bg-changed' : '' }}">
                                                                <input name="no_kitas" value="{{ $val->no_kitas }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Nama Ayah</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->ayah != $val->user_keluarga->ayah ? 'bg-changed' : '' }}">
                                                                <input name="ayah" value="{{ $val->ayah }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4 mt-4">
                                                            <label class="col-md-4 form-label">Nama Ibu</label>
                                                            <div class="col-md-8 {{ $val->user_keluarga && $val->ibu != $val->user_keluarga->ibu ? 'bg-changed' : '' }}">
                                                                <input name="ibu" value="{{ $val->ibu }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                          </div>









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

<style>
.disable-form input, .disable-form select{
  pointer-events:none;
}
</style>
