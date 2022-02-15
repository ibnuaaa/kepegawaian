@extends('layout.app')

@section('title', 'User')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

<?php

$menuClass= '';
$menuClassChild= '';


if (!empty($menu)) {
if ($menu == 'sdm') {
  $menuClass= 'Sdm';

  if ($data->status_sdm == 'new') {
    $menuClassChild= 'New';
  } else if ($data->status_sdm == 'request_approval') {
    $menuClassChild= 'RequestApproval';
  } else if ($data->status_sdm == 'approved') {
    $menuClassChild= 'Approved';
  }
} else if ($menu == 'diklat') {
  $menuClass= 'Diklat';

  if ($data->status_diklat == 'new') {
    $menuClassChild= 'New';
  } else if ($data->status_diklat == 'request_approval') {
    $menuClassChild= 'RequestApproval';
  } else if ($data->status_diklat == 'approved') {
    $menuClassChild= 'Approved';
  }
}





}
?>


@section('userRequest'.$menuClass.'MenuClass', 'is-expanded')
@section('userRequest'.$menuClassChild.$menuClass.'MenuClass', 'active')


@section('content')
<div class="page-header">
    <h1 class="page-title">Ubah Data User</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/profile">Profil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Data User</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->



<!-- ROW-1 -->
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header ">
                <div class="card-title">
                    Form Ubah Data User
                </div>
            </div>
            <div class="card-body">
                <div class="panel panel-primary">

                    <div class="alert alert-info" role="alert">
                        <span class="alert-inner--icon"><i class="fe fe-bell"></i></span>
                        <span class="alert-inner--text"><strong>Informasi !</strong> Silahkan melakukan perubahan data anda. Data yang anda ketik langsung tersimpan pada server. Data akan diverifikasi oleh Bagian SDM. </span>
                    </div>

                    <div class="tab-menu-heading tab-menu-heading-boxed">
                        <div class="tabs-menu-boxed">
                            <ul class="nav panel-tabs">
                                <li><a href="{{ $page == 'profile' ? '/profile/personal/' . $id : '#tab-personal' }}" {!! $page == 'profile' ? '' : 'data-bs-toggle="tab"' !!}  {{ $tab == 'personal' ? 'class=active' : '' }}>Personal</a></li>
                                <li><a href="{{ $page == 'profile' ? '/profile/pendidikan/' . $id : '#tab-pendidikan' }}" {!! $page == 'profile' ? '' : 'data-bs-toggle="tab"' !!}  {{ $tab == 'pendidikan' ? 'class=active' : '' }}>Riwayat Pendidikan</a></li>
                                <li><a href="{{ $page == 'profile' ? '/profile/pelatihan/' . $id : '#tab-pelatihan' }}" {!! $page == 'profile' ? '' : 'data-bs-toggle="tab"' !!}  {{ $tab == 'pelatihan' ? 'class=active' : '' }}>Riwayat Pelatihan</a></li>
                                <li><a href="{{ $page == 'profile' ? '/profile/keluarga/' . $id : '#tab-keluarga' }}" {!! $page == 'profile' ? '' : 'data-bs-toggle="tab"' !!}  {{ $tab == 'keluarga' ? 'class=active' : '' }}>Keluarga</a></li>
                                <li><a href="{{ $page == 'profile' ? '/profile/jabatan/' . $id : '#tab-jabatan' }}" {!! $page == 'profile' ? '' : 'data-bs-toggle="tab"' !!}  {{ $tab == 'jabatan' ? 'class=active' : '' }}>Riwayat Jabatan</a></li>
                                <li><a href="{{ $page == 'profile' ? '/profile/golongan/' . $id : '#tab-golongan' }}" {!! $page == 'profile' ? '' : 'data-bs-toggle="tab"' !!}  {{ $tab == 'golongan' ? 'class=active' : '' }}>Riwayat Golongan</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">


                            <!-- =========================================================== -->
                            <!-- TAB PERSONAL -->
                            <!-- =========================================================== -->
                            <div class="tab-pane {{ $tab == 'personal' ? 'active' : '' }}" id="tab-personal">
                                <h2>Personal</h2>





                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Foto Profil</label>
                                    <div class="col-md-9">
                                        @if($page == 'profile')
                                        <input type="file" onchange="prepareUpload(this, 'foto_profile{{ !$id ? '_request' : '' }}', '{{ $data->id }}', false, ['png','jpg','jpeg','bmp']);" multiple>
                                        @endif
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
                                        <a>{{ $data->user->name }}</a>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->username != $data->user->username ? 'bg-changed' : '' }}" >
                                    <label class="col-md-2 form-label">Username</label>
                                    <div class="col-md-9">
                                        <input name="username" value="{{ $data['username'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">NIP</label>
                                    <div class="col-md-9">
                                        {{ $data->user->nip }}
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->no_ktp != $data->user->no_ktp ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">No KTP</label>
                                    <div class="col-md-9">
                                        <input name="no_ktp" value="{{ $data['no_ktp'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->tanggal_lahir != $data->user->tanggal_lahir ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Tanggal Lahir</label>
                                    <div class="col-md-9">
                                        <input name="tanggal_lahir" id="myDatepicker" value="{{ $data['tanggal_lahir'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->tempat_lahir != $data->user->tempat_lahir ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Tempat Lahir</label>
                                    <div class="col-md-9">
                                        <input name="tempat_lahir" value="{{ $data['tempat_lahir'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->alamat != $data->user->alamat ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Alamat</label>
                                    <div class="col-md-9">
                                        <input name="alamat" value="{{ $data['alamat'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->kode_pos != $data->user->kode_pos ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Kode Pos</label>
                                    <div class="col-md-9">
                                        <input name="kode_pos" value="{{ $data['kode_pos'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->telepon != $data->user->telepon ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Telepon</label>
                                    <div class="col-md-9">
                                        <input name="telepon" value="{{ $data['telepon'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->hp != $data->user->hp ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">HP</label>
                                    <div class="col-md-9">
                                        <input name="hp" value="{{ $data['hp'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->npwp != $data->user->npwp ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">NPWP</label>
                                    <div class="col-md-9">
                                        <input name="npwp" value="{{ $data['npwp'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->no_rekening != $data->user->no_rekening ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">No Rekening</label>
                                    <div class="col-md-9">
                                        <input name="no_rekening" value="{{ $data['no_rekening'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->golongan_darah != $data->user->golongan_darah ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Golongan Darah</label>
                                    <div class="col-md-9">
                                        @component('components.form.awesomeSelect', [
                                        'name' => 'golongan_darah',
                                        'items' => [
                                        [
                                        'value' => 'A',
                                        'label' => 'A'
                                        ],
                                        [
                                        'value' => 'B',
                                        'label' => 'B'
                                        ],
                                        [
                                        'value' => 'AB',
                                        'label' => 'AB'
                                        ],
                                        [
                                        'value' => 'O',
                                        'label' => 'O'
                                        ]
                                        ],
                                        'onChange' => 'savePersonal(this)',
                                        'selected' => $data->golongan_darah
                                        ])
                                        @endcomponent
                                    </div>
                                </div>

                                <div class="row mb-4 {{ $data->no_str != $data->user->no_str ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Nomor STR <br/><span style="font-size: 11px;">(Jika Tenaga Kesehatan)</span></label>
                                    <div class="col-md-9">
                                        <input name="no_str" value="{{ $data['no_str'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>

                                <div class="row mb-4 {{ $data->masa_berlaku_str != $data->user->masa_berlaku_str ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Masa Berlaku STR Sampai <br/><span style="font-size: 11px;">(Jika Tenaga Kesehatan)</span></label>
                                    <div class="col-md-9">
                                        <input name="masa_berlaku_str" id="myDatepicker" value="{{ $data['masa_berlaku_str'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>

                                <div class="row mb-4 {{ $data->status_perkawinan_id != $data->user->status_perkawinan_id ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Status Perkawinan</label>
                                    <div class="col-md-9">
                                        @component('components.form.awesomeSelect', [
                                        'name' => 'status_perkawinan_id',
                                        'items' => [
                                        [
                                        'value' => '1',
                                        'label' => 'Menikah'
                                        ],
                                        [
                                        'value' => '2',
                                        'label' => 'Belum Menikah'
                                        ],
                                        [
                                        'value' => '3',
                                        'label' => 'Janda/Duda'
                                        ]
                                        ],
                                        'onChange' => 'savePersonal(this)',
                                        'selected' => $data->status_perkawinan_id
                                        ])
                                        @endcomponent
                                    </div>
                                </div>



                                <div class=" row mb-4 {{ $data->jabatan_id != $data->user->jabatan_id ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Jabatan</label>
                                    <div class="col-md-9">
                                        <select class="form-control form-select" name="jabatan_id" onChange="savePersonal(this)">
                                            <option value="">-= Pilih Jabatan =-</option>
                                            {!! !empty($jabatan) && count($jabatan) > 0 ? treeSelectJabatan($jabatan, '', $data->jabatan_id) : '' !!}
                                        </select>
                                    </div>
                                </div>
                                <div class=" row mb-4 {{ $data->unit_kerja_id != $data->user->unit_kerja_id ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Unit Kerja</label>
                                    <div class="col-md-9">
                                        <select class="form-control form-select" name="unit_kerja_id" onChange="savePersonal(this)">
                                            <option value="">-= Pilih Unit Kerja =-</option>
                                            {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', $data->unit_kerja_id) : '' !!}
                                        </select>
                                    </div>
                                </div>
                                <div class=" row mb-4 {{ $data->status_pegawai_id != $data->user->status_pegawai_id ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Status Pegawai</label>
                                    <div class="col-md-9">
                                        @component('components.form.awesomeSelect', [
                                        'name' => 'status_pegawai_id',
                                        'onChange' => 'savePersonal(this)',
                                        'items' => $status_pegawai,
                                        'selected' => $data->status_pegawai_id
                                        ])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class=" row mb-4 {{ $data->golongan_id != $data->user->golongan_id ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Golongan</label>
                                    <div class="col-md-9">
                                        @component('components.form.awesomeSelect', [
                                        'name' => 'golongan_id',
                                        'onChange' => 'savePersonal(this)',
                                        'items' => $golongan,
                                        'selected' => $data->golongan_id
                                        ])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class=" row mb-4 {{ $data->jabatan_fungsional_id != $data->user->jabatan_fungsional_id ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Jabatan Fungsional</label>
                                    <div class="col-md-9">
                                        @component('components.form.awesomeSelect', [
                                        'name' => 'jabatan_fungsional_id',
                                        'onChange' => 'savePersonal(this)',
                                        'items' => $jabatan_fungsional,
                                        'selected' => $data->jabatan_fungsional_id
                                        ])
                                        @endcomponent
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Pendidikan Terakhir</label>
                                    <div class="col-md-9">
                                        {{ !empty($data->user_pendidikan[count($data->user_pendidikan) - 1]->pendidikan->name)  ? $data->user_pendidikan[count($data->user_pendidikan) - 1]->pendidikan->name : '<Kosong>' }}
                                    </div>
                                </div>
                                <div class="row mb-4 {{ $data->gender != $data->user->gender ? 'bg-changed' : '' }}">
                                    <label class="col-md-2 form-label">Gender</label>
                                    <div class="col-md-9">
                                        @component('components.form.awesomeSelect', [
                                        'name' => 'gender',
                                        'items' => [
                                        [
                                        'value' => 'male',
                                        'label' => 'Laki-laki'
                                        ],
                                        [
                                        'value' => 'female',
                                        'label' => 'Perempuan'
                                        ],
                                        ],
                                        'onChange' => 'savePersonal(this)',
                                        'selected' => $data->gender
                                        ])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="row mb-4 ">
                                    <label class="col-md-2 form-label">Foto KTP</label>
                                    <div class="col-md-9">
                                        @if($page == 'profile')
                                        <input type="file" onchange="prepareUpload(this, 'foto_ktp{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}', false, ['pdf']);" multiple>
                                        @endif
                                        <div style="clear: both;"></div>
                                        <div class="img-preview mt-2" id="img-preview">

                                            @if (!empty($data->foto_ktp))
                                            @foreach ($data->foto_ktp as $key => $val2)
                                            <a href="/api/preview/{{$val2->storage->key}}">
                                                <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                            </a>
                                            @endforeach
                                            @endif

                                            <div style="clear: both;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Foto NPWP</label>
                                    <div class="col-md-9">
                                        @if($page == 'profile')
                                        <input type="file" onchange="prepareUpload(this, 'foto_npwp{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}', false, ['pdf']);" multiple>
                                        @endif
                                        <div style="clear: both;"></div>
                                        <div class="img-preview mt-2" id="img-preview">
                                            @if (!empty($data->foto_npwp))
                                            @foreach ($data->foto_npwp as $key => $val2)
                                            <a href="/api/preview/{{$val2->storage->key}}">
                                                <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                            </a>
                                            @endforeach
                                            @endif
                                            <div style="clear: both;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Foto BPJS</label>
                                    <div class="col-md-9">
                                        @if($page == 'profile')
                                        <input type="file" onchange="prepareUpload(this, 'foto_bpjs{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}', false, ['pdf']);" multiple>
                                        @endif
                                        <div style="clear: both;"></div>
                                        <div class="img-preview mt-2" id="img-preview">
                                            @if (!empty($data->foto_bpjs))
                                            @foreach ($data->foto_bpjs as $key => $val2)
                                            <a href="/api/preview/{{$val2->storage->key}}">
                                                <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                            </a>
                                            @endforeach
                                            @endif
                                            <div style="clear: both;"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <!-- =========================================================== -->
                            <!-- TAB PENDIDIKAN -->
                            <!-- =========================================================== -->
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
                                            Foto Ijazah (PDF)
                                        </th>
                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                    @foreach ($data->user_pendidikan as $key => $val)
                                    @if (!$val->deleted_at || $val->user_pendidikan_id)
                                    <tr class="{{$val->deleted_at ? 'bg-deleted' : ''}} {{!$val->user_pendidikan_id ? 'bg-added' : ''}}">
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="{{ $val->user_pendidikan_id && $val->user_pendidikan && $val->pendidikan_id != $val->user_pendidikan->pendidikan_id ? 'bg-changed' : '' }}">
                                            @component('components.form.awesomeSelect', [
                                            'name' => 'pendidikan_id',
                                            'items' => $pendidikan,
                                            'onChange' => 'savePendidikan(this)',
                                            'selected' => $val->pendidikan_id,
                                            'data_id' => $val->id
                                            ])
                                            @endcomponent
                                        </td>
                                        <td class="{{ $val->user_pendidikan_id && $val->user_pendidikan && $val->pendidikan_detail != $val->user_pendidikan->pendidikan_detail ? 'bg-changed' : '' }}">
                                            <input name="pendidikan_detail" value="{{ $val->pendidikan_detail }}" data-id="{{ $val->id }}" onChange="savePendidikan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td class="{{ $val->user_pendidikan_id && $val->user_pendidikan && $val->no_ijazah != $val->user_pendidikan->no_ijazah ? 'bg-changed' : '' }}">
                                            <input name="no_ijazah" value="{{$val->no_ijazah ? $val->no_ijazah : ''}}" data-id="{{ $val->id }}" onChange="savePendidikan(this)" class="form-control" type="text" required>
                                        </td>
                                        <td class="{{ $val->user_pendidikan_id && $val->user_pendidikan && $val->tahun_lulus != $val->user_pendidikan->tahun_lulus ? 'bg-changed' : '' }}">
                                            <input name="tahun_lulus" value="{{$val->tahun_lulus ? $val->tahun_lulus : ''}}" data-id="{{ $val->id }}" onChange="savePendidikan(this)" class="form-control" type="text" required>
                                        </td>
                                        <td>
                                            @if($page == 'profile')
                                            <input type="file" onchange="prepareUpload(this, 'foto_ijazah{{ !$id ? '_request' : '' }}', '{{ $val->id }}', false, ['pdf']);" multiple>
                                            @endif
                                            <div style="clear: both;"></div>
                                            <div class="img-preview mt-2" id="img-preview">
                                                @if (!empty($val->foto_ijazah))
                                                @foreach ($val->foto_ijazah as $key => $val2)
                                                <a href="/api/preview/{{$val2->storage->key}}">
                                                    <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                                </a>
                                                @endforeach
                                                @endif
                                                <div style="clear: both;"></div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($page == 'profile' && !$val->deleted_at)
                                            <a onClick="return remove('{{$val->id}}','{{!empty($val->pendidikan->name) ? $val->pendidikan->name : ''}}', 'pendidikan')" href="#" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @endif

                                            @if ($val->deleted_at)
                                              Terhapus
                                            @endif

                                            @if (!$val->user_pendidikan_id)
                                              Ditambahkan
                                            @endif
                                        </td>

                                    </tr>
                                    @endif
                                    @endforeach
                                    @if($page == 'profile')
                                    <tr>
                                        <td colspan="6" class="text-left">
                                            <input type="button" class="btn btn-primary" value="Tambah Riwayat Pendidikan" onclick="saveNewUserPendidikan()" />
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>


                            <!-- =========================================================== -->
                            <!-- TAB PELATIHAN -->
                            <!-- =========================================================== -->
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
                                            Upload Sertifikat
                                        </th>
                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                    @foreach ($data->user_pelatihan as $key => $val)
                                    @if (!$val->deleted_at || $val->user_pelatihan_id)
                                    <tr  class="{{$val->deleted_at ? 'bg-deleted' : ''}} {{!$val->user_pelatihan_id ? 'bg-added' : ''}}">
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="{{ $val->user_pelatihan_id && $val->user_pelatihan && $val->nama_sertifikat != $val->user_pelatihan->nama_sertifikat ? 'bg-changed' : '' }}">
                                            <input name="nama_sertifikat" value="{{ $val->nama_sertifikat }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td class="{{ $val->user_pelatihan_id && $val->user_pelatihan && $val->no_sertifikat != $val->user_pelatihan->no_sertifikat ? 'bg-changed' : '' }}">
                                            <input name="no_sertifikat" value="{{ $val->no_sertifikat }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td class="{{ $val->user_pelatihan_id && $val->user_pelatihan && $val->tahun != $val->user_pelatihan->tahun ? 'bg-changed' : '' }}">
                                            <input name="tahun" value="{{ $val->tahun }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td>
                                            @if($page == 'profile')
                                            <input type="file" onchange="prepareUpload(this, 'foto_sertifikat{{ !$id ? '_request' : '' }}', '{{ $val->id }}', false, ['pdf']);" multiple>
                                            @endif
                                            <div style="clear: both;"></div>
                                            <div class="img-preview mt-2" id="img-preview">
                                                @if (!empty($val->foto_sertifikat))
                                                @foreach ($val->foto_sertifikat as $key => $val2)
                                                <a href="/api/preview/{{$val2->storage->key}}">
                                                    <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                                </a>
                                                @endforeach
                                                @endif
                                                <div style="clear: both;"></div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($page == 'profile')
                                            <a onClick="return remove('{{$val->id}}','{{!empty($val->nama_sertifikat) ? $val->nama_sertifikat : ''}}', 'pelatihan')" href="#" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @if($page == 'profile')
                                    <tr>
                                        <td colspan="5" class="text-left">
                                            <input type="button" class="btn btn-primary" value="Tambah Riwayat Pelatihan" onclick="saveNewUserPelatihan()" />
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>


                            <!-- =========================================================== -->
                            <!-- TAB KELUARGA -->
                            <!-- =========================================================== -->
                            <div class="tab-pane  {{ $tab == 'keluarga' ? 'active' : '' }}" id="tab-keluarga">
                                <h2>Keluarga</h2>
                                <br />
                                @if($page == 'profile')
                                <h4>Upload Foto KK (PDF)</h4>
                                <input type="file" onchange="prepareUpload(this, 'foto_kk{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}', false, ['pdf']);" multiple>
                                @endif
                                <div style="clear: both;"></div>
                                <div class="img-preview mt-2" id="img-preview">
                                    @if (!empty($data->foto_kk))
                                    @foreach ($data->foto_kk as $key => $val2)
                                    <a href="/api/preview/{{$val2->storage->key}}">
                                        <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                                    </a>
                                    @endforeach
                                    @endif
                                    <div style="clear: both;"></div>
                                </div>

                                <div style="clear: both;"></div>
                                <br />
                                <div class="alert alert-warning" role="alert">
                                    <span class="alert-inner--icon"><i class="fe fe-info" style="color: #f7b731"></i></span>
                                    <span class="alert-inner--text"><strong>Perhatian !</strong> Dimohon untuk mengisi form keluarga berdasarkan Kartu Keluarga anda! Terimakasih </span>
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
                                                <th rowspan="2">
                                                    Aksi
                                                </th>
                                            </tr>

                                            <tr>
                                                <th style="min-width: 200px;">No Paspor</th>
                                                <th style="min-width: 200px;">No Kitas / Kitap</th>
                                                <th style="min-width: 200px;">Ayah</th>
                                                <th style="min-width: 200px;">Ibu</th>
                                            </tr>



                                            @foreach ($data->user_keluarga as $key => $val)
                                            @if (!$val->deleted_at || $val->user_keluarga_id)
                                            <tr  class="{{$val->deleted_at ? 'bg-deleted' : ''}} {{!$val->user_keluarga_id ? 'bg-added' : ''}}">
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->nama_lengkap != $val->user_keluarga->nama_lengkap ? 'bg-changed' : '' }}">
                                                    <input name="nama_lengkap" value="{{ $val->nama_lengkap }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->nik != $val->user_keluarga->nik ? 'bg-changed' : '' }}">
                                                    <input name="nik" value="{{ $val->nik }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->jenis_kelamin != $val->user_keluarga->jenis_kelamin ? 'bg-changed' : '' }}">
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
                                                    'onChange' => 'saveKeluarga(this)',
                                                    'selected' => $val->jenis_kelamin,
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->tempat_lahir != $val->user_keluarga->tempat_lahir ? 'bg-changed' : '' }}">
                                                    <input name="tempat_lahir" value="{{ $val->tempat_lahir }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control datepicker" type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->tanggal_lahir != $val->user_keluarga->tanggal_lahir ? 'bg-changed' : '' }}">
                                                    <input name="tanggal_lahir" id="myDatepicker" value="{{ $val->tanggal_lahir }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->agama_id != $val->user_keluarga->agama_id ? 'bg-changed' : '' }}">
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'agama_id',
                                                    'items' => agama(),
                                                    'onChange' => 'saveKeluarga(this)',
                                                    'selected' => $val->agama_id,
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->pendidikan_id != $val->user_keluarga->pendidikan_id ? 'bg-changed' : '' }}">
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'pendidikan_id',
                                                    'items' => $pendidikan,
                                                    'onChange' => 'saveKeluarga(this)',
                                                    'selected' => $val->pendidikan_id,
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->jenis_pekerjaan != $val->user_keluarga->jenis_pekerjaan ? 'bg-changed' : '' }}">
                                                    <input name="jenis_pekerjaan" value="{{ $val->jenis_pekerjaan }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->status_perkawinan != $val->user_keluarga->status_perkawinan ? 'bg-changed' : '' }}">
                                                    <input name="status_perkawinan" value="{{ $val->status_perkawinan }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->hubungan_keluarga != $val->user_keluarga->hubungan_keluarga ? 'bg-changed' : '' }}">
                                                    <input name="hubungan_keluarga" value="{{ $val->hubungan_keluarga }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->kewarganegaraan != $val->user_keluarga->kewarganegaraan ? 'bg-changed' : '' }}">
                                                    <input name="kewarganegaraan" value="{{ $val->kewarganegaraan }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->no_paspor != $val->user_keluarga->no_paspor ? 'bg-changed' : '' }}">
                                                    <input name="no_paspor" value="{{ $val->no_paspor }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control" type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->no_kitas != $val->user_keluarga->no_kitas ? 'bg-changed' : '' }}">
                                                    <input name="no_kitas" value="{{ $val->no_kitas }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->ayah != $val->user_keluarga->ayah ? 'bg-changed' : '' }}">
                                                    <input name="ayah" value="{{ $val->ayah }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_keluarga_id && $val->user_keluarga && $val->ibu != $val->user_keluarga->ibu ? 'bg-changed' : '' }}">
                                                    <input name="ibu" value="{{ $val->ibu }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    @if($page == 'profile')
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->nama_lengkap) ? $val->nama_lengkap : ''}}', 'keluarga')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @if($page == 'profile')
                                            <tr>
                                                <td colspan="6" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Anggota Keluarga" onclick="saveNewUserKeluarga()" />
                                                </td>
                                                <td colspan="11" class="text-center">
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!-- =========================================================== -->
                            <!-- TAB JABATAN -->
                            <!-- =========================================================== -->
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
                                                <th style="min-width: 200px;">
                                                    Aksi
                                                </th>
                                            </tr>
                                            @foreach ($data->user_jabatan as $key => $val)
                                            @if (!$val->deleted_at || $val->user_jabatan_id)
                                            <tr  class="{{$val->deleted_at ? 'bg-deleted' : ''}} {{!$val->user_jabatan_id ? 'bg-added' : ''}}">
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td class="{{ $val->user_jabatan_id && $val->user_jabatan && $val->jabatan_id != $val->user_jabatan->jabatan_id ? 'bg-changed' : '' }}">
                                                    <select class="form-control form-select" name="jabatan_id" onChange="saveJabatan(this)" data-id="{{ $val->id }}">
                                                        <option value="">-= Pilih Jabatan =-</option>
                                                        {!! !empty($jabatan) && count($jabatan) > 0 ? treeSelectJabatan($jabatan, '', $val->jabatan_id) : '' !!}
                                                    </select>
                                                </td>
                                                <td class="{{ $val->user_jabatan_id && $val->user_jabatan && $val->dari_tahun != $val->user_jabatan->dari_tahun ? 'bg-changed' : '' }}">
                                                    <input name="dari_tahun" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_jabatan_id && $val->user_jabatan && $val->sampai_tahun != $val->user_jabatan->sampai_tahun ? 'bg-changed' : '' }}">
                                                    <input name="sampai_tahun" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_jabatan_id && $val->user_jabatan && $val->unit_kerja_id != $val->user_jabatan->unit_kerja_id ? 'bg-changed' : '' }}">
                                                    <select name="unit_kerja_id" class="form-control form-select" onChange="saveJabatan(this)" data-id="{{ $val->id }}">
                                                        <option value="">-= Pilih Unit Kerja =-</option>
                                                        {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', $val->unit_kerja_id) : '' !!}
                                                    </select>
                                                </td>
                                                <td class="{{ $val->user_jabatan_id && $val->user_jabatan && $val->tmt != $val->user_jabatan->tmt ? 'bg-changed' : '' }}">
                                                    <input name="tmt" id="myDatepicker" value="{{ $val->tmt }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    @if($page == 'profile')
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->jabatan->name) ? $val->jabatan->name : ''}}', 'jabatan')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @if($page == 'profile')
                                            <tr>
                                                <td colspan="7" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Riwayat Jabatan" onclick="saveNewUserJabatan()" />
                                                </td>
                                            </tr>
                                            @endif
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
                                                <th style="min-width: 200px;">
                                                    Aksi
                                                </th>
                                            </tr>
                                            @foreach ($data->user_jabatan_fungsional as $key => $val)
                                            @if (!$val->deleted_at || $val->user_jabatan_fungsional_id)
                                            <tr  class="{{$val->deleted_at ? 'bg-deleted' : ''}} {{!$val->user_jabatan_fungsional_id ? 'bg-added' : ''}}">
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td class="{{ $val->user_jabatan_fungsional_id && $val->user_jabatan_fungsional && $val->jabatan_fungsional_id != $val->user_jabatan_fungsional->jabatan_fungsional_id ? 'bg-changed' : '' }}">
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'jabatan_fungsional_id',
                                                    'items' => $jabatan_fungsional,
                                                    'onChange' => 'saveJabatanFungsional(this)',
                                                    'selected' => $val->jabatan_fungsional_id,
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td class="{{ $val->user_jabatan_fungsional_id && $val->user_jabatan_fungsional && $val->dari_tahun != $val->user_jabatan_fungsional->dari_tahun ? 'bg-changed' : '' }}">
                                                    <input name="dari_tahun" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatanFungsional(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_jabatan_fungsional_id && $val->user_jabatan_fungsional && $val->sampai_tahun != $val->user_jabatan_fungsional->sampai_tahun ? 'bg-changed' : '' }}">
                                                    <input name="sampai_tahun" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatanFungsional(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    @if($page == 'profile')
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->jabatan_fungsional->name) ? $val->jabatan_fungsional->name : ''}}', 'jabatan_fungsional')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @if($page == 'profile')
                                            <tr>
                                                <td colspan="7" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Riwayat Jabatan Fungsional" onclick="saveNewUserJabatanFungsional()" />
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>

                            </div>


                            <!-- =========================================================== -->
                            <!-- TAB GOLONGAN -->
                            <!-- =========================================================== -->
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
                                                <th style="min-width: 200px;">
                                                    Aksi
                                                </th>
                                            </tr>
                                            @foreach ($data->user_golongan as $key => $val)
                                            @if (!$val->deleted_at || $val->user_golongan_id)
                                            <tr  class="{{$val->deleted_at ? 'bg-deleted' : ''}} {{!$val->user_golongan_id ? 'bg-added' : ''}}">
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td class="{{ $val->user_golongan_id && $val->user_golongan && $val->golongan_id != $val->user_golongan->golongan_id ? 'bg-changed' : '' }}">
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'golongan_id',
                                                    'items' => $golongan,
                                                    'selected' => $val->golongan_id,
                                                    'onChange' => 'saveGolongan(this)',
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td class="{{ $val->user_golongan_id && $val->user_golongan && $val->dari_tahun != $val->user_golongan->dari_tahun ? 'bg-changed' : '' }}">
                                                    <input name="dari_tahun" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" onChange="saveGolongan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_golongan_id && $val->user_golongan && $val->sampai_tahun != $val->user_golongan->sampai_tahun ? 'bg-changed' : '' }}">
                                                    <input name="sampai_tahun" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" onChange="saveGolongan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td class="{{ $val->user_golongan_id && $val->user_golongan && $val->tmt != $val->user_golongan->tmt ? 'bg-changed' : '' }}">
                                                    <input name="tmt" value="{{ $val->tmt }}" data-id="{{ $val->id }}" id="myDatepicker" onChange="saveGolongan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    @if($page == 'profile')
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->golongan->name) ? $val->golongan->name : ''}}', 'golongan')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @if($page == 'profile')
                                            <tr>
                                                <td colspan="6" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Riwayat Golongan" onclick="saveNewUserGolongan()" />
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>



        <div class="card card-default">
            <div class="card-body">
                <div class="text-center">
                  @if($page == 'profile' && $data->status_sdm == 'new')
                      <a href="#" onClick="return request_approval()" class="btn btn-info"><i class="fa fa-check"></i> Minta Persetujuan</a>
                  @elseif($page != 'profile' && $data->status_sdm == 'new')
                      <a href="#" onClick="return warning()" class="btn btn-default"><i class="fa fa-check text-black"></i> Setujui Perubahan</a>
                  @elseif($page != 'profile' && $menu == 'sdm' && $data->status_sdm == 'request_approval')
                      <a href="#" onClick="return approve('sdm')" class="btn btn-info"><i class="fa fa-check"></i> Setujui Perubahan Data SDM</a>
                  @elseif($page != 'profile' && $menu == 'diklat' && $data->status_diklat == 'request_approval')
                      <a href="#" onClick="return approve('diklat')" class="btn btn-info"><i class="fa fa-check"></i> Setujui Perubahan Data Diklat</a>
                  @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

<style>
    @if ($data->status != 'approved')
    .bg-deleted {
        background: #ffaaaa;
    }

    .bg-added {
        background: #aaffaa;
    }

    .bg-changed input{
        background: #ffffaa !important;
    }
    @endif
</style>

@section('script')
@include('app.user.profile_edit.scripts.form')
@endsection
