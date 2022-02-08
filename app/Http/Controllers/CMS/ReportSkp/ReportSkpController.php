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

class ReportSkpController extends Controller
{
    public function Home(Request $request)
    {

        $data = [];

        $ReportSkp = ReportSkpBrowseController::FetchBrowse($request);
        $ReportSkp = $ReportSkp->where('type', 'skp');
        $ReportSkp = $ReportSkp->get('fetch');

        $ParseData = [
            'data' => $ReportSkp,
        ];
        return view('app.report_skp.home.index', $ParseData);
    }


}
