@extends('layout.app')

@section('title', 'PenilaianPrestasiKerja')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Laporan IKI &nbsp;
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan IKI</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

@section('filterSection')
<table class="table table-bordered table-condensed-custom">
    <tr>
        <td style="width: 25%;">
            Cari Pegawai
        </td>
        <td style="width: 25%;">
            <select name="user_id" class="form-control form-select" >
                @if (!empty($user->id))
                <option value="{{ $user->id }}">{{ $user->name }}<option>
                @else
                <option value="">-= Pilih Pegawai =-<option>
                @endif
            </select>
        </td>
        <td style="width: 25%;">
            Dari Bulan
        </td>
        <td style="width: 25%;">
          <select name="dari_bulan" class="form-control">
              <option value="">-= Pilih Bulan =-</option>
              @foreach (listMonth() as $key => $value)
                  <option {{ !empty($dari_bulan) && $dari_bulan == $key ? 'selected="selected"' : '' }} value="{{$key}}">{{$value}}</option>
              @endforeach
          </select>
        </td>
    </tr>
    <tr>
        <td>
          Tahun
        </td>
        <td>
          <select name="tahun" class="form-control form-select">
              <option value="2022">2022</option>
          </select>
        </td>
        <td style="width: 25%;">
            Sampai Bulan
        </td>
        <td style="width: 25%;">
            <select name="sampai_bulan" class="form-control">
                <option value="">-= Pilih Bulan =-</option>
                @foreach (listMonth() as $key => $value)
                    <option {{ !empty($sampai_bulan) && $sampai_bulan == $key ? 'selected="selected"' : '' }} value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
            <a href="#" class="btn btn-primary btn-sm" onclick="return cari()">
                <i class="fa fa-search"></i>
                Cari
            </a>

            <a href="/laporan_iki" class="btn btn-primary btn-sm">
                <i class="fa fa-search"></i>
                Tampilkan Semua
            </a>
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
</table>
@endsection

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
        <th>
            {{ $item->label }}
        </th>
        @endif
        @endscopedslot
        @scopedslot('record', ($item, $props, $number, $data))
        <tr>
            <td class="v-align-middle ">
                <p>{{ $number }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ !empty($item->user->nip) ? $item->user->nip : '' }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ !empty($item->user->name) ? $item->user->name : '' }}</p>
            </td>
            <td class="v-align-middle">
                <a href="/penilaian_prestasi_kerja/pdf/{{ $item->id }}" onclick="return openModalPreview('/penilaian_prestasi_kerja/pdf/{{ $item->id }}')">
                    {{ !empty($item->bulan) ? monthIndo($item->bulan) : '' }} {{ $item->tahun }}
                </a>
            </td>
            <td class="v-align-middle ">

                <?php
                    $total_nilai_kinerja = 0;
                    foreach ($item->penilaian_prestasi_kerja_item as $key => $val) {
                        $total_nilai_kinerja += $val->nilai_kinerja;
                    }
                ?>
                <p>{{ $total_nilai_kinerja }}</p>
            </td>
            <td class="v-align-middle ">

                <?php
                    $total_nilai_kualitas = 0;
                    foreach ($item->penilaian_kualitas as $key => $val) {
                        $total_nilai_kualitas += $val->nilai_kinerja;
                    }
                ?>

                <p>{{ $total_nilai_kualitas }}</p>
            </td>
            <td class="v-align-middle ">
                <?php
                    $total_nilai_perilaku = 0;
                    foreach ($item->penilaian_perilaku_kerja as $key => $val) {
                        $total_nilai_perilaku += $val->nilai_kinerja;
                    }
                ?>
                <p>{{ $total_nilai_perilaku }}</p>
            </td>
            <td class="v-align-middle ">

                <?php
                    $total_nilai_tambahan = 0;
                    foreach ($item->penilaian_tambahan as $key => $val) {
                        $total_nilai_tambahan += $val->nilai_kinerja;
                    }
                ?>
                <p>{{ $total_nilai_tambahan }}</p>
            </td>

            <td class="v-align-middle ">
                <p>{{ $total_nilai_kinerja + $total_nilai_kualitas + $total_nilai_perilaku + $total_nilai_tambahan }}</p>
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
@include('app.laporan.laporan_iki.scripts.form')
@endsection
