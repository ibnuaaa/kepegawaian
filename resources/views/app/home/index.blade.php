@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Home</a></li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">

                <div class="card overflow-hidden">
                    <div class="card-body text-center" style="font-size: 20px;">
                        <iframe style="width:100%;height:1000px;" src="" id="dashboard_iframe"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ROW-1 END -->

@endsection

@section('script')
@include('app.home.scripts.form')
@endsection
