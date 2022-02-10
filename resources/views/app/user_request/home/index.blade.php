@extends('layout.app')

@section('title', 'UserRequest')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">UserRequest
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">UserRequest</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        @component('components.table', ['data' => $data, 'props' => []])
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
                <p>{{ !empty($item->status) ? $item->status : '' }}</p>
            </td>
            <td class="v-align-middle">
                <p>{{ $item->created_at }}</p>
            </td>
            <td class="v-align-middle">
                <div class="btn-group btn-group-sm">
                    <a href="{{ url('/user_request/'.$item->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
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
