<?php

namespace App\Http\Controllers\ReportSkp;

use App\Models\PenilaianPrestasiKerjaItem;

use App\Traits\Browse;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class ReportSkpBrowseController extends Controller
{
    use Browse;

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
    }

    public function get(Request $request)
    {
        $PenilaianPrestasiKerjaItem = PenilaianPrestasiKerjaItem::where(function ($query) use($request) {
            if (isset($request->ArrQuery->type)) {
                $query->where('type', $request->ArrQuery->type);
            }
        })
        ->with('indikator_kinerja')
        ->with('indikator_tetap')
        ->orderBy('id', 'ASC')
        ->get();

        Json::set('data', $PenilaianPrestasiKerjaItem);
        return response()->json(Json::get(), 200);
    }
}
