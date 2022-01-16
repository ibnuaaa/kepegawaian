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
                                    <li><a href="#tab25" class="active" data-bs-toggle="tab">Personal</a></li>
                                    <li><a href="#tab26" data-bs-toggle="tab">Pendidikan</a></li>
                                    <li><a href="#tab27" data-bs-toggle="tab">Pelatihan</a></li>
                                    <li><a href="#tab28" data-bs-toggle="tab">Keluarga</a></li>
                                    <li><a href="#tab28" data-bs-toggle="tab">Riwayat Jabatan</a></li>
                                    <li><a href="#tab28" data-bs-toggle="tab">Riwayat Golongan</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab25">
                                    <div class="form-group form-group-default required ">
                                        <label>Nama</label>
                                        <input name="name" value="{{ $data['name'] }}" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group form-group-default required ">
                                        <label>Username</label>
                                        <input name="username" value="{{ $data['username'] }}" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group form-group-default required ">
                                        <label>NIP</label>
                                        <input name="nip" value="{{ $data['nip'] }}" class="form-control" type="text" required>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane" id="tab26">
                                    <p> default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected
                                        humour and the like</p>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et</p>
                                </div>
                                <div class="tab-pane" id="tab27">
                                    <p>over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et</p>
                                </div>
                                <div class="tab-pane" id="tab28">
                                    <p>page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes
                                        by accident, sometimes on purpose (injected humour and the like</p>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et</p>
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
