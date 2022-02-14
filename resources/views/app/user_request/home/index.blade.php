@extends('layout.app')

@section('title', 'UserRequest')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">User Request
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Request</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">

        @if ($status == 'new')
        <div class="alert alert-info" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-info"></i></span>
            <span class="alert-inner--text"><strong>Perhatian !</strong> Di bawah ini adalah daftar user yang belum menge-klik tombol "Minta Persetujuan" pada profil user. Terimakasih </span>
        </div>
        @endif

        @component('components.table', ['data' => $data, 'props' => ['menu' => $menu]])
        @scopedslot('head', ($item))
        @if($item->name === 'No')
        <th style="width: 3%">{{ $item->label }}</th>
        @elseif ($item->name === 'action')
        <th style="width: 112px">{{ $item->label }}</th>
        @else
        <th>
            {{ $item->label }}
        </th>
        @endif
        @endscopedslot
        @scopedslot('record', ($item, $props, $number))
        <tr>
            <td class="v-align-middle ">
                <p>{{ $number }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ !empty($item->user->name) ? $item->user->name : '' }}</p>
            </td>
            <td class="v-align-middle ">
                @if ($item->status_sdm == 'new')
                    <span class="badge bg-default badge-sm  me-1 mb-1 mt-1">Draft</span>
                @else
                    @if ($item->status_sdm == 'request_approval')
                        <span class="badge bg-warning badge-sm  me-1 mb-1 mt-1">Pending SDM</span>
                    @endif
                    @if ($item->status_sdm == 'approved')
                        <span class="badge bg-success badge-sm  me-1 mb-1 mt-1">Approved SDM</span>
                    @endif
                    @if ($item->status_diklat == 'request_approval')
                        <span class="badge bg-warning badge-sm  me-1 mb-1 mt-1">Pending Diklat</span>
                    @endif
                    @if ($item->status_diklat == 'approved')
                        <span class="badge bg-success badge-sm  me-1 mb-1 mt-1">Approved Diklat</span>
                    @endif
                @endif
            </td>
            <td class="v-align-middle">
                <p>{{ $item->created_at }}</p>
            </td>
            <td class="v-align-middle">
                <div class="btn-group btn-group-sm">
                    <a href="{{ url('/user_request/'.$props['menu'].'/'.$item->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                </div>
            </td>
        </tr>
        @endscopedslot
        @endcomponent
    </div>
</div>
<!-- ROW-1 END -->
</div>


@endsection

@section('script')
@include('app.user_request.home.scripts.index')
@endsection
