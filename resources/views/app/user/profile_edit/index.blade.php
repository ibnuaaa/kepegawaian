@extends('layout.app')

@section('title', 'User')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

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
                        <span class="alert-inner--text"><strong>Informasi !</strong> Silahkan melakukan perubahan data anda. Data yang anda ketik langsung tersimpan pada server. Data akan diverifikasi oleh administrator. </span>
                    </div>

                    <div class="tab-menu-heading tab-menu-heading-boxed">
                        <div class="tabs-menu-boxed">
                            <ul class="nav panel-tabs">
                                <li><a href="/profile/personal/{{$id}}" {{ $tab == 'personal' ? 'class=active' : '' }}>Personal</a></li>
                                <li><a href="/profile/pendidikan/{{$id}}" {{ $tab == 'pendidikan' ? 'class=active' : '' }}>Pendidikan</a></li>
                                <li><a href="/profile/pelatihan/{{$id}}" {{ $tab == 'pelatihan' ? 'class=active' : '' }}>Pelatihan</a></li>
                                <li><a href="/profile/keluarga/{{$id}}" {{ $tab == 'keluarga' ? 'class=active' : '' }}>Keluarga</a></li>
                                <li><a href="/profile/jabatan/{{$id}}" {{ $tab == 'jabatan' ? 'class=active' : '' }}>Riwayat Jabatan</a></li>
                                <li><a href="/profile/golongan/{{$id}}" {{ $tab == 'golongan' ? 'class=active' : '' }}>Riwayat Golongan</a></li>
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
                                    <label class="col-md-2 form-label">Nama</label>
                                    <div class="col-md-9">
                                        {{ MyAccount()->name }}
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Username</label>
                                    <div class="col-md-9">
                                        <input name="username" value="{{ $data['username'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">NIP</label>
                                    <div class="col-md-9">
                                        {{ MyAccount()->nip }}
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">No KTP</label>
                                    <div class="col-md-9">
                                        <input name="no_ktp" value="{{ $data['no_ktp'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Tanggal Lahir</label>
                                    <div class="col-md-9">
                                        <input name="tanggal_lahir" id="myDatepicker" value="{{ $data['tanggal_lahir'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Tempat Lahir</label>
                                    <div class="col-md-9">
                                        <input name="tempat_lahir" value="{{ $data['tempat_lahir'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Alamat</label>
                                    <div class="col-md-9">
                                        <input name="alamat" value="{{ $data['alamat'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Kode Pos</label>
                                    <div class="col-md-9">
                                        <input name="kode_pos" value="{{ $data['kode_pos'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Telepon</label>
                                    <div class="col-md-9">
                                        <input name="telepon" value="{{ $data['telepon'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">HP</label>
                                    <div class="col-md-9">
                                        <input name="hp" value="{{ $data['hp'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">NPWP</label>
                                    <div class="col-md-9">
                                        <input name="npwp" value="{{ $data['npwp'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">No Rekening</label>
                                    <div class="col-md-9">
                                        <input name="no_rekening" value="{{ $data['no_rekening'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
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
                                <div class="row mb-4">
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



                                <div class=" row mb-4">
                                    <label class="col-md-2 form-label">Jabatan</label>
                                    <div class="col-md-9">
                                        <select class="form-control form-select" name="jabatan_id" onChange="savePersonal(this)">
                                            <option value="">-= Pilih Jabatan =-</option>
                                            {!! !empty($jabatan) && count($jabatan) > 0 ? treeSelectJabatan($jabatan, '', $data->jabatan_id) : '' !!}
                                        </select>
                                    </div>
                                </div>
                                <div class=" row mb-4">
                                    <label class="col-md-2 form-label">Unit Kerja</label>
                                    <div class="col-md-9">
                                        <select class="form-control form-select" name="unit_kerja_id" onChange="savePersonal(this)">
                                            <option value="">-= Pilih Unit Kerja =-</option>
                                            {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', $data->unit_kerja_id) : '' !!}
                                        </select>
                                    </div>
                                </div>
                                <div class=" row mb-4">
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
                                <div class=" row mb-4">
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
                                <div class="row mb-4">
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
                                <div class="row mb-4">
                                    <label class="col-md-2 form-label">Foto KTP</label>
                                    <div class="col-md-9">
                                        <input type="file" onchange="prepareUpload(this, 'foto_ktp{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}');" multiple>
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
                                        <input type="file" onchange="prepareUpload(this, 'foto_npwp{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}');" multiple>
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
                                        <input type="file" onchange="prepareUpload(this, 'foto_bpjs{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}');" multiple>
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
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            @component('components.form.awesomeSelect', [
                                            'name' => 'pendidikan_id',
                                            'items' => $pendidikan,
                                            'onChange' => 'savePendidikan(this)',
                                            'selected' => $val->pendidikan_id,
                                            'data_id' => $val->id
                                            ])
                                            @endcomponent
                                        </td>
                                        <td>
                                            <input name="pendidikan_detail" value="{{ $val->pendidikan_detail }}" data-id="{{ $val->id }}" onChange="savePendidikan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td>
                                            <input name="no_ijazah" value="{{$val->no_ijazah ? $val->no_ijazah : ''}}" data-id="{{ $val->id }}" onChange="savePendidikan(this)" class="form-control" type="text" required>
                                        </td>
                                        <td>
                                            <input name="tahun_lulus" value="{{$val->tahun_lulus ? $val->tahun_lulus : ''}}" data-id="{{ $val->id }}" onChange="savePendidikan(this)" class="form-control" type="text" required>
                                        </td>
                                        <td>
                                            <input type="file" onchange="prepareUpload(this, 'foto_ijazah{{ !$id ? '_request' : '' }}', '{{ $val->id }}');" multiple>
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
                                            <a onClick="return remove('{{$val->id}}','{{!empty($val->pendidikan->name) ? $val->pendidikan->name : ''}}', 'pendidikan')" href="#" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>

                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="text-left">
                                            <input type="button" class="btn btn-primary" value="Tambah Riwayat Pendidikan" onclick="saveNewUserPendidikan()" />
                                        </td>
                                    </tr>
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
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            <input name="nama_sertifikat" value="{{ $val->nama_sertifikat }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td>
                                            <input name="no_sertifikat" value="{{ $val->no_sertifikat }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td>
                                            <input name="tahun" value="{{ $val->tahun }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                        </td>
                                        <td>
                                            <input type="file" onchange="prepareUpload(this, 'foto_sertifikat{{ !$id ? '_request' : '' }}', '{{ $val->id }}');" multiple>
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
                                            <a onClick="return remove('{{$val->id}}','{{!empty($val->nama_sertifikat) ? $val->nama_sertifikat : ''}}', 'pelatihan')" href="#" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-left">
                                            <input type="button" class="btn btn-primary" value="Tambah Riwayat Pelatihan" onclick="saveNewUserPelatihan()" />
                                        </td>
                                    </tr>
                                </table>
                            </div>


                            <!-- =========================================================== -->
                            <!-- TAB KELUARGA -->
                            <!-- =========================================================== -->
                            <div class="tab-pane  {{ $tab == 'keluarga' ? 'active' : '' }}" id="tab-keluarga">
                                <h2>Keluarga</h2>
                                <br />
                                <h4>Upload Foto KK (PDF)</h4>
                                <input type="file" onchange="prepareUpload(this, 'foto_kk{{ !$id ? '_request' : '' }}', '{{ $data['id'] }}');" multiple>
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
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    <input name="nama_lengkap" value="{{ $val->nama_lengkap }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="nik" value="{{ $val->nik }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
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
                                                <td>
                                                    <input name="tempat_lahir" value="{{ $val->tempat_lahir }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control datepicker" type="text" required>
                                                </td>
                                                <td>
                                                    <input name="tanggal_lahir" id="myDatepicker" value="{{ $val->tanggal_lahir }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'agama_id',
                                                    'items' => agama(),
                                                    'onChange' => 'saveKeluarga(this)',
                                                    'selected' => $val->agama_id,
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td>
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'pendidikan_id',
                                                    'items' => $pendidikan,
                                                    'onChange' => 'saveKeluarga(this)',
                                                    'selected' => $val->pendidikan_id,
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td>
                                                    <input name="jenis_pekerjaan" value="{{ $val->jenis_pekerjaan }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="status_perkawinan" value="{{ $val->status_perkawinan }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="hubungan_keluarga" value="{{ $val->hubungan_keluarga }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="kewarganegaraan" value="{{ $val->kewarganegaraan }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="no_paspor" value="{{ $val->no_paspor }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control" type="text" required>
                                                </td>
                                                <td>
                                                    <input name="no_kitas" value="{{ $val->no_kitas }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="ayah" value="{{ $val->ayah }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="ibu" value="{{ $val->ibu }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->nama_lengkap) ? $val->nama_lengkap : ''}}', 'keluarga')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Anggota Keluarga" onclick="saveNewUserKeluarga()" />
                                                </td>
                                                <td colspan="11" class="text-center">
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    <select class="form-control form-select" name="jabatan_id" onChange="saveJabatan(this)" data-id="{{ $val->id }}">
                                                        <option value="">-= Pilih Jabatan =-</option>
                                                        {!! !empty($jabatan) && count($jabatan) > 0 ? treeSelectJabatan($jabatan, '', $val->jabatan_id) : '' !!}
                                                    </select>
                                                </td>
                                                <td>
                                                    <input name="dari_tahun" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="sampai_tahun" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <select class="form-control form-select" name="unit_kerja_id" onChange="saveJabatan(this)" data-id="{{ $val->id }}">
                                                        <option value="">-= Pilih Unit Kerja =-</option>
                                                        {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', $val->unit_kerja_id) : '' !!}
                                                    </select>
                                                </td>
                                                <td>
                                                    <input name="tmt" id="myDatepicker" value="{{ $val->tmt }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->jabatan->name) ? $val->jabatan->name : ''}}', 'jabatan')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="7" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Riwayat Jabatan" onclick="saveNewUserJabatan()" />
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'jabatan_fungsional_id',
                                                    'items' => $jabatan_fungsional,
                                                    'onChange' => 'saveJabatanFungsional(this)',
                                                    'selected' => $val->jabatan_fungsional_id,
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td>
                                                    <input name="dari_tahun" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatanFungsional(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="sampai_tahun" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatanFungsional(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->jabatan_fungsional->name) ? $val->jabatan_fungsional->name : ''}}', 'jabatan_fungsional')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="7" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Riwayat Jabatan Fungsional" onclick="saveNewUserJabatanFungsional()" />
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    @component('components.form.awesomeSelect', [
                                                    'name' => 'golongan_id',
                                                    'items' => $golongan,
                                                    'selected' => $val->golongan_id,
                                                    'onChange' => 'saveGolongan(this)',
                                                    'data_id' => $val->id
                                                    ])
                                                    @endcomponent
                                                </td>
                                                <td>
                                                    <input name="dari_tahun" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" onChange="saveGolongan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="sampai_tahun" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" onChange="saveGolongan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <input name="tmt" value="{{ $val->tmt }}" data-id="{{ $val->id }}" id="myDatepicker" onChange="saveGolongan(this)" class="form-control " type="text" required>
                                                </td>
                                                <td>
                                                    <a onClick="return remove('{{$val->id}}','{{!empty($val->golongan->name) ? $val->golongan->name : ''}}', 'golongan')" href="#" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6" class="text-left">
                                                    <input type="button" class="btn btn-primary" value="Tambah Riwayat Golongan" onclick="saveNewUserGolongan()" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="pull-right">
                              <a href="#" onClick="return approve()" class="btn btn-info"><i class="fa fa-check"></i> Setujui <span class="d-none d-sm-inline">Perubahan Data</span></a>
                              <a href="#" class="btn btn-danger"><i class="fa fa-times"></i> Tolak <span class="d-none d-sm-inline">Perubahan Data</span></a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@include('app.user.profile_edit.scripts.form')
@endsection
