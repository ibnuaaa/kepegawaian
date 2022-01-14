@extends('layout.app')

@section('title', 'Golongan')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Golongan</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Golongan</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

@section('headerTableSection')
  <a href="/golongan/new" class="btn btn-primary">Tambah Golongan</a>
@endsection

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        @component('components.table', ['data' => $data, 'props' => []])
            @scopedslot('head', ($item))
                @if($item->name === 'ID')
                    <th style="width: 3%">{{ $item->name }}</th>
                @elseif ($item->name === 'ACTION')
                    <th style="width: 112px" class="hide">{{ $item->name }}</th>
                @else
                    <th style="position: relative;cursor: pointer" onClick="sortBy('{{ $item->name }}', '{{ !empty($_GET['sort_type']) ? $_GET['sort_type'] : '' }}' )">
                        {{ $item->name }}
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
                    <td class="v-align-middle">
                        <p>{{ $item->created_at }}</p>
                    </td>
                    <td class="v-align-middle">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ url('/golongan/'.$item->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            <a href="{{ url('/golongan/edit/'.$item->id) }}" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                            <a onClick="return remove('{{$item->id}}','{{ $item->name }}')" href="#" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
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
    @include('app.golongan.home.scripts.index')
@endsection
