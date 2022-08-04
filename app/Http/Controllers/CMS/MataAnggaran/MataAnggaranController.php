<?php

namespace App\Http\Controllers\CMS\MataAnggaran;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Models\MataAnggaran;
use App\Models\UnitKerja;


use App\Http\Controllers\MataAnggaran\MataAnggaranBrowseController;
use App\Http\Controllers\UnitKerja\UnitKerjaBrowseController;

class MataAnggaranController extends Controller
{
    public function Home(Request $request)
    {
        $Browse = MataAnggaran::tree();

        $ParseData = [
            'data' => $Browse
        ];


        return view('app.mata_anggaran.home.index', $ParseData);
    }

    public function HomeWithPaging(Request $request)
    {
        $TableKey = 'mata_anggaran';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['mata_anggaran-take'])) {
            $selected = $request['mata_anggaran-take'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Mail = MataAnggaranBrowseController::FetchBrowse($request)
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

        if (isset($request['mata_anggaran-show'])) {
            $selected = $request['mata_anggaran-show'];
        }
        else {
            $selected = 10;
        }

        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "Nama, MataAnggaran",
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
        return view('app.mata_anggaran.home_with_paging.index', $ParseData);
    }

    public function New(Request $request, $mata_anggaran_id)
    {

        $MataAnggaran = MataAnggaranBrowseController::FetchBrowse($request)
            ->where('id', $mata_anggaran_id)
            ->get();

        $unit_kerja_id = 0;
        $UnitKerjaTree = UnitKerja::tree();


        return view('app.mata_anggaran.new.index', [
            'unit_kerja' => $UnitKerjaTree,
            'selected_unit_kerja_id' => $unit_kerja_id,
            'parent_id' => $mata_anggaran_id,
            'parent_mata_anggaran' => $MataAnggaran['records']
        ]);
    }

    public function MataAnggaranEdit(Request $request, $id)
    {


        $MataAnggaran = MataAnggaranBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');

        $MataAnggaranList = MataAnggaranBrowseController::FetchBrowse($request)
            ->equal('take', 'all')->equal('with.total', true)->get();

        $MataAnggaranSelect = FormSelect($MataAnggaranList['records'], true);


        $MataAnggaranTree = MataAnggaran::tree();
        $UnitKerjaTree = UnitKerja::tree();

        return view('app.mata_anggaran.edit.index', [
            'data' => $MataAnggaran['records'],
            'unit_kerja' => $UnitKerjaTree,
            'mata_anggaran' => $MataAnggaranTree
        ]);
    }


}
