@extends('layout.app')

@section('title', 'Pendidikan')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Approval Penilaian SDM</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pendidikan</li>
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
            <td class="v-align-middle ">
                <p>{{ $number }}</p>
            </td>
            <td class="v-align-middle ">
              <p>{{ $item->user->name }}<br>
              <i style="font-size: 10px;">{{ !empty($item->user->jabatan->name) ? $item->user->jabatan->name : '' }}</i>
              </p>
            </td>
            <td class="v-align-middle ">
                <p>{{ !empty($item->bulan) ? monthIndo($item->bulan) : '' }} {{ $item->tahun }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->unit_kerja->name }}</p>
            </td>
            <td class="v-align-middle ">
              <?php if (!empty($item->foto_penilaian_prestasi_kerja)): ?>
                <?php foreach ($item->foto_penilaian_prestasi_kerja as $key => $val2): ?>
                  <a href="/api/preview/{{$val2->storage->key}}">
                      <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->status_approval_sdm }}</p>
            </td>
            <td class="v-align-middle">
                <p>{{ $item->created_at }}</p>
            </td>
            <td class="v-align-middle">
                <div class="btn-group btn-group-sm">
                    <a href="{{ url('/penilaian_prestasi_kerja/edit/'.$item->id) }}" class="btn btn-info"><i class="fa fa-eye"></i> Detail</a>
                    @if ($item->status_approval_sdm == 'need_approval')
                    <a href="#" class="btn btn-warning" onclick="return approveSdm({{$item->id}});"><i class="fa fa-check"></i> Approve</a>
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
@include('app.approval_penilaian_sdm.home.scripts.index')
@endsection
