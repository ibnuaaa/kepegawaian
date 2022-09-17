@extends('layout.app')

@section('title', 'PenilaianPrestasiKerja')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Approval Penilaian Prestasi Kerja &nbsp;
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Approval Penilaian Prestasi Kerja</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        @component('components.table', ['data' => $data])
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
        @scopedslot('record', ($item, $props, $number, $data))
        <tr>
            <td class="v-align-middle ">
                <p>{{ $number }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ !empty($item->penilaian_prestasi_kerja->user->name) ? $item->penilaian_prestasi_kerja->user->name : '' }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ !empty($item->penilaian_prestasi_kerja->bulan) ? monthIndo($item->penilaian_prestasi_kerja->bulan) : '' }} {{ !empty($item->penilaian_prestasi_kerja->tahun) ? $item->penilaian_prestasi_kerja->tahun : '' }}</p>
            </td>
            <td class="v-align-middle">



                <p>{{ $item->created_at }}</p>
            </td>
            <td class="v-align-middle">
                <div class="btn-group btn-group-sm">
                    <a href="{{ url('/penilaian_prestasi_kerja/pdf/'.$item->penilaian_prestasi_kerja->id) }}" class="btn btn-info btn-xs"><i class="fa fa-file-pdf-o"></i> Download IKI</a>
<<<<<<< HEAD
                    <a href="{{ url('/penilaian_prestasi_kerja/edit/'.$item->penilaian_prestasi_kerja->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"> Koreksi</i></a>
=======

                    @if ($item->penilaian_prestasi_kerja->user->jabatan->is_staff)
                      @if ($item->penilaian_prestasi_kerja->user->unit_kerja->id == MyAccount()->unit_kerja_id)
                        <a href="{{ url('/penilaian_prestasi_kerja/edit/'.$item->penilaian_prestasi_kerja->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Koreksi</a>
                      @else
                        <a href="{{ url('/penilaian_prestasi_kerja/edit/'.$item->penilaian_prestasi_kerja->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Setujui</a>
                      @endif
                    @else
                      @if ($item->penilaian_prestasi_kerja->user->unit_kerja->parents->id == MyAccount()->unit_kerja_id)
                        <a href="{{ url('/penilaian_prestasi_kerja/edit/'.$item->penilaian_prestasi_kerja->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Koreksi</a>
                      @else
                        <a href="{{ url('/penilaian_prestasi_kerja/edit/'.$item->penilaian_prestasi_kerja->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Setujui</a>
                      @endif
                    @endif


>>>>>>> b062a17c0df8be831cf18722ae4e18ec91f14e22
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
@include('app.penilaian_prestasi_kerja_approval.home.scripts.index')
@endsection
