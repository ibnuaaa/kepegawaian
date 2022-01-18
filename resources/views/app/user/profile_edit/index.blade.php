@extends('layout.app')

@section('title', 'User')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Ubah Data User</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                            <span class="alert-inner--icon"><i class="fe fe-bell" ></i></span>
                            <span class="alert-inner--text"><strong>Informasi !</strong> Silahkan melakukan perubahan data anda. Data yang anda ketik langsung tersimpan pada server. Data akan diverifikasi oleh administrator. </span>
                        </div>


                        <div class="tab-menu-heading tab-menu-heading-boxed">
                            <div class="tabs-menu-boxed">
                                <ul class="nav panel-tabs">
                                    <li><a href="/profile/personal" {{ $tab == 'personal' ? 'class=active' : '' }}>Personal</a></li>
                                    <li><a href="/profile/pendidikan" {{ $tab == 'pendidikan' ? 'class=active' : '' }}>Pendidikan</a></li>
                                    <li><a href="/profile/pelatihan" {{ $tab == 'pelatihan' ? 'class=active' : '' }}>Pelatihan</a></li>
                                    <li><a href="/profile/keluarga" {{ $tab == 'keluarga' ? 'class=active' : '' }}>Keluarga</a></li>
                                    <li><a href="/profile/jabatan" {{ $tab == 'jabatan' ? 'class=active' : '' }}>Riwayat Jabatan</a></li>
                                    <li><a href="/profile/golongan" {{ $tab == 'golongan' ? 'class=active' : '' }}>Riwayat Golongan</a></li>
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
                                            <input name="name" value="{{ $data['name'] }}" onChange="savePersonal(this)" onChange="savePersonal(this)" class="form-control" type="text" required>
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
                                            <input name="nip" value="{{ $data['nip'] }}" onChange="savePersonal(this)" class="form-control" type="text" required>
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
                                                <input name="nama_sertifikat" value="{{ $val->nama_sertifikat }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                            </td>
                                            <td>
                                                <input name="no_sertifikat" value="{{ $val->no_sertifikat }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
                                            </td>
                                            <td>
                                                <input name="tahun" value="{{ $val->tahun }}" data-id="{{ $val->id }}" onChange="savePelatihan(this)" class="form-control " type="text" required>
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
                                                        <input name="tempat_lahir"  value="{{ $val->tempat_lahir }}" data-id="{{ $val->id }}" onChange="saveKeluarga(this)" class="form-control datepicker" type="text" required>
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
                                                        @component('components.form.awesomeSelect', [
                                                            'name' => 'position_id',
                                                            'items' => $positions,
                                                            'onChange' => 'saveJabatan(this)',
                                                            'selected' => $val->position_id,
                                                            'data_id' => $val->id
                                                        ])
                                                        @endcomponent
                                                    </td>
                                                    <td>
                                                        <input name="dari_tahun" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="sampai_tahun" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        @component('components.form.awesomeSelect', [
                                                            'name' => 'unit_kerja_id',
                                                            'items' => $unit_kerja,
                                                            'onChange' => 'saveJabatan(this)',
                                                            'selected' => $val->unit_kerja_id,
                                                            'data_id' => $val->id
                                                        ])
                                                        @endcomponent
                                                    </td>
                                                    <td>
                                                        <input name="tmt" id="myDatepicker" value="{{ $val->tmt }}" data-id="{{ $val->id }}" onChange="saveJabatan(this)" class="form-control " type="text" required>
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
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.profile_edit.scripts.form')
@endsection
