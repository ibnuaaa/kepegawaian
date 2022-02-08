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
        $PenilaianPrestasiKerjaItem = DB::table('penilaian_prestasi_kerja_item as a')
            ->where(function ($query) use($request) {
                if (isset($request->ArrQuery->type)) {
                    $query->where('type', $request->ArrQuery->type);
                }

                if (isset($request->ArrQuery->user_id)) {
                    $query->where('e.user_id', $request->ArrQuery->user_id);
                }

                if (isset($request->ArrQuery->dari_bulan) &&isset($request->ArrQuery->tahun)) {
                  $query->where('e.tahun', '>=', $request->ArrQuery->tahun);
                  $query->where('e.bulan', '>=', $request->ArrQuery->dari_bulan);
                }

                if (isset($request->ArrQuery->sampai_bulan) &&isset($request->ArrQuery->tahun)) {
                  $query->where('e.tahun', '<=' , $request->ArrQuery->tahun);
                  $query->where('e.bulan', '<=' , $request->ArrQuery->sampai_bulan);
                }

            })
            ->select(
              'a.id',
              'a.type',
              'a.bobot',
              'a.target',
              'a.realisasi',
              'a.capaian',
              'a.nilai_kinerja',
              'b.name as nama_iki',
              'b.id as id_iki',
              'd.id as id_iku',
              'd.name as nama_iku'
            )
            ->join('indikator_kinerja as b', 'b.id', 'a.indikator_kinerja_id')
            ->join('indikator_kinerja as c', 'c.id', 'b.parent_id')
            ->join('indikator_kinerja as d', 'd.id', 'c.parent_id')
            ->join('penilaian_prestasi_kerja as e', 'e.id', 'a.penilaian_prestasi_kerja_id')
            ->whereNull('e.deleted_at')
            ->orderBy('d.id', 'asc')
            ->get();


        Json::set('data', $PenilaianPrestasiKerjaItem);
        return response()->json(Json::get(), 200);
    }
}
