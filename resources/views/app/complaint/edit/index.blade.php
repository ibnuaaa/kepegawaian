@extends('layout.app')

@section('title', 'Complaint')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Edit Complaint</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/complaint">Complaint</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Complaint</li>
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
                <h3 class="card-title">Compose new message</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <label class="col-xl-2 form-label">To</label>
                            <div class="col-xl-10">



                                <select class="form-control" onChange="saveEditDestination(this)" name="to_unit_kerja_id"></select>


                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <label class="col-xl-2 form-label">Sifat</label>
                            <div class="col-xl-10">
                                <select class="form-control" onChange="saveEdit(this)" name="urgency_type">
                                  <option>-= Pilih =-</option>
                                  <option value="1">Sangat Segera</option>
                                  <option value="2">Segera</option>
                                  <option value="3">Biasa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <label class="col-xl-2 form-label">Subject</label>
                            <div class="col-xl-10">
                                <input type="text" onChange="saveEdit(this)" name="title" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row ">
                            <label class="col-xl-2 form-label">Message</label>
                            <div class="col-xl-10">
                                <textarea rows="10" onChange="saveEdit(this)" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-sm-flex">
                <div class="mt-2 mb-2">
                    <a href="javascript:void(0)" class="btn btn-icon btn-white btn-svg" data-bs-toggle="tooltip" title="" data-bs-original-title="Attach"><span class="ri-attachment-2"></span></a>
                    <a href="javascript:void(0)" class="btn btn-icon btn-white btn-svg" data-bs-toggle="tooltip" title="" data-bs-original-title="Link"><span class="ri-link"></span></a>
                    <a href="javascript:void(0)" class="btn btn-icon btn-white btn-svg" data-bs-toggle="tooltip" title="" data-bs-original-title="Photos"><span class="ri-image-line"></span></a>
                    <a href="javascript:void(0)" class="btn btn-icon btn-white btn-svg" data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"><span class="ri-delete-bin-line"></span></a>
                </div>
                <div class="btn-list ms-auto my-auto">
                    <button class="btn btn-danger btn-space mb-0">Cancel</button>
                    <button class="btn btn-primary btn-space mb-0">Send message</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Row -->

@endsection

@section('formValidationScript')
@include('app.complaint.home.scripts.index')
@include('app.complaint.edit.scripts.form')
@endsection
