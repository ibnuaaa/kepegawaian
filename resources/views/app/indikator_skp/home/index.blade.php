@extends('layout.app')

@section('title', 'IndikatorSkp')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Indikator Skp</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Indikator Skp</li>
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
        <th style="width: 50px">{{ $item->label }}</th>
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
                <b class="text-red">{{ !empty($item->indikator_kinerja->name) ? $item->indikator_kinerja->name : '' }}</b>


                <table class="table table-bordered bg-white table-sm">
                    <tr>
                        <th style="width: 5%;">
                          No
                        </th>
                        <th style="width: 45%;">
                          Program & Kegiatan
                        </th>
                        <th style="width: 5%;">
                          Aksi
                        </th>
                    </tr>
                <?php  foreach($item->indikator_kinerja->indikator_skp_child as $key => $val) : ?>
                    <tr>
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                          <b class="text-blue">
                            {{$val->name}}
                          </b>
                            <table class="table table-bordered table-sm bg-white">
                                <tr>
                                    <th>
                                        Kegiatan
                                    </th>
                                    <th style="width: 5%;">
                                      Aksi
                                    </th>
                                </tr>
                                <?php  foreach($val->kegiatan as $key2 => $val2) : ?>
                                <tr>
                                  <td>
                                      {{$val2->name}}
                                  </td>
                                  <td>
                                    <a href="/indikator_skp/edit/{{ $val2->id }}" class=" btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="return remove('{{ $val2->id }}','{{ $val2->name }}')" class=" btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                  </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="text-left" colspan="2">
                                        <a href="{{ url('/indikator_skp/new/kegiatan/'.$val->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-plus"></i>
                                            Tambah Kegiatan
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                        <td>
                          <a href="/indikator_skp/edit/{{ $val->id }}" class=" btn btn-primary btn-sm">
                              <i class="fa fa-edit"></i>
                          </a>
                          <a href="#" onclick="return remove('{{ $val->id }}','{{ $val->name }}')" class=" btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i>
                          </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-left">
                        <a href="{{ url('/indikator_skp/new/program/'.$item->indikator_kinerja->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                            Tambah Program
                        </a>
                    </td>
                </tr>
                </table>
            </td>
            <td class="v-align-middle">
                <div class="btn-group btn-group-sm">
                    <a href="{{ url('/indikator_skp/'.$item->indikator_kinerja->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
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
@include('app.indikator_skp.home.scripts.index')
@endsection
