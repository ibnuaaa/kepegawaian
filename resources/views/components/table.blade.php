<div class="blade-datatable table-responsive">
    <div class="row blade-datatable-header">
        <div class="col-12 blade-datatable-header-panel">
            <div class="row">
                <div class="col-8">
                    <div class="blade-datatable-sort">
                        <p>Show</p>
                        <div class="dropdown dropdown-default">
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ isset($data['selected']) ? $data['selected'] : 10 }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ fullUri([$data['key']."-show" => 10]) }}">10</a>
                                <a class="dropdown-item" href="{{ fullUri([$data['key']."-show" => 25]) }}">25</a>
                                <a class="dropdown-item" href="{{ fullUri([$data['key']."-show" => 50]) }}">50</a>
                                <a class="dropdown-item" href="{{ fullUri([$data['key']."-show" => 100]) }}">100</a>
                            </div>
                        </div>
                        <p>Entries</p>
                    </div>
                </div>
                <?php
                if (!isset($data['unshow_filter'])) {
                    ?>
                    <div class="col-4">
                        <form action="{{ fullUri() }}">
                            <div class="input-group">
                            <input  name="{{ $data['key'] }}-filter_search"
                                placeholder="Search... {{ !empty($data['placeholder_search']) ? '('.$data['placeholder_search'].')' : '' }}"
                                value="{{ isset($data['filter_search']) ? $data['filter_search'] : '' }}"
                                class="form-control"
                                type="text">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text info pointer"><i class="fa fa-search"></i></button>
                            </div>
                            </div>
                        </from>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <table class="table table-condensed table-bordered" style="width: 1200px !important; max-width: none;">
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
        </tbody>
    </table>
    <div class="row blade-datatable-footer">
        <div class="blade-datatable-footer-panel">
            <div class="blade-datatable-paginate">
                <ul class="row" style="list-style: none;">
                    <li class="paginate_button previous disabled">
                        @if (isset($data['paginate']->paginationNumber[0]['page']) && $data['pageNow'] <= $data['paginate']->paginationNumber[0]['page'])
                            <a>
                        @else
                            <a href="{{ fullUri([$data['key']."-page" => $data['pageNow'] - 1]) }}">
                        @endif
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    @foreach ($data['paginate']->paginationNumber as $value)
                        @if ($value['page'] == 0)
                            <li class="paginate_button">
                                <a>{{ $value['name'] }}</a>
                        @else
                            @if ($value['page'] == $data['pageNow'])
                                <li class="paginate_button active">
                            @else
                                <li class="paginate_button">
                            @endif
                            <a href="{{ fullUri([$data['key']."-page" => $value['page']]) }}">{{ $value['name'] }}</a>
                        @endif
                        </li>
                    @endforeach
                    <li class="paginate_button next">
                        @if ($data['pageNow'] >= $data['paginate']->pages)
                            <a>
                        @else
                            <a href="{{ fullUri([$data['key']."-page" => $data['pageNow'] + 1]) }}">
                        @endif
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="blade-datatable-info">
                @if ($data['show'])
                Showing <b>1 to {{ $data['show'] }}</b> of {{ $data['total'] }} entries
                @endif
            </div>
        </div>
    </div>
</div>
