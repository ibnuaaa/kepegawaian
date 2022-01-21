<?php

namespace App\Http\Controllers\CMS\IndikatorKinerja;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Models\IndikatorKinerja;
use App\Models\UnitKerja;


use App\Http\Controllers\IndikatorKinerja\IndikatorKinerjaBrowseController;
use App\Http\Controllers\UnitKerja\UnitKerjaBrowseController;

class IndikatorKinerjaController extends Controller
{
    public function Home(Request $request)
    {
        $Browse = IndikatorKinerja::tree();

        $ParseData = [
            'data' => $Browse
        ];


        return view('app.indikator_kinerja.home.index', $ParseData);
    }

    public function HomeWithPaging(Request $request)
    {
        $TableKey = 'indikator_kinerja';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['indikator_kinerja-take'])) {
            $selected = $request['indikator_kinerja-take'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Mail = IndikatorKinerjaBrowseController::FetchBrowse($request)
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

        if (isset($request['indikator_kinerja-show'])) {
            $selected = $request['indikator_kinerja-show'];
        }
        else {
            $selected = 10;
        }

        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "Nama, IndikatorKinerja",
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
        return view('app.indikator_kinerja.home_with_paging.index', $ParseData);
    }

    public function New(Request $request, $indikator_kinerja_id)
    {

        $IndikatorKinerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
            ->where('id', $indikator_kinerja_id)
            ->get();

        $unit_kerja_id = 0;

        if (!empty($IndikatorKinerja['records']->unit_kerja_id)) {
            $UnitKerja = UnitKerjaBrowseController::FetchBrowse($request)
                ->where('parent_id', $IndikatorKinerja['records']->unit_kerja_id)
                ->get();

        } else {
            $UnitKerja = UnitKerjaBrowseController::FetchBrowse($request)
                ->where('null_parent_id', true)
                ->get();
        }

        $UnitKerjaSelect = FormSelect($UnitKerja['records'], true);

        return view('app.indikator_kinerja.new.index', [
            'unit_kerja' => $UnitKerjaSelect,
            'selected_unit_kerja_id' => $unit_kerja_id,
            'parent_id' => $indikator_kinerja_id,
            'parent_indikator_kinerja' => $IndikatorKinerja['records']
        ]);
    }

    public function IndikatorKinerjaEdit(Request $request, $id)
    {

        $IndikatorKinerja = IndikatorKinerjaBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');

        $IndikatorKinerjaList = IndikatorKinerjaBrowseController::FetchBrowse($request)
            ->equal('take', 'all')->equal('with.total', true)->get();

        $IndikatorKinerjaSelect = FormSelect($IndikatorKinerjaList['records'], true);

        $IndikatorKinerjaTree = IndikatorKinerja::tree();
        $UnitKerjaTree = UnitKerja::tree();

        return view('app.indikator_kinerja.edit.index', [
            'data' => $IndikatorKinerja['records'],
            'unit_kerja' => $UnitKerjaTree,
            'indikator_kinerja' => $IndikatorKinerjaTree
        ]);
    }


}
