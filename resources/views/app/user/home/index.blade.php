@extends('layout.app')

@section('title', 'User')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">
        User
        <a href="/user/new" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i>
            Buat User
        </a>
    </h1>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        @component('components.table', ['data' => $data, 'props' => []])
        @scopedslot('head', ($item))
        @if($item->name === 'ID')
        <th style="width: 3%">{{ $item->name }}</th>
        @elseif ($item->name === 'Action')
        <th style="width: 212px" class="hide">{{ $item->name }}</th>
        @else
        <th style="position: relative;cursor: pointer" onClick="sortBy('{{ $item->name }}', '{{ !empty($_GET['sort_type']) ? $_GET['sort_type'] : '' }}' )">
            {{ $item->name }}

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
            <td class="v-align-middle ">
                <p>{{ $number }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->name }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->username }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ !empty($item->jabatan['name']) ? $item->jabatan['name'] : '' }}</p>
            </td>
            <td class="v-align-middle">
                <div class="btn-group btn-group-sm">
                    <a href="{{ url('/user/'.$item->id) }}" class="btn btn-info"><i class="fa fa-eye"></i> Detail</a>
                    <a href="{{ url('/user/edit/'.$item->id) }}" class="btn btn-success"><i class="fa fa-lock"></i> Ubah Password</a>
                    <a href="{{ url('/profile/personal/'.$item->id) }}" class="btn btn-primary"><i class="fa fa-user"></i> Profil User</a>
                    <a onClick="return remove('{{$item->id}}','{{ $item->name }}')" href="#" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Hapus
                    </a>
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
@include('app.user.home.scripts.index')
@endsection
