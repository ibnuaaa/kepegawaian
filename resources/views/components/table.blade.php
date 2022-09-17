<div class="row row-sm">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="table-responsive">
               <div id="responsive-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                  <div class="row">
                     <div class="col-sm-12 col-md-2">
                        <div class="dataTables_length" id="responsive-datatable_length">
                           <label>
                              Tampilkan
                              <select name="country" class="form-control form-select form-select-md" data-bs-placeholder="Select Country" onChange="getSelected(this)">
                                  <option value="{{ fullUri([$data['key']."-show" => 10]) }}" {{ $data['selected'] == 10 ? 'selected=selected' : '' }}>10</option>
                                  <option value="{{ fullUri([$data['key']."-show" => 25]) }}" {{ $data['selected'] == 25 ? 'selected=selected' : '' }}>25</option>
                                  <option value="{{ fullUri([$data['key']."-show" => 50]) }}" {{ $data['selected'] == 50 ? 'selected=selected"' : '' }}>50</option>
                                  <option value="{{ fullUri([$data['key']."-show" => 100]) }}" {{ $data['selected'] == 100 ? 'selected=selected' : '' }}>100</option>
                                  <option value="{{ fullUri([$data['key']."-show" => 1000]) }}" {{ $data['selected'] == 1000 ? 'selected=selected' : '' }}>1000</option>
                                  <option value="{{ fullUri([$data['key']."-show" => 10000]) }}" {{ $data['selected'] == 10000 ? 'selected=selected' : '' }}>10000</option>
                              </select>
                              data
                           </label>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-7">
                       @yield('headerTableSection')
                     </div>
                     <div class="col-sm-12 col-md-3">
                        <div id="responsive-datatable_filter" class="dataTables_filter"><label style="width: 100%;">
                          <?php
                          if (!isset($data['unshow_filter'])) {
                              ?>
                                  <form action="{{ fullUri() }}" onsubmit="return filterName()">
                                      <div class="input-group"  style="width: 100%;">
                                      <input  name="filter_search"
                                          placeholder="Search... {{ !empty($data['placeholder_search']) ? '('.$data['placeholder_search'].')' : '' }}"
                                          value="{{ isset($data['filter_search']) ? $data['filter_search'] : '' }}"
                                          class="form-control full-width"
                                          type="text">
                                      </div>
                                  </from>
                              <?php
                          }
                          ?>
                        </label></div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                       @yield('filterSection')
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <table class="table table-bordered text-nowrap border-bottom dataTable no-footer table-sm" id="responsive-datatable" role="grid" aria-describedby="responsive-datatable_info">
                           <thead>
                             <tr>
                                 @foreach ($data['heads'] as $item)
                                     @if(isset($head))
                                         {{ $head($item) }}
                                     @endif
                                 @endforeach
                             </tr>
                           </thead>
                           <tbody>

                            @if (empty($data['records']) || count($data['records']) == 0)
                                <tr>
                                    <td colspan="{{count($data['heads'])}}" class="text-center">
                                        Data Kosong
                                    </td>
                                </tr>
                             @else
                                 @foreach ($data['records'] as $key => $item)
                                     <?php
                                         $take = 10;
                                         if (!empty($data['selected'])) $take = $data['selected'];
                                         $number = (($data['pageNow'] - 1)  * $take) + $key + 1 ;
                                     ?>
                                     @if(isset($record))
                                         {{ $record($item, $props = isset($props) ? $props : [], $number, $data) }}
                                     @endif
                                 @endforeach
                             @endif
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="responsive-datatable_info" role="status" aria-live="polite">
                          @if ($data['show'])
                          Menampilkan 1 - {{ $data['show'] }} dari {{ $data['total'] }} data
                          @endif
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="responsive-datatable_paginate">

                           <ul class="pagination">

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
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
function getSelected(e) {
  location.href = $(e).val();
}
</script>
