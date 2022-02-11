<?php

namespace App\Http\Controllers\CMS\ReportSkp;

use App\Http\Controllers\ReportSkp\ReportSkpBrowseController;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ReportSkpController extends Controller
{
    public function Home(Request $request)
    {

        $data = [];

        $ReportSkp = ReportSkpBrowseController::FetchBrowse($request);

        if(!empty($request->tahun)) $ReportSkp = $ReportSkp->where('tahun', $request->tahun);
        if(!empty($request->dari_bulan)) $ReportSkp = $ReportSkp->where('dari_bulan', $request->dari_bulan);
        if(!empty($request->sampai_bulan)) $ReportSkp = $ReportSkp->where('sampai_bulan', $request->sampai_bulan);

        $user = null;
        $user_penilai = null;

        if(!empty($request->user_id)) {
          $ReportSkp = $ReportSkp->where('user_id', $request->user_id);

          $user = User::where('id', $request->user_id)->with('jabatan')->with('golongan')->first();

          $is_staff = $user->jabatan->is_staff;
          $unit_kerja_id = $user->unit_kerja_id;

          if ($is_staff) {
            // ATASAN STAFF
            $user_penilai = User::where(function ($query) use($request) {
                $query->whereHas("jabatan", function ($query) use($request) {
                    $query->whereNull('is_staff');
                });
            })
            ->where('unit_kerja_id', $unit_kerja_id)
            ->with('jabatan')
            ->with('golongan')->first()
            ;

            // cetak($user_penilai->toArray());
            // die();

          } else {
              // ATASAN KEPALA
              $jabatan_parent_id = $user->jabatan->parent_id;
              $user_penilai = User::where('jabatan_id', $jabatan_parent_id)
                                ->with('jabatan')
                                ->with('golongan')
                                ->first();
          }
        }

        $ReportSkp = $ReportSkp->where('type', 'skp');
        $ReportSkp = $ReportSkp->get('fetch');

        $ParseData = [
            'data' => $ReportSkp,
            'tahun' => $request->tahun,
            'dari_bulan' => $request->dari_bulan,
            'sampai_bulan' => $request->sampai_bulan,
            'user' => $user,
            'user_penilai' => $user_penilai
        ];

        return view('app.report_skp.home.index', $ParseData);
    }
}
