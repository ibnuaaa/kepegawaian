@extends('layout.app')

@section('title', 'Dashboard')
@section('bodyClass', 'fixed-header dashboard menu-pin menu-behind')

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Jabatan</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
      <div class="col-12">
          <div class="card overflow-hidden">
            <div class="card-body">
                <table id="basic" class="table table-bordered table-condensed-custom" style="width:1900px !important;">
                    <thead>
                        <tr>
                            <th>JABATAN</th>
                            <th>NAMA PEGAWAI / NIP</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $item)
                        <tr data-node-id="{{ $item->id }}" class="td-{{ $item->status }}">
                            <td style="height: 10px !important;">
                                {{ $item->name }}
                            </td>
                            <td>
                                {{ $item->user ? $item->user->name : '' }} /
                                {{ $item->user ? $item->user->username : '' }} /
                                {{ $item->eselon_id < 5 ? $item->eselon_id : 'STAFF' }}
                            </td>
                            <td>
                                <a href="{{ url('/user/edit/'.$item->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                            @foreach ($item->children as $item2)
                            <tr data-node-id="{{ $item2->id }}" data-node-pid="{{ $item->id }}" class="td-{{ $item2->status }}">
                                <td style="white-space: nowrap;">
                                    {{ $item2->name }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $item2->user ? $item2->user->name : '' }} /
                                    {{ $item2->user ? $item2->user->username : '' }}
                                </td>
                                <td>
                                    <a href="{{ url('/user/edit/'.$item2->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                            @foreach ($item2->children as $item3)
                                <tr data-node-id="{{ $item3->id }}" data-node-pid="{{ $item2->id }}" class="td-{{ $item3->status }}">
                                    <td style="white-space: nowrap;">
                                        {{ $item3->name }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $item3->user ? $item3->user->name : '' }} /
                                        {{ $item3->user ? $item3->user->username : '' }}
                                    </td>
                                    <td>
                                        <a href="{{ url('/user/edit/'.$item3->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                                @foreach ($item3->children as $item4)
                                    <tr data-node-id="{{ $item4->id }}" data-node-pid="{{ $item3->id }}" style="white-space: nowrap;" class="td-{{ $item4->status }}">
                                        <td style="white-space: nowrap;">
                                            {{ $item4->name }}
                                        </td>
                                        <td style="white-space: nowrap;">
                                            {{ $item4->user ? $item4->user->name : '' }} /
                                            {{ $item4->user ? $item4->user->username : '' }}
                                        </td>
                                        <td>
                                            <a href="{{ url('/user/edit/'.$item4->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                    @foreach ($item4->children as $item5)
                                        <tr data-node-id="{{ $item5->id }}" data-node-pid="{{ $item4->id }}" class="td-{{ $item5->status }}">
                                            <td>
                                                {{ $item5->name }}
                                            </td>
                                            <td>
                                                {{ $item5->user ? $item5->user->name : '' }} /
                                                {{ $item5->user ? $item5->user->username : '' }} /
                                            </td>
                                            <td>
                                                <a href="{{ url('/user/edit/'.$item5->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                        @foreach ($item5->children as $item6)
                                            <tr data-node-id="{{ $item6->id }}" data-node-pid="{{ $item5->id }}" class="td-{{ $item6->status }}">
                                                <td>
                                                    {{ $item6->name }}
                                                </td>
                                                <td>

                                                    @foreach ($item6->users as $key => $user)
                                                        {{ $key + 1 }}.) {{ $user ? $user->name : '' }} /
                                                        NIP.{{ $user ? $user->username : '' }}
                                                        <br />
                                                    @endforeach

                                                </td>
                                                <td>
                                                  <a href="{{ url('/user/edit/'.$item6->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- ROW-1 END -->
    </div>
    </div>
</div>
@endsection

@section('formValidationScript')
    @include('app.position.home.scripts.form')
@endsection

@section('script')
    @include('app.position.home.style.style')
@endsection
