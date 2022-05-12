@extends('layout.app')

@section('title', 'Complaint '.$data['name'])
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Complaint</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/complaint">Complaint</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Complaint</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<!-- Row -->
<div class="row">
    <div class="col-xl-3">
        <div class="card">
            @include('app.complaint.home.menu')
        </div>
    </div>
    <div class="col-xl-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $data->title }}</h3>
            </div>
            <div class="card-body">




                <div class="email-media">
                    <div class="mt-0 d-sm-flex">
                        <img class="me-2 rounded-circle avatar avatar-lg" src="../assets/images/users/6.jpg" alt="avatar">
                        <div class="media-body pt-0">
                            <div class="float-end d-none d-md-flex fs-15">
                                <small class="me-3 mt-3 text-muted">{{ dateIndo($data->created_at) }} {{ jamIndo($data->created_at) }}</small>
                            </div>
                            <div class="media-title text-dark font-weight-semibold mt-1">{{$data->from_user->name}}</div>
                            <small class="mb-0">to ... </small>
                            <small class="me-2 d-md-none">{{ dateIndo($data->created_at) }} {{ jamIndo($data->created_at) }}</small>
                        </div>
                    </div>
                </div>
                <div class="eamil-body mt-5 row">




                    <div class="col-md-9">
                        {{ $data->description }}

                        <hr>
                        @if (!empty($data->foto_complaint))
                        <div class="email-attch">
                            <p class="font-weight-semibold">{{ count($data->foto_complaint) }} Attachments</p>
                        </div>
                        @endif
                        <div class="row attachments-doc">

                            <div class="img-preview mt-2">
                                @if (!empty($data->foto_complaint))
                                @foreach ($data->foto_complaint as $key => $val2)
                                <div style='float:left;position:relative;'>
                                    <img src="/api/preview/{{$val2->storage->key}}" alt="avatar-img" style="max-width: 200px;max-height: 200px;">
                                </div>
                                @endforeach
                                @endif
                                <div style="clear: both;"></div>
                            </div>

                        </div>
                        <br><br>
                    </div>

                    <div class="col-md-3">
                    Status : <label class="badge bg-warning badge-sm  me-1 mb-1 mt-1">{{ complaintStatus($data->status) }}</label>
                    <br /><br />



                    @if ($data->complaint_user_resolve)
                    Diproses Oleh<br>
                    <ul class="list-group">
                    @foreach($data->complaint_user_resolve as $key => $val)

                    <li class="listunorder">{{ $val->user->name }} <br><i>({{ $val->created_at }})</i></li>

                    @endforeach
                    </ul>
                    @endif

                    </div>



                </div>
            </div>
            <div class="card-footer">

                <?php

                $is_processed = 0;
                foreach($data->complaint_user_resolve as $key => $val){
                  if ($val->user_id == MyAccount()->id) $is_processed = 1;
                }
                ?>


                @if ($menu == 'inbox')
                @if (!$is_processed) <a class="btn btn-primary mt-1 mb-1" href="#" onClick="return process()"><i class="fa fa-reply"></i> Saya Proses</a> @endif
                @if ($is_processed)
                  @if ($data->status == '3')
                    <a class="btn btn-primary mt-1 mb-1" href="#" onClick="return finish()"><i class="fa fa-reply"></i> Selesai Pengerjaan</a>
                  @endif
                @endif
                @endif
                <a class="btn btn-secondary mt-1 mb-1" href="#"  onClick="return forward()"><i class="fa fa-share"></i> Forward</a>
            </div>
        </div>

        @foreach ($data->complaint_reply as $key => $val)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Balasan</h3>
            </div>
            <div class="card-body">
                <div class="email-media">
                    <div class="mt-0 d-sm-flex">
                        <img class="me-2 rounded-circle avatar avatar-lg" src="../assets/images/users/6.jpg" alt="avatar">
                        <div class="media-body pt-0">
                            <div class="float-end d-none d-md-flex fs-15">
                                <small class="me-3 mt-3 text-muted">{{ dateIndo($val->created_at) }} {{ jamIndo($val->created_at) }}</small>
                            </div>
                            <div class="media-title text-dark font-weight-semibold mt-3">{{$data->from_user->name}}</div>
                            <small class="me-2 d-md-none">{{ dateIndo($val->created_at) }} {{ jamIndo($val->created_at) }}</small>
                        </div>
                    </div>
                </div>
                <div class="eamil-body mt-5">

                    {{ $val->message }}

                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
        @endforeach




        @if (!in_array($data->status, [1,99]))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Balasan</h3>
            </div>
            <div class="card-body">
                <div class="eamil-body">
                    <textarea class="form-control" name="message"></textarea>
                </div>
            </div>
            <div class="card-footer">
              <a class="btn btn-secondary mt-1 mb-1 pull-right" href="#" onClick="return saveReply()"><i class="fa fa-save"></i> Simpan</a>
            </div>
        </div>
        @endif


    </div>
</div>
<!--End  Row -->

@endsection


@section('formValidationScript')
@include('app.complaint.detail.scripts.form')
@include('app.complaint.home.scripts.index')
@endsection
