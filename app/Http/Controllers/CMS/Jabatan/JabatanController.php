<?php

namespace App\Http\Controllers\CMS\Jabatan;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Models\Jabatan;


use App\Http\Controllers\Jabatan\JabatanBrowseController;

class JabatanController extends Controller
{
    public function Home(Request $request)
    {
        $Browse = Jabatan::tree();

        $ParseData = [
            'data' => $Browse
        ];

        return view('app.jabatan.home.index', $ParseData);
    }

    public function HomeWithPaging(Request $request)
    {
        $TableKey = 'jabatan';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['jabatan-take'])) {
            $selected = $request['jabatan-take'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $Mail = JabatanBrowseController::FetchBrowse($request)
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

        if (isset($request['jabatan-show'])) {
            $selected = $request['jabatan-show'];
        }
        else {
            $selected = 10;
        }

        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "Nama, Jabatan",
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
        return view('app.jabatan.home_with_paging.index', $ParseData);
    }

    public function New(Request $request, $jabatan_id)
    {
        $Browse = Jabatan::tree();

        return view('app.jabatan.new.index', [
          'jabatan' => $Browse,
          'selected_jabatan_id' => $jabatan_id
        ]);
    }

    public function JabatanEdit(Request $request, $id)
    {

        $Jabatan = JabatanBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');

        $JabatanTree = Jabatan::tree();

        return view('app.jabatan.edit.index', [
            'data' => $Jabatan['records'],
            'select' => ['jabatan' => []],
            'jabatan' => $JabatanTree
        ]);
    }


}
