@extends('layout.app')

@section('title', 'Complaint')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Complaint
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Complaint</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<!-- Row -->
<div class="row">
    <div class="col-xl-3">
        <div class="card">
            @include('app.complaint.home.menu')
        </div>
    </div>
    <div class="col-xl-9">
        <div class="card">
            <div class="card-body p-6">
                <div class="inbox-body">
                    <div class="mail-option"  style="display: none;">
                        <div class="chk-all">
                            <div class="btn-group">
                                <a data-bs-toggle="dropdown" href="#" class="btn mini all" aria-expanded="false">
                                        All
                                        <i class="fa fa-angle-down "></i>
                                    </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"> None</a></li>
                                    <li><a href="#"> Read</a></li>
                                    <li><a href="#"> Unread</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group">
                            <a href="#" class="btn mini tooltips">
                                <i class=" fa fa-refresh"></i>
                            </a>
                        </div>
                        <div class="btn-group hidden-phone">
                            <a data-bs-toggle="dropdown" href="#" class="btn mini blue" aria-expanded="false">
                                    More
                                    <i class="fa fa-angle-down "></i>
                                </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-pencil me-2"></i> Mark as Read</a></li>
                                <li><a href="#"><i class="fa fa-ban me-2"></i> Spam</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="fa fa-trash-o me-2"></i> Delete</a></li>
                            </ul>
                        </div>
                        <ul class="unstyled inbox-pagination">
                            <li><span class="fs-13">1-50 of 234</span></li>

                            <li>
                                <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-inbox table-hover text-nowrap mb-0">
                            <tbody>

                                @foreach ($data['records'] as $key => $val)
                                <?php
                                  $data_href = '/complaint/detail/' . $val->id . '/' . $menu;

                                  if ($menu == 'drafts') {
                                    $data_href = '/complaint/edit/' . $val->id;
                                  }


                                  $urgency_class = '';

                                  if ($val->urgency_type == 1) {
                                    $urgency_class = 'text-danger';
                                  } else if ($val->urgency_type == 2) {
                                    $urgency_class = 'text-warning';
                                  } else if ($val->urgency_type == 3) {
                                    $urgency_class = 'text-info';
                                  }


                                  $status_class = '';
                                  if ($val->status == 1) {
                                  } else if ($val->status == 2) {
                                    $status_class = 'text-danger';
                                  } else if ($val->status == 3) {
                                    $status_class = 'text-warning';
                                  } else if ($val->status == 4) {
                                    $status_class = 'text-info';
                                  } else if ($val->status == 7) {
                                    $status_class = 'text-success';
                                  }


                                ?>
                                <tr>
                                    <td class="inbox-small-cells"  style="display: none;">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                            <input type="checkbox" class="custom-control-input" disabled name="example-checkbox2" value="option2">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star {{ $status_class}}"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark {{ $urgency_class }}"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='{{$data_href}}'>{{ !empty($val->from_unit_kerja->name) ? $val->from_unit_kerja->name : '-' }}</td>
                                    <td class="view-message clickable-row" data-href='{{$data_href}}'>{{ !empty($val->title) ? $val->title : '<< Kosong >>' }}</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='{{$data_href}}'>{{ !empty($val->created_at) ? time_elapsed_string($val->created_at) : '<< Kosong >>' }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>



        <ul class="pagination mb-4">

          <?php $lastkey = 0; ?>


           @if (isset($data['paginate']->paginationNumber[0]['page']) && $data['pageNow'] <= $data['paginate']->paginationNumber[0]['page'])
           <li class="paginate_button page-item previous disable" id="responsive-datatable_previous">
               <a aria-controls="responsive-datatable" data-dt-idx="0" tabindex="0" class="page-link">
           @else
           <li class="paginate_button page-item previous" id="responsive-datatable_previous">
               <a href="{{ fullUri([$data['key']."-page" => $data['pageNow'] - 1]) }}" aria-controls="responsive-datatable" data-dt-idx="0" tabindex="0" class="page-link">
           @endif
               Sebelumnya
               </a>
           </li>

           @foreach ($data['paginate']->paginationNumber as $key => $value)
               @if ($value['page'] == 0)
                   <li class="paginate_button page-item">
                       <a aria-controls="responsive-datatable" data-dt-idx="{{$key + 1}}" tabindex="0" class="page-link" >{{ $value['name'] }}</a>
               @else
                   @if ($value['page'] == $data['pageNow'])
                       <li class="paginate_button page-item active">
                   @else
                       <li class="paginate_button page-item">
                   @endif
                   <a aria-controls="responsive-datatable" data-dt-idx="1" tabindex="0" class="page-link" href="{{ fullUri([$data['key']."-page" => $value['page']]) }}">{{ $value['name'] }}</a>
               @endif
               </li>
               <?php $lastkey = $key + 1; ?>
           @endforeach
           </li>


               @if ($data['pageNow'] >= $data['paginate']->pages)
               <li class="paginate_button page-item next disable" id="responsive-datatable_next">
                   <a aria-controls="responsive-datatable" data-dt-idx="{{$lastkey + 1}}" tabindex="0" class="page-link">
               @else
               <li class="paginate_button page-item next" id="responsive-datatable_next">
                   <a aria-controls="responsive-datatable" data-dt-idx="{{$lastkey + 1}}" tabindex="0" class="page-link" href="{{ fullUri([$data['key']."-page" => $data['pageNow'] + 1]) }}">
               @endif
               Selanjutnya
               </a>
           </li>

        </ul>
    </div>
</div>
<!-- ROW-1 CLOSED -->
<!-- ROW-1 END -->


</div>


@endsection

@section('script')
@include('app.complaint.home.scripts.index')
@endsection
