@extends('layout.app')

@section('title', 'AuditTrail')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">AuditTrail
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">AuditTrail</li>
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
        <th style="position: relative;cursor: pointer" onClick="sortBy('{{ $item->name }}', '{{ !empty($_GET['sort_type']) ? $_GET['sort_type'] : '' }}' )">
            {{ $item->label }}
            <?php if(!empty($_GET['sort_type']) && $_GET['sort_type'] == 'asc' && $_GET['sort'] == $item->name): ?>
            <span>
                <i class="fa fa-sort-asc" style="position: absolute;top: 10px;right: 10px;color: #757575;"></i>
            </span>
            <?php elseif(!empty($_GET['sort_type']) && $_GET['sort_type'] == 'desc' && $_GET['sort'] == $item->name): ?>
            <span>
                <i class="fa fa-sort-desc" style="position: absolute;top: 18px;right: 10px;color: #757575;"></i>
            </span>
            <?php else: ?>
            <span>
                <i class="fa fa-sort text-grey" style="position: absolute;top: 10px;right: 10px;color: #757575;"></i>
            </span>
            <?php endif; ?>
        </th>
        @endif
        @endscopedslot
        @scopedslot('record', ($item, $props, $number))
        <tr>
            <td class="v-align-middle">
                <p>{{ $item->created_at }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->primary_id }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->modul }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->activity }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->ip_client }}</p>
            </td>
        </tr>
        <tr>
            <td class="v-align-middle" colspan="5" style="white-space: normal !important;">
                  <div style="width: 1000px;">
                  API:<br/>
                  [{{$item->method}}] {{ $item->uri }}

                  <br/><br/>
                  <span class="text-bold">Request:</span><br/>
                  {{ $item->data }}

                  <br/><br/>
                  <span class="text-bold">Response :</span><br/>
                  {{ $item->response }}
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
@include('app.audit_trail.home.scripts.index')
@endsection
