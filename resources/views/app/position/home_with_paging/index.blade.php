@extends('layout.app')

@section('title', 'Information')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
  <!-- PAGE-HEADER -->
  <div class="page-header">
      <h1 class="page-title">
          Hak Akses
          <a href="/position/new/0" class="btn btn-primary btn-sm">
              (+) Buat Hak Akses
          </a>
      </h1>
      <div>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Hak Akses</li>
          </ol>
      </div>
  </div>
  <!-- PAGE-HEADER END -->

  <!-- ROW-1 -->
  <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            @component('components.table', ['data' => $data, 'props' => []])
                @scopedslot('head', ($item))
                    @if($item->label === 'no')
                        <th style="width: 3%">{{ $item->label }}</th>
                    @elseif ($item->label === 'ACTION')
                        <th style="width: 112px">{{ $item->label }}</th>
                    @else
                        <th style="width:{{$item->width}}px;">
                            {{ $item->label }}
                        </th>
                    @endif
                @endscopedslot
                @scopedslot('record', ($item, $props, $number))
                    <tr>
                        <td>
                            <p>
                                {{ $number }}
                            </p>
                        </td>
                        <td>
                            <p>
                                {{ $item->name }}
                            </p>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ url('/position/'.$item->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                <a onClick="return remove('{{$item->id}}')" href="#" class="btn btn-danger btn-sm">
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
    @include('app.position.home_with_paging.scripts.index')
@endsection
