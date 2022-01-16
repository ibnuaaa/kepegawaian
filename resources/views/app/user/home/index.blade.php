@extends('layout.app')

@section('title', 'User')
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

@section('headerTableSection')
  <a href="/user/new" class="btn btn-primary">Tambah User</a>
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
                        <p>{{ $item->position['name'] }}</p>
                    </td>
                    <td class="v-align-middle">
                        <p>{{ $item->created_at }}</p>
                    </td>
                    <td class="v-align-middle">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ url('/user/'.$item->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            <a href="{{ url('/user/edit/'.$item->id) }}" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                            <a href="#modalDelete" data-toggle="modal" data-record-id="{{$item->id}}" data-record-name="{{$item->name}}" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endscopedslot

            {{-- @scopedslot('head', ($item))
                @if($item->name === 'id')
                    <th style="width: 3%">{{ $item->name }}</th>
                @elseif ($item->name === 'action')
                    <th style="width: 10%">{{ $item->name }}</th>
                @else
                    <th>{{ $item->name }}</th>
                @endif
            @endscopedslot
            @scopedslot('record', ($item, $props))
                <tr>
                    <td class="v-align-middle ">
                        <p>{{ $item->id }}</p>
                    </td>
                    <td class="v-align-middle ">
                        <p>{{ $item->username }}</p>
                    </td>
                    <td class="v-align-middle">
                        <p>{{ $item->updated_at }}</p>
                    </td>
                    <td class="v-align-middle">
                        <p>{{ $item->created_at }}</p>asdasd
                    </td>
                    <td class="v-align-middle">
                        <div class="btn-group-xs">asdasd
                            <a href="{{ url('/user/'.$item->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ url('/user/edit/'.$item->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                            <a href="#modalDelete" data-toggle="modal" data-record-id="{{$item->id}}" data-record-name="{{$item->name}}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endscopedslot--}}
        @endcomponent
      </div>
    </div>
    <!-- ROW-1 END -->
</div>
@endsection

@section('script')
    @include('app.user.home.scripts.index')
@endsection
