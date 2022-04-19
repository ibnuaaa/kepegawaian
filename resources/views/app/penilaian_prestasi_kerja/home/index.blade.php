@extends('layout.app')

@section('title', 'PenilaianPrestasiKerja')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Penilaian Prestasi Kerja &nbsp;
        <a onclick="saveNew()" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-plus"></i>
            Buat
        </a>
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Penilaian Prestasi Kerja</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        @component('components.table', ['data' => $data, 'props' => ['jabatan' => $jabatan]])
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
                <p>{{ !empty($item->bulan) ? monthIndo($item->bulan) : '' }} {{ $item->tahun }}</p>
            </td>
            <td class="v-align-middle">
                <p>{{ $item->created_at }}</p>
            </td>
            <td class="v-align-middle">
                <div class="btn-group btn-group-sm">
                    <a href="{{ url('/penilaian_prestasi_kerja/pdf/'.$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-file-pdf-o"></i> Download IKI</a>
                    @if (!$props['jabatan']->is_staff)
                    <a href="{{ url('/penilaian_prestasi_kerja/pdf_iku/'.$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-file-pdf-o"></i> Download IKU</a>
                    @endif
                    <a href="{{ url('/penilaian_prestasi_kerja/edit/'.$item->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"> Edit</i></a>
                    <a onClick="return remove('{{$item->id}}','{{ $item->name }}')" href="#" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i> Hapus
                    </a>
                    @if (!empty($props['jabatan']->is_staff) && $props['jabatan']->is_staff)
                    <a href="{{ url('/penilaian_prestasi_kerja/logbook/'.$item->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-list-alt"></i> Logbook</a>
                    @endif
                    @if (!$props['jabatan']->is_staff)
                    <a href="{{ url('/penilaian_prestasi_kerja/id/'.$item->id) }}" class="btn btn-success btn-xs"><i class="fa fa-file"></i> Buat Program / Kegiatan </a>
                    @endif
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
@include('app.penilaian_prestasi_kerja.home.scripts.index')
@endsection
