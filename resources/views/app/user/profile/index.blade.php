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
            <div class=" row">
                <label class="col-md-2 form-label">Nama</label>
                <div class="col-md-10">
                    {{ $data->name }}
                </div>
            </div>
            <div class=" row">
                <label class="col-md-2 form-label">Jabatan</label>
                <div class="col-md-10">
                    <?php echo $data->position['name']; ?>
                </div>
            </div>
            <div class=" row">
                <label class="col-md-2 form-label">Username</label>
                <div class="col-md-10">
                    {{ $data->username }}
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
