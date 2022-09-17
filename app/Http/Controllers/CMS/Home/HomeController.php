<?php

namespace App\Http\Controllers\CMS\Home;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Models\PenilaianPrestasiKerjaApproval;

class HomeController extends Controller
{
    public function Home(Request $request)
    {

        return view('app.home.index');
    }

    public function Sign(Request $request, $code, $qrcode)
    {

        $PenilaianPrestasiKerjaApproval = PenilaianPrestasiKerjaApproval::where('uuid',$qrcode)
          ->with('user')
          ->with('penilaian_prestasi_kerja')
          ->first();

        return view('app.sign.index', [
          'data' => $PenilaianPrestasiKerjaApproval
        ]);
    }
}
