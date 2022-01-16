@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Profil User</h1>
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
            <div class="row">
                <div class="col-6 col-lg-2">
                    <div class="form-group">
                        <label>Nama</label>
                    </div>
                </div>
                <div class="col-6 col-lg-10">
                    <div class="form-group form-group-default">
                        {{ $data->name }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-2">
                    <div class="form-group">
                        <label>Jabatan</label>
                    </div>
                </div>
                <div class="col-6 col-lg-10">
                    <div class="form-group form-group-default">
                        <?php echo $data->position['name']; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-2">
                    <div class="form-group">
                        <label>Username</label>
                    </div>
                </div>
                <div class="col-6 col-lg-10">
                    <div class="form-group form-group-default">
                        {{ $data->username }}
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
