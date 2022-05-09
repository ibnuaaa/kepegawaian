@extends('layout.app')

@section('title', 'User '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">User</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
        <div class="card card-default m-t-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="font-montserrat all-caps hint-text">User Detail</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Nama
                    </div>
                    <div class="col-md-6">
                        {{ $data['name'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Username
                    </div>
                    <div class="col-md-6">
                        {{ $data['username'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        NIP
                    </div>
                    <div class="col-md-6">
                        {{ $data['nip'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Email / Nomor Telepon
                    </div>
                    <div class="col-md-6">
                        {{ $data['email'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        Posisi
                    </div>
                    <div class="col-md-6">
                        {{ $data['position']['name'] }}
                    </div>
                </div>
            </div>




            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-right">
                        <span style="display: none" id="text_new_pass">
                            Password Baru untuk user adalah
                        </span>
                        <span style="display: none; font-size: 30px" class="bold" id="new_pass">
                        </span>
                    </div>
                    <div class="col-md-6">
                        <!-- @if (!empty($data['status']) && $data['status'] == 'active')
                        <input type="button" class="btn btn-danger pull-right" value="Inactive" onClick="inactiveUser('inactive')" />
                        @else
                        <input type="button" class="btn btn-primary pull-right" value="Active" onClick="inactiveUser('active')" />
                        @endif -->
                        <input type="button" class="btn btn-primary pull-right m-r-5" value="Reset Password" onClick="resetPassword()" />
                    </div>
                </div>
            </div>
        </div>
    </div>






    <div class="col-md-6">
          <div class="row m-t-20">
              <div class="col-md-12">


                  <div class="card card-default">
                      <div class="card-header  ">
                          <div class="card-title">
                              Multi Jabatan
                          </div>
                      </div>
                      <div class="card-body">


                          <table class="table table-bordered table-condensed">
                              <tr>
                                  <th style="width: 10%;">
                                      No
                                  </th>
                                  <th style="width: 40%;">
                                      Jabatan
                                  </th>
                                  <th style="width: 20%;">
                                      Tipe
                                  </th>
                                  <th style="width: 30%;">
                                      Action
                                  </th>
                              </tr>

                              <tr class="hide" id="inputFormContainer">
                                  <td colspan="4">
                                      <select name="position_id" class="form-control" style="width: 100%">
                                      </select>

                                      <div class="row">
                                          <div class="col-md-6">
                                              <input class="btn btn-danger btn-block" type="button" value= "Batal" onClick="cancelSavePLT()" style="margin-top: 10px;">
                                          </div>
                                          <div class="col-md-6">
                                              <input class="btn btn-primary btn-block" type="button" value= "Simpan" onClick="savePLT()" style="margin-top: 10px;">
                                          </div>
                                      </div>

                                  </td>
                              </tr>

                              <tr id="buttonAddContainer">
                                  <td colspan="4">
                                      <a href="#" class="btn btn-primary btn-block" onClick="return openInputForm()" style="margin-top: 10px;">
                                          <i class="fa fa-plus text-white"></i> Add
                                      </a>
                                  </td>
                              </tr>

                              @if (!empty($data->plt))
                                  @foreach ($data->plt as $key => $value)
                                  <tr>
                                      <td>
                                          {{ $key+1 }}
                                      </td>
                                      <td colspan="2">
                                          {{ $value->jabatan ? $value->jabatan->name : '' }}
                                      </td>
                                      <td>
                                          <div class="row">
                                              <div class="col-md-12">
                                                  <a href="#" class="btn btn-danger btn-block btn-xs m-r-10" onClick="return deletePLT('{{$value->id}}')" style="margin-top: 10px;">
                                                      <i class="fa fa-trash text-white"></i>
                                                  </a>
                                              </div>
                                          </div>
                                      </td>
                                  </tr>
                                  @endforeach
                              @endif

                          </table>
                      </div>
                  </div>

              </div>
          </div
      </div>
  </div>

</div>

@endsection

@section('script')
@include('app.user.detail.home.scripts.index')
@endsection
