<?php

namespace App\Http\Controllers\CMS\UnitKerja;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Models\UnitKerja;


use App\Http\Controllers\UnitKerja\UnitKerjaBrowseController;

class UnitKerjaController extends Controller
{
    public function Home(Request $request)
    {
        $Browse = UnitKerja::tree();

        $ParseData = [
            'data' => $Browse
        ];

        return view('app.unit_kerja.home.index', $ParseData);
    }

    public function HomeWithPaging(Request $request)
    {
        $TableKey = 'unit_kerja';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['unit_kerja-take'])) {
            $selected = $request['unit_kerja-take'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Mail = UnitKerjaBrowseController::FetchBrowse($request)
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $Mail = $Mail->where('search', $filter_search);
        }

        $Take = ___TableGetTake($request, $TableKey);

        $request->ArrQuery->take = $Take;
        $Mail = $Mail->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');

        if (isset($request['unit_kerja-show'])) {
            $selected = $request['unit_kerja-show'];
        }
        else {
            $selected = 10;
        }

        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "Nama, UnitKerja",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$Mail['total'], (int)$Mail['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'no', 'label' => 'no', 'width' => '900'],
                (object)['name' => 'name', 'label' => 'Posisi', 'width' => '900'],
                (object)['name' => 'action', 'label' => 'ACTION', 'width' => '100']
            ],
            'records' => []
        ];



        if ($Mail['records']) {
            $DataTable['records'] = $Mail['records'];
            $DataTable['total'] = $Mail['total'];
            $DataTable['show'] = $Mail['show'];

            $DataTable['totalpage'] = (int)(ceil($DataTable['total'] / $selected)) ;
            $DataTable['startentries'] = (($DataTable['pageNow'] - 1 ) * $selected) + 1;
            $DataTable['endentries'] = $DataTable['startentries'] + ($selected - 1);
            if ($DataTable['endentries'] > $DataTable['total']){
                $DataTable['endentries'] = $DataTable['total'];
            }
            if ($DataTable['pageNow'] > $DataTable['totalpage']){
                $DataTable['pageNow'] = $DataTable['totalpage'];
            }
        }


        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.unit_kerja.home_with_paging.index', $ParseData);
    }

    public function New(Request $request, $unit_kerja_id)
    {
        $Browse = UnitKerja::tree();

        return view('app.unit_kerja.new.index', [
          'unit_kerja' => $Browse,
          'selected_unit_kerja_id' => $unit_kerja_id
        ]);
    }

    public function UnitKerjaEdit(Request $request, $id)
    {

        $UnitKerja = UnitKerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');

        $UnitKerjaList = UnitKerjaBrowseController::FetchBrowse($request)
            ->equal('take', 'all')->equal('with.total', true)->get();

        $UnitKerjaSelect = FormSelect($UnitKerjaList['records'], true);

        return view('app.unit_kerja.edit.index', [
            'data' => $UnitKerja['records'],
            'select' => ['unit_kerja' => []],
            'unit_kerja' => $UnitKerjaSelect
        ]);
    }


}
