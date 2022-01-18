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
                                <div class="tab-pane active" id="tab-personal">

                                    <h2>Personal</h2>

                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Nama</label>
                                        <div class="col-md-9">
                                            <input name="name" value="{{ $data['name'] }}" onkeyup="savePersonal(this)" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Username</label>
                                        <div class="col-md-9">
                                            <input name="username" value="{{ $data['username'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">NIP</label>
                                        <div class="col-md-9">
                                            <input name="nip" value="{{ $data['nip'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">No KTP</label>
                                        <div class="col-md-9">
                                            <input name="no_ktp" value="{{ $data['no_ktp'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Tanggal Lahir</label>
                                        <div class="col-md-9">
                                            <input name="tanggal_lahir" value="{{ $data['tanggal_lahir'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Tempat Lahir</label>
                                        <div class="col-md-9">
                                            <input name="tanggal_lahir" value="{{ $data['tanggal_lahir'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Alamat</label>
                                        <div class="col-md-9">
                                            <input name="alamat" value="{{ $data['alamat'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Kode Pos</label>
                                        <div class="col-md-9">
                                            <input name="kode_pos" value="{{ $data['kode_pos'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Telepon</label>
                                        <div class="col-md-9">
                                            <input name="telepon" value="{{ $data['telepon'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">HP</label>
                                        <div class="col-md-9">
                                            <input name="hp" value="{{ $data['hp'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">NPWP</label>
                                        <div class="col-md-9">
                                            <input name="npwp" value="{{ $data['npwp'] }}" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">No Rekening</label>
                                        <div class="col-md-9">
                                            <input name="no_rekening" value="{{ $data['no_rekening'] }}" class="form-control" type="text" required>
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
                                                'selected' => $data->status_perkawinan_id
                                            ])
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Golongan</label>
                                        <div class="col-md-9">
                                            {{ $data->user_golongan && count($data->user_golongan) > 0 ? $data->user_golongan[count($data->user_golongan) - 1]->golongan->name : '<Kosong>' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Unit Kerja</label>
                                        <div class="col-md-9">
                                            {{ $data->user_jabatan && count($data->user_jabatan) > 0 ? $data->user_jabatan[count($data->user_jabatan) - 1]->unit_kerja->name : '<Kosong>' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Pendidikan</label>
                                        <div class="col-md-9">
                                            {{ $data->user_jabatan && count($data->user_pendidikan) > 0 ? $data->user_pendidikan[count($data->user_pendidikan) - 1]->pendidikan->name : '<Kosong>' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-md-2 form-label">Gender</label>
                                        <div class="col-md-9">
                                            @component('components.form.awesomeSelect', [
                                                'name' => 'gender',
                                                'items' => [
                                                    [
                                                        'value' => 'm',
                                                        'label' => 'Laki-laki'
                                                    ],
                                                    [
                                                        'value' => 'f',
                                                        'label' => 'Perempuan'
                                                    ],
                                                ],
                                                'selected' => $data->gender
                                            ])
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-pendidikan">
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
                                                    'name' => 'gender',
                                                    'items' => $pendidikan,
                                                    'selected' => $val->pendidikan_id
                                                ])
                                                @endcomponent
                                            </td>
                                            <td>
                                                <input name="pendidikan_detail" value="{{ $val->pendidikan_detail }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                            </td>
                                            <td>
                                                <input name="pendidikan_detail" value="{{$val->no_ijazah ? $val->no_ijazah : ''}}" data-id="{{ $val->id }}" class="form-control" type="text" required>
                                            </td>
                                            <td>
                                                <input name="pendidikan_detail" value="{{$val->tahun_lulus ? $val->tahun_lulus : ''}}" data-id="{{ $val->id }}" class="form-control" type="text" required>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab-pelatihan">
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
                                                <input name="pendidikan_detail" value="{{ $val->nama_sertifikat }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                            </td>
                                            <td>
                                                <input name="pendidikan_detail" value="{{ $val->no_sertifikat }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                            </td>
                                            <td>
                                                <input name="pendidikan_detail" value="{{ $val->tahun }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>

                                </div>
                                <div class="tab-pane" id="tab-keluarga">
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
                                                      <input name="pendidikan_detail" value="{{ $val->nama_lengkap }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                      <input name="pendidikan_detail" value="{{ $val->nik }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        @component('components.form.awesomeSelect', [
                                                            'name' => 'gender',
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
                                                            'selected' => $val->jenis_kelamin
                                                        ])
                                                        @endcomponent
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail"  value="{{ $val->tempat_lahir }}" data-id="{{ $val->id }}" class="form-control datepicker" type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" id="myDatepicker" value="{{ $val->tanggal_lahir }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        @component('components.form.awesomeSelect', [
                                                            'name' => 'gender',
                                                            'items' => agama(),
                                                            'selected' => $val->agama_id
                                                        ])
                                                        @endcomponent
                                                    </td>
                                                    <td>
                                                        @component('components.form.awesomeSelect', [
                                                            'name' => 'pendidikan',
                                                            'items' => $pendidikan,
                                                            'selected' => $val->pendidikan_id
                                                        ])
                                                        @endcomponent
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->jenis_pekerjaan }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->status_perkawinan }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->hubungan_keluarga }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->kewarganegaraan }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->no_paspor }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->no_kitas }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->ayah }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->ibu }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-jabatan">
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
                                                            'name' => 'gender',
                                                            'items' => $positions,
                                                            'selected' => $val->position_id
                                                        ])
                                                        @endcomponent
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        @component('components.form.awesomeSelect', [
                                                            'name' => 'unit_kerja',
                                                            'items' => $unit_kerja,
                                                            'selected' => $val->unit_kerja_id
                                                        ])
                                                        @endcomponent
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->tmt }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane" id="tab-golongan">
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
                                                          'name' => 'gender',
                                                          'items' => $golongan,
                                                          'selected' => $val->golongan_id
                                                      ])
                                                      @endcomponent
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->dari_tahun }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->sampai_tahun }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
                                                    </td>
                                                    <td>
                                                        <input name="pendidikan_detail" value="{{ $val->tmt }}" data-id="{{ $val->id }}" class="form-control " type="text" required>
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
        </div>
    </div>
@endsection

@section('script')
    @include('app.user.profile_edit.scripts.form')
@endsection
