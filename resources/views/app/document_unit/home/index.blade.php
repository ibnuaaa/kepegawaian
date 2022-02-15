@extends('layout.app')

@section('title', 'DocumentUnit')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Dokumen
        <a href="/document_unit/new" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i>
            Buat Dokumen
        </a>
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

@section('headerTableSection')

<label class="pull-right row" style="margin-top: 2px;">
  <div class="input-group col-6">
      @component('components.form.awesomeSelect', [
          'name' => 'jenis_dokumen_id',
          'items' => jenis_dokumen(),
          'onChange' => 'selectJenisDokumen(this)',
          'selected' => $selected_jenis_dokumen_id,
      ])
      @endcomponent
  </div>
  <div class="input-group col-6">
      <select class="form-control form-select" name="unit_kerja_id" onChange='selectUnitKerja(this)'>
          <option value="">-= Semua Unit Kerja =-</option>
          {!! !empty($unit_kerja) && count($unit_kerja) > 0 ? treeSelectUnitKerja($unit_kerja, '', $selected_unit_kerja_id) : '' !!}
      </select>
  </div>
</label>
@endsection

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
                <p>{{ $item->name }}</p>
            </td>
            <td class="v-align-middle ">
                <p>{{ $item->jenis_dokumen_id ? jenis_dokumen($item->jenis_dokumen_id) : '' }}</p>
            </td>
            <td class="v-align-middle ">
              <?php if (!empty($item->document_unit)): ?>
                  <?php foreach ($item->document_unit as $key => $val2): ?>
                      <a href="/api/preview/{{$val2->storage->key}}" onclick="return openModalPreview('{{ getConfig('protocol') . '://'. getConfig('basepath')  }}/api/preview/{{$val2->storage->key}}')">
                          <i class="fa fa-file-pdf-o" style="font-size: 50px;"></i>
                      </a>
                  <?php endforeach; ?>
              <?php endif; ?>
            </td>
            <td class="v-align-middle text-center">
                @if (!empty($item->status) && $item->status == 'approved')
                  <span class="badge bg-success badge-sm  me-1 mb-1 mt-1">Terverifikasi</span>
                @else
                  <span class="badge bg-warning badge-sm  me-1 mb-1 mt-1">Pending</span>
                @endif
            </td>
            <td class="v-align-middle">
                <p>{{ $item->created_at }}</p>
            </td>
            <td class="v-align-middle">
                <div class="btn-group-sm">
                  <a href="{{ url('/document_unit/'.$item->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>

                  @if (getPermissions('approval_document_unit')['checked'])
                  @if (!empty($item->status) && $item->status != 'approved')
                  <a href="#" onClick="return approve({{$item->id}},'{{ $item->name }}')" class="btn btn-primary"><i class="fa fa-check"></i></a>
                  @endif
                  @endif

                  @if ($item->created_user_id == MyAccount()->id || MyAccount()->position_id == 1)
                  <a href="{{ url('/document_unit/edit/'.$item->id) }}" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                  @endif

                  @if ($item->created_user_id == MyAccount()->id || MyAccount()->position_id == 1)
                  <a onClick="return remove('{{$item->id}}','{{ $item->name }}')" href="#" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                  </a>
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
@include('app.document_unit.home.scripts.index')
@endsection
